<?php
namespace Cart\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Orders Model
 *
 * @property \Cart\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \Cart\Model\Table\CartsTable|\Cake\ORM\Association\BelongsTo $Carts
 * @property \Cart\Model\Table\ShippingAddressesTable|\Cake\ORM\Association\BelongsTo $ShippingAddresses
 * @property \Cart\Model\Table\BillingAddressesTable|\Cake\ORM\Association\BelongsTo $BillingAddresses
 * @property \Cart\Model\Table\OrderAddressesTable|\Cake\ORM\Association\HasMany $OrderAddresses
 * @property \Cart\Model\Table\OrderItemsTable|\Cake\ORM\Association\HasMany $OrderItems
 * @property \Cart\Model\Table\PaymentApiTransactionsTable|\Cake\ORM\Association\HasMany $PaymentApiTransactions
 *
 * @method \Cart\Model\Entity\Order get($primaryKey, $options = [])
 * @method \Cart\Model\Entity\Order newEntity($data = null, array $options = [])
 * @method \Cart\Model\Entity\Order[] newEntities(array $data, array $options = [])
 * @method \Cart\Model\Entity\Order|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Cart\Model\Entity\Order patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Cart\Model\Entity\Order[] patchEntities($entities, array $data, array $options = [])
 * @method \Cart\Model\Entity\Order findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class OrdersTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('orders');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'className' => 'Cart.Users'
        ]);
        $this->belongsTo('Carts', [
            'foreignKey' => 'cart_id',
            'className' => 'Cart.Carts'
        ]);
        $this->belongsTo('ShippingAddresses', [
            'foreignKey' => 'shipping_address_id',
            'className' => 'Cart.ShippingAddresses'
        ]);
        $this->belongsTo('BillingAddresses', [
            'foreignKey' => 'billing_address_id',
            'className' => 'Cart.BillingAddresses'
        ]);
        $this->hasMany('OrderAddresses', [
            'foreignKey' => 'order_id',
            'className' => 'Cart.OrderAddresses'
        ]);
        $this->hasMany('OrderItems', [
            'foreignKey' => 'order_id',
            'className' => 'Cart.OrderItems'
        ]);
        $this->hasMany('PaymentApiTransactions', [
            'foreignKey' => 'order_id',
            'className' => 'Cart.PaymentApiTransactions'
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
            ->scalar('cart_snapshot')
            ->allowEmpty('cart_snapshot');

        $validator
            ->scalar('token')
            ->maxLength('token', 32)
            ->allowEmpty('token');

        $validator
            ->scalar('processor')
            ->maxLength('processor', 64)
            ->allowEmpty('processor');

        $validator
            ->scalar('status')
            ->maxLength('status', 16)
            ->allowEmpty('status');

        $validator
            ->scalar('payment_reference')
            ->maxLength('payment_reference', 16)
            ->allowEmpty('payment_reference');

        $validator
            ->scalar('payment_status')
            ->maxLength('payment_status', 16)
            ->allowEmpty('payment_status');

        $validator
            ->numeric('transaction_fee')
            ->allowEmpty('transaction_fee');

        $validator
            ->scalar('invoice_number')
            ->maxLength('invoice_number', 64)
            ->allowEmpty('invoice_number');

        $validator
            ->scalar('billing_address')
            ->allowEmpty('billing_address');

        $validator
            ->scalar('shipping_address')
            ->allowEmpty('shipping_address');

        $validator
            ->numeric('total')
            ->allowEmpty('total');

        $validator
            ->integer('currency')
            ->allowEmpty('currency');

        $validator
            ->integer('order_item_count')
            ->requirePresence('order_item_count', 'create')
            ->notEmpty('order_item_count');

        $validator
            ->scalar('order_number')
            ->maxLength('order_number', 64)
            ->allowEmpty('order_number');

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
        $rules->add($rules->existsIn(['cart_id'], 'Carts'));
        $rules->add($rules->existsIn(['shipping_address_id'], 'ShippingAddresses'));
        $rules->add($rules->existsIn(['billing_address_id'], 'BillingAddresses'));

        return $rules;
    }
}
