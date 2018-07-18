<?php
namespace Cart\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OrderItems Model
 *
 * @property \Cart\Model\Table\OrdersTable|\Cake\ORM\Association\BelongsTo $Orders
 *
 * @method \Cart\Model\Entity\OrderItem get($primaryKey, $options = [])
 * @method \Cart\Model\Entity\OrderItem newEntity($data = null, array $options = [])
 * @method \Cart\Model\Entity\OrderItem[] newEntities(array $data, array $options = [])
 * @method \Cart\Model\Entity\OrderItem|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Cart\Model\Entity\OrderItem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Cart\Model\Entity\OrderItem[] patchEntities($entities, array $data, array $options = [])
 * @method \Cart\Model\Entity\OrderItem findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \Cake\ORM\Behavior\CounterCacheBehavior
 */
class OrderItemsTable extends Table
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

        $this->setTable('order_items');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('CounterCache', [
            'Orders' => ['order_item_count']
        ]);

        $this->belongsTo('Orders', [
            'foreignKey' => 'order_id',
            'className' => 'Cart.Orders'
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
            ->boolean('shipped')
            ->allowEmpty('shipped');

        $validator
            ->dateTime('shipping_date')
            ->allowEmpty('shipping_date');

        $validator
            ->numeric('total')
            ->requirePresence('total', 'create')
            ->notEmpty('total');

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
        $rules->add($rules->existsIn(['order_id'], 'Orders'));

        return $rules;
    }
}
