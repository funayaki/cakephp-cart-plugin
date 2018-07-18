<?php
namespace Cart\Model\Table;

use Cake\Event\Event;
use Cake\Http\Exception\NotFoundException;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;

/**
 * Cart Model
 *
 * @author Florian Krämer
 * @copyright 2012 - 2014 Florian Krämer
 * @license MIT
 *
 * @property \Cart\Model\Entity\CartsItems CartsItems
 */
class CartsTable extends CartAppModel
{

    /**
     * Validation domain for translations
     *
     * @var string
     */
    public $validationDomain = 'cart';

    /**
     * Validation parameters
     *
     * @var array
     */
    public $validate = array(
        'name' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'required' => true, 'allowEmpty' => false,
                'message' => 'Please enter a name for your cart.'
            )
        ),
        'user_id' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'required' => true, 'allowEmpty' => false,
                'message' => 'You have to add a user id.'
            )
        )
    );

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('carts');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'className' => 'Users'
        ]);
        $this->hasMany('CartsItems', [
            'foreignKey' => 'cart_id',
            'className' => 'Cart.CartsItems'
        ]);
//        $this->hasMany('Orders', [
//            'foreignKey' => 'cart_id',
//            'className' => 'Cart.Orders'
//        ]);
    }

    /**
     * Checks if a cart is active or not
     *
     * @param string cart uuid
     * @return boolean
     */
    public function isActive($cartId = null)
    {
        if (empty($cartId)) {
            $cartId = $this->id;
        }

        $result = $this->find()
            ->where([
                $this->getAlias() . '.active' => 1,
                $this->getAlias() . '.' . $this->getPrimaryKey() => $cartId
            ])
            ->count();

        return (boolean)$result;
    }

    /**
     * Returns the active cart for a user, if there is no one it will create one and return it
     *
     * @param string user uuid
     * @param boolean $create
     * @return array
     */
    public function getActive($userId = null, $create = true)
    {
        $result = $this->find()
            ->contain(['CartsItems'])
            ->where([
                $this->getAlias() . '.active' => 1,
                $this->getAlias() . '.user_id' => $userId
            ])
            ->first();

        if (!empty($result)) {
            return $result;
        }

        if (!$create) {
            return false;
        }

        $this->create();
        $result = $this->save(array(
                $this->getAlias() => array(
                    'user_id' => $userId,
                    'active' => 1,
                    'name' => __d('cart', 'My cart'))
            )
        );

        $result[$this->getAlias()]['id'] = $this->getLastInsertId();
        return $result;
    }

    /**
     * Sets a cart as active cart in the case there multiple carts present for an user
     *
     * @throws \Cake\Http\Exception\NotFoundException
     * @param string $cartId
     * @param string $userId
     * @return boolean
     */
    public function setActive($cartId, $userId = null)
    {
        $result = $this->find()
            ->where([
                $this->getAlias() . '.' . $this->getPrimaryKey() => $cartId,
                $this->getAlias() . '.user_id' => $userId
            ])
            ->first();

        if (empty($result)) {
            throw new NotFoundException(__d('cart', 'Invalid cart!'));
        }

        if ($result[$this->getAlias()]['active'] == 1) {
            return false;
        }

        $this->updateAll(
            array('active' => 0),
            array('user_id' => $userId)
        );

        $result->active = 1;
        if ($this->save($result)) {
            return true;
        }
        return false;
    }

    /**
     * Returns a cart and its contents
     *
     * @throws \Cake\Http\Exception\NotFoundException
     * @param string $cartId
     * @param string $userId
     * @return array|\Cake\Datasource\EntityInterface|null
     */
    public function view($cartId = null, $userId = null)
    {
        $conditions = array(
            $this->getAlias() . '.' . $this->getPrimaryKey() => $cartId
        );

        if (!empty($userId)) {
            $conditions[$this->getAlias() . '.user_id'] = $userId;
        }

        $result = $this->find()
            ->contain(['CartsItems'])
            ->where($conditions)
            ->first();

        if (empty($result) && empty($userId)) {
            throw new NotFoundException(__d('cart', 'Cart not found!'));
        }

        return $result;
    }

    /**
     * Adds and updates an item if it already exists in the cart
     *
     * Passing this through to the join table model
     *
     * @param string $cartId
     * @param array $itemData
     * @return boolean
     */
    public function addItem($cartId, $itemData)
    {
        return $this->CartsItems->addItem($cartId, $itemData);
    }

    /**
     * Called from the CartManagerComponent when an item is removed from the cart
     *
     * Passing this through to the join table model
     *
     * @param string $cartId Cart UUID
     * @param $itemData
     * @return boolean
     */
    public function removeItem($cartId, $itemData)
    {
        return $this->CartsItems->removeItem($cartId, $itemData);
    }

    /**
     * Drops the cart an all it's items
     *
     * @param string $cartId
     * @return boolean
     */
    public function emptyCart($cartId)
    {
        return $this->delete($cartId);
    }

    /**
     * Checks if one of the items in the cart is not flagged as a virtual item and
     * requires by this shipping.
     *
     * Virtual means that it can be a download or a service or whatever else.
     *
     * @param array $cartItems Array of items in the cart
     * @return boolean
     */
    public function requiresShipping($cartItems = array())
    {
        if (!empty($cartItems)) {
            foreach ($cartItems as $cartKey => $cartItem) {
                if (!isset($cartItem['virtual']) || isset($cartItem['virtual']) && $cartItem['virtual'] == 0) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Calculates the totals of a cart
     *
     * @param array $data
     * @param array $options
     * @return array
     */
    public function calculateCart($data, $options = array())
    {
        $Event = new Event('Cart.beforeCalculateCart', $this, array('cartData' => $data));
        $this->getEventManager()->dispatch($Event);
        if ($Event->isStopped()) {
            return false;
        }

        if (!empty($Event->result)) {
            $data = $Event->result;
        }

        if (isset($data['CartsItems'])) {
            $data[$this->getAlias()]['item_count'] = count($data['CartsItems']);
        } else {
            $data[$this->getAlias()]['total'] = 0.00;
            return $data;
        }

        $cart[$this->getAlias()]['requires_shipping'] = $this->requiresShipping($data['CartsItems']);

        $data = $this->applyDiscounts($data);
        $data = $this->applyTaxRules($data);
        $data = $this->calculateTotals($data);

        $Event = new Event('Cart.afterCalculateCart', $this, array('cartData' => $data));
        $this->getEventManager()->dispatch($Event);
        if (!empty($Event->result)) {
            $data = $Event->result;
        }

        if (isset($data[$this->getAlias()][$this->getPrimaryKey()])) {
            $this->save($data, array(
                'validate' => false
            ));
        }

        return $data;
    }

    /**
     * Applies tax rules to the cart
     *
     * @param array $cartData
     * @return array
     */
    public function applyTaxRules($cartData)
    {
        $Event = new Event('Cart.applyTaxRules', $this, array(
            'cartData' => $cartData
        ));
        $this->getEventManager()->dispatch($Event);
        if (!empty($Event->result)) {
            return $Event->result;
        }
        return $cartData;
    }

    /**
     * Applies discount rules to the cart
     *
     * @param array $cartData
     * @return array
     */
    public function applyDiscounts($cartData)
    {
        $Event = new Event('Cart.applyDiscounts', $this, array(
            'cartData' => $cartData
        ));
        $this->getEventManager()->dispatch($Event);
        if (!empty($Event->result)) {
            return $Event->result;
        }
        return $cartData;
    }

    /**
     * Calculates the total amount of the cart
     *
     * @param array $cartData
     * @return array
     */
    public function calculateTotals($cartData)
    {
        $Event = new Event('Cart.calculateTotals', $this, array(
            'cartData' => $cartData
        ));
        $this->getEventManager()->dispatch($Event);
        if (!empty($Event->result)) {
            return $Event->result;
        }
        return $cartData;
    }

    /**
     * Merges an array of item data with the cart items in the database.
     *
     * This method needs to be called during the login process before the redirect
     * happens but after the user was authenticated if you want to take the items
     * from the non-logged in user into the users database cart.
     *
     * @param integer|string $cartId
     * @param array $cartItems
     * @return integer Number of merged items
     */
    public function mergeItems($cartId, $cartItems)
    {
        $dbItems = $this->CartsItems->find('all', array(
            'contain' => array(),
            'conditions' => array(
                'CartsItems.cart_id' => $cartId
            )
        ));

        $mergedItems = 0;
        foreach ($cartItems as $cartKey => $cartItem) {
            $matched = false;
            foreach ($dbItems as $dbItem) {
                if ($dbItem['CartsItems']['model'] == $cartItem['model'] && $dbItem['CartsItems']['foreign_key'] == $cartItem['foreign_key']) {
                    $this->CartsItems->save(array_merge($dbItem['CartsItems'], $cartItem));
                    $matched = true;
                    break;
                }
            }
            if ($matched === false) {
                $mergedItems++;
                $this->addItem($cartId, $cartItem);
            }
        }
        return $mergedItems;
    }

    /**
     * Add a new cart
     *
     * @param array $postData
     * @param $userId
     * @return boolean
     */
    public function add($postData, $userId = null)
    {
        if (!empty($userId)) {
            $postData['user_id'] = $userId;
        }

        $cart = $this->newEntity();
        $this->patchEntity($cart, $postData);
        $result = $this->save($cart);
        if ($result) {
            $cartId = $this->getLastInsertID();
            $result[$this->getAlias()][$this->getPrimaryKey()] = $cartId;
            if (isset($postData[$this->getAlias()]['active']) && $postData[$this->getAlias()]['active'] == 1) {
                $this->setActive($cartId, $userId);
            }
            return true;
        }
        return false;
    }

    /**
     * Checkout confirmation
     *
     * @param array $data
     * @return boolean
     */
    public function confirmCheckout($data)
    {
        return (isset($data[$this->getAlias()]['confirm_checkout']) && $data[$this->getAlias()]['confirm_checkout'] == 1);
    }

    /**
     * afterFind callback
     *
     * @param array
     * @param boolean
     * @return array
     */
    public function afterFind($results, $primary = true)
    {
        foreach ($results as &$result) {
            $result = $this->_unserializeFields(array('additional_data'), $result);
        }
        return $results;
    }

    /**
     * beforeSave callback
     *
     * @param  array $options , not used
     * @return boolean
     */
    public function beforeSave($options = array())
    {
        $this->data = $this->_serializeFields(
            array(
                'additional_data',
            ),
            $this->data
        );
        return true;
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->scalar('id')
            ->maxLength('id', 36)
            ->allowEmpty('id', 'create');

        // TODO
        $validator
            ->scalar('name')
            ->maxLength('name', 191)
            ->allowEmpty('name');

//        $validator
//            ->numeric('total')
//            ->allowEmpty('total');
//
//        $validator
//            ->boolean('active')
//            ->allowEmpty('active');
//
//        $validator
//            ->integer('item_count')
//            ->requirePresence('item_count', 'create')
//            ->notEmpty('item_count');
//
//        $validator
//            ->scalar('additional_data')
//            ->allowEmpty('additional_data');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
