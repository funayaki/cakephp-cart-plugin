<?php
namespace Cart\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PaymentApiTransactions Model
 *
 * @property \Cart\Model\Table\OrdersTable|\Cake\ORM\Association\BelongsTo $Orders
 *
 * @method \Cart\Model\Entity\PaymentApiTransaction get($primaryKey, $options = [])
 * @method \Cart\Model\Entity\PaymentApiTransaction newEntity($data = null, array $options = [])
 * @method \Cart\Model\Entity\PaymentApiTransaction[] newEntities(array $data, array $options = [])
 * @method \Cart\Model\Entity\PaymentApiTransaction|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Cart\Model\Entity\PaymentApiTransaction patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Cart\Model\Entity\PaymentApiTransaction[] patchEntities($entities, array $data, array $options = [])
 * @method \Cart\Model\Entity\PaymentApiTransaction findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PaymentApiTransactionsTable extends Table
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

        $this->setTable('payment_api_transactions');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Orders', [
            'foreignKey' => 'order_id',
            'joinType' => 'INNER',
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
            ->scalar('token')
            ->maxLength('token', 191)
            ->requirePresence('token', 'create')
            ->notEmpty('token');

        $validator
            ->scalar('processor')
            ->maxLength('processor', 191)
            ->requirePresence('processor', 'create')
            ->notEmpty('processor');

        $validator
            ->scalar('type')
            ->maxLength('type', 191)
            ->requirePresence('type', 'create')
            ->notEmpty('type');

        $validator
            ->scalar('message')
            ->requirePresence('message', 'create')
            ->notEmpty('message');

        $validator
            ->scalar('file')
            ->allowEmpty('file');

        $validator
            ->integer('line')
            ->allowEmpty('line');

        $validator
            ->scalar('trace')
            ->allowEmpty('trace');

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
