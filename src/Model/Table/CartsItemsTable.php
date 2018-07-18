<?php
namespace Cart\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\Utility\Hash;
use Cake\Validation\Validator;
use InvalidArgumentException;

/**
 * CartsItems Model
 *
 * @author Florian Krämer
 * @copyright 2012 Florian Krämer
 * @license MIT
 */
class CartsItemsTable extends CartAppModel
{

    /**
     * Validation parameters
     *
     * @var array
     */
    public $validate = array(
        'cart_id' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'required' => true,
                'allowEmpty' => false
            )
        ),
        'name' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'required' => true,
                'allowEmpty' => false
            )
        ),
        'foreign_key' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'required' => true,
                'allowEmpty' => false
            )
        ),
        'model' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'required' => true,
                'allowEmpty' => false
            )
        ),
        'price' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'required' => true,
                'allowEmpty' => false
            )
        ),
        'quantity' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'required' => true,
                'allowEmpty' => false,
                'message' => 'You must enter a quantity'
            ),
            'naturalNumber' => array(
                'rule' => array('naturalNumber'),
                'required' => true,
                'allowEmpty' => false,
                'message' => 'Must be a natural number'
            )
        )
    );

    /**
     * Validates an item record set
     *
     * @param array $data
     * @param boolean $loggedIn
     * @return void
     */
    public function validateItem($data, $loggedIn = false)
    {
        if ($loggedIn === false) {
            unset($this->validate['cart_id']);
        }
        $this->set($data);
        return $this->validates();
    }

    /**
     * Adds and updates an item if it already exists in the cart
     *
     * @param string $cartId
     * @param array $itemData
     * @param array $options
     * @throws \InvalidArgumentException
     * @return \Cake\Datasource\EntityInterface|false
     */
    public function addItem($cartId, $itemData, $options = array())
    {
        $defaults = array(
            'validates' => true
        );
        $options = Hash::merge($defaults, $options);

        if (isset($itemData[$this->getAlias()])) {
            $itemData = $itemData[$this->getAlias()];
        }

        if (!isset($itemData['foreign_key']) || !isset($itemData['model'])) {
            throw new InvalidArgumentException(__d('cart', 'foreign_key or model is missing from the item data!'));
        }

        $item = $this->find()
            ->where([
                'cart_id' => $cartId,
                'model' => $itemData['model'],
                'foreign_key' => $itemData['foreign_key']
            ])
            ->first();

        if (empty($item)) {
            $item = array($this->getAlias() => $itemData);
            $item[$this->getAlias()]['cart_id'] = $cartId;
            $entity = $this->newEntity();
            $this->patchEntity($entity, $item);
        } else {
            $item[$this->getAlias()] = Hash::merge($item[$this->getAlias()], $itemData);
        }

        return $this->save($entity, array(
            'validates' => $options['validates']
        ));
    }

    /**
     * Called from the CartManagerComponent when an item is removed from the cart
     *
     * @throws \InvalidArgumentException
     * @param string $cartId Cart UUID
     * @param $itemData
     * @return boolean
     */
    public function removeItem($cartId, $itemData)
    {
        if (!isset($itemData['foreign_key']) || !isset($itemData['model'])) {
            throw new InvalidArgumentException(__d('cart', 'foreign_key or model is missing from the item data!'));
        }

        $item = $this->find()
            ->where([
                $this->getAlias() . '.cart_id' => $cartId,
                $this->getAlias() . '.model' => $itemData['model'],
                $this->getAlias() . '.foreign_key' => $itemData['foreign_key']
            ])
            ->first();

        if (empty($item)) {
            return false;
        }

        return $this->delete($item);
    }

    /**
     * moveItem
     *
     * @todo finish it
     * @return void
     */
    public function moveItem($fromCartId, $itemData, $toCartId)
    {
        $item = $this->find('first', array(
            'contain' => array(),
            'conditions' => array(
                $this->getAlias() . '.cart_id' => $fromCartId,
                $this->getAlias() . '.model' => $itemData['model'],
                $this->getAlias() . '.foreign_key' => $itemData['foreign_key']
            )
        ));
    }

    /**
     * Add
     *
     * @param array $data
     * @return void
     */
    public function add($data)
    {
        $result = $this->find('first', array(
            'conditions' => array(
                'cart_id' => $data[$this->getAlias()]['cart_id'],
                'foreign_key' => $data[$this->getAlias()]['foreign_key']
            )
        ));

        if (empty($result)) {

        }

        $data = array($this->getAlias() => array($data[$this->getAlias()]));
        foreach ($data as $item) {
            $entity = $this->newEntity();
            $this->patchEntity($entity, $item);
            $this->save($entity);
        }
    }

    /**
     * Merges two item arrays, used to merge cookie/sesssion/database cart item arrays to synchronize them
     *
     * This method just merges the arrays it does NOT write them to the database
     *
     * @param array $array1 The array the 2nd array gets merged into
     * @param array $array2 The array that will get merged into $array1 and override its item if present
     * @return array
     */
    public function mergeItems($array1, $array2)
    {
        if (!isset($array1[$this->getAlias()])) {
            $array1[$this->getAlias()] = array();
        }

        if (!isset($array2[$this->getAlias()])) {
            $array2[$this->getAlias()] = array();
        }

        foreach ($array1[$this->getAlias()] as $key1 => $item1) {
            foreach ($array2[$this->getAlias()] as $key2 => $item2) {
                if ($item2['foreign_key'] == $item1['foreign_key'] && $item2['model'] == $item1['model']) {
                    $array1[$this->getAlias()][$key1] = $item2;
                    unset($array2[$this->getAlias()][$key2]);
                    break;
                }
            }
        }

        if (!empty($array2)) {
            foreach ($array2[$this->getAlias()] as $key => $item) {
                $array1[$this->getAlias()][] = $item;
            }
        }

        return $array1;
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
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('carts_items');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        // TODO
        $this->addBehavior('CounterCache', [
            'Carts' => ['item_count']
        ]);

        $this->belongsTo('Carts', [
            'foreignKey' => 'cart_id',
            'className' => 'Cart.Carts'
        ]);
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

        $validator
            ->scalar('foreign_key')
            ->maxLength('foreign_key', 36)
            ->allowEmpty('foreign_key');

        $validator
            ->scalar('model')
            ->maxLength('model', 64)
            ->allowEmpty('model');

        $validator
            ->integer('quantity')
            ->allowEmpty('quantity');

        $validator
            ->scalar('name')
            ->maxLength('name', 191)
            ->allowEmpty('name');

        $validator
            ->numeric('price')
            ->allowEmpty('price');

        $validator
            ->boolean('virtual')
            ->allowEmpty('virtual');

        $validator
            ->scalar('status')
            ->maxLength('status', 16)
            ->allowEmpty('status');

        $validator
            ->integer('quantity_limit')
            ->requirePresence('quantity_limit', 'create')
            ->notEmpty('quantity_limit');

        $validator
            ->scalar('additional_data')
            ->allowEmpty('additional_data');

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
        $rules->add($rules->existsIn(['cart_id'], 'Carts'));

        return $rules;
    }
}
