<?php
namespace Cart\Model\Behavior;

use Cake\ORM\Behavior;
use Cake\Utility\Hash;
use RuntimeException;

/**
 * Buyable Behavior
 *
 * @author Florian Krämer
 * @copyright 2012 - 2014 Florian Krämer
 * @license MIT
 */
class BuyableBehavior extends Behavior
{

    /**
     * Default settings
     * - recurring: Whether or not all items are recurring subscriptions [default: false]
     * - recurringField: Name of the boolean field containing 'is_recurring',
     * - priceField: Name of the field containing item's price [default: price]
     * - nameField: Name of the field containing item's name [default: $this->displayField]
     * - billingFrequencyField: Name of the field containing the billing frequency (if recurring) [default: billing_frequency]
     * - billingPeriodField: Name of the field containing the billing period (if recurring) [default: billing_period]
     * - maxQuantity: The maximum quantity of a single item an user can buy. Either an integer, or a field name (for a custom valueper row) [default: PHP_INT_MAX]
     *
     * @var array
     * @access protected
     */
    protected $_defaultConfig = array(
        'allVirtual' => false,
        'virtualField' => 'virtual',
        'priceField' => 'price',
        'nameField' => '', // Initialized in setup()
        'currencyField' => 'currency',
        'recurring' => false,
        'recurringField' => 'is_recurring',
        'billingFrequencyField' => 'billing_frequency',
        'billingPeriodField' => 'billing_period',
        'defaultCurrency' => 'USD',
        'maxQuantity' => PHP_INT_MAX
    );

    /**
     * Initialize
     *
     * @param array $config
     * @return void
     * @internal param AppModel $model
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        if (empty($this->getConfig('nameField'))) {
            $this->setConfig('nameField', $this->_table->getDisplayField());
        }

        $this->bindCartModel();
    }

    /**
     * Default method for additionalItemData model callback
     *
     * No additional data is returned by default. Create this method in your model
     * and return whatever you want to be end up in the additional data field.
     *
     * @param array $record Data returned by BuyableBehavior::beforeAddToCart(), usually passed through in BuyableBehavior::composeItemData()
     * @return mixed Data to be serialized as additional data for the current item, null otherwise
     * @access public
     */
    public function additionalBuyData($record = array())
    {
        return array();
    }

    /**
     * Binds the cart association if no HABTM assoc named 'Cart' already exists.
     *
     * @return void
     */
    public function bindCartModel()
    {
        extract($this->getConfig());
        if (!isset($this->_table->hasAndBelongsToMany['Cart'])) {
            $this->_table->belongsToMany('Cart', [
                'className' => 'Cart.Cart',
                'foreignKey' => 'foreign_key',
                'associationForeignKey' => 'cart_id',
                'joinTable' => 'carts_items',
                'with' => 'Cart.CartsItem'
            ]);
        }
    }

    /**
     * Checks if a model record exists
     *
     * @param array $data
     * @return bool
     */
    public function isBuyable($data)
    {
        return $this->_table->exists([
            $this->_table->getPrimaryKey() => $data['CartsItem']['foreign_key']
        ]);
    }

    /**
     * Model $Model, $data
     *
     * @param array $cartsItem
     * @return array
     */
    public function beforeAddToCart($cartsItem)
    {
        $record = $this->_table->find()
            ->where([
                $this->_table->getPrimaryKey() => $cartsItem['CartsItem']['foreign_key']
            ])
            ->first();

        return $this->composeItemData($record, $cartsItem);
    }

    /**
     * Creates a cart compatible item data array from the data coming from beforeAddToCart
     *
     * @param array $record
     * @param array $cartsItem
     * @return array
     * @throws RuntimeException
     */
    public function composeItemData($record, $cartsItem)
    {
        extract($this->getConfig());

        if (is_string($maxQuantity)) {
            if (!isset($record[$this->_table->getAlias()][$maxQuantity])) {
                throw new RuntimeException(__d('cart', 'Invalid model field {0} for maxQuantity!', $maxQuantity));
            }
            $maxQuantity = $record[$this->_table->getAlias()][$maxQuantity];
        }

        $result = array(
            'quantity_limit' => $maxQuantity,
            'is_virtual' => $allVirtual,
            'model' => $this->_table->getAlias(),
            'foreign_key' => $record[$this->_table->getPrimaryKey()],
            'name' => $record[$nameField],
            'price' => $record[$priceField],
            'additional_data' => serialize($this->_table->additionalBuyData($record))
        );

        return Hash::merge($cartsItem['CartsItem'], $result);
    }

}
