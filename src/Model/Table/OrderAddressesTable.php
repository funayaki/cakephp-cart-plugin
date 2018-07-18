<?php
namespace Cart\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OrderAddresses Model
 *
 * @property \Cart\Model\Table\OrdersTable|\Cake\ORM\Association\BelongsTo $Orders
 * @property \Cart\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \Cart\Model\Entity\OrderAddress get($primaryKey, $options = [])
 * @method \Cart\Model\Entity\OrderAddress newEntity($data = null, array $options = [])
 * @method \Cart\Model\Entity\OrderAddress[] newEntities(array $data, array $options = [])
 * @method \Cart\Model\Entity\OrderAddress|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Cart\Model\Entity\OrderAddress patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Cart\Model\Entity\OrderAddress[] patchEntities($entities, array $data, array $options = [])
 * @method \Cart\Model\Entity\OrderAddress findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class OrderAddressesTable extends Table
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

        $this->setTable('order_addresses');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Orders', [
            'foreignKey' => 'order_id',
            'className' => 'Cart.Orders'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'className' => 'Cart.Users'
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
            ->scalar('first_name')
            ->maxLength('first_name', 128)
            ->allowEmpty('first_name');

        $validator
            ->scalar('last_name')
            ->maxLength('last_name', 128)
            ->allowEmpty('last_name');

        $validator
            ->scalar('company')
            ->maxLength('company', 128)
            ->allowEmpty('company');

        $validator
            ->scalar('street')
            ->maxLength('street', 128)
            ->allowEmpty('street');

        $validator
            ->scalar('street2')
            ->maxLength('street2', 128)
            ->allowEmpty('street2');

        $validator
            ->scalar('city')
            ->maxLength('city', 128)
            ->allowEmpty('city');

        $validator
            ->scalar('zip')
            ->maxLength('zip', 128)
            ->allowEmpty('zip');

        $validator
            ->scalar('country')
            ->maxLength('country', 2)
            ->allowEmpty('country');

        $validator
            ->scalar('type')
            ->maxLength('type', 2)
            ->allowEmpty('type');

        $validator
            ->scalar('state')
            ->maxLength('state', 191)
            ->allowEmpty('state');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
