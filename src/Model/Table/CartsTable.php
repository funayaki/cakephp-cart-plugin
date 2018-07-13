<?php
namespace Cart\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Carts Model
 *
 * @property \Cart\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \Cart\Model\Table\CartsItemsTable|\Cake\ORM\Association\HasMany $CartsItems
 * @property \Cart\Model\Table\OrdersTable|\Cake\ORM\Association\HasMany $Orders
 *
 * @method \Cart\Model\Entity\Cart get($primaryKey, $options = [])
 * @method \Cart\Model\Entity\Cart newEntity($data = null, array $options = [])
 * @method \Cart\Model\Entity\Cart[] newEntities(array $data, array $options = [])
 * @method \Cart\Model\Entity\Cart|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Cart\Model\Entity\Cart patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Cart\Model\Entity\Cart[] patchEntities($entities, array $data, array $options = [])
 * @method \Cart\Model\Entity\Cart findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CartsTable extends Table
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

        $this->setTable('carts');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'className' => 'Cart.Users'
        ]);
        $this->hasMany('CartsItems', [
            'foreignKey' => 'cart_id',
            'className' => 'Cart.CartsItems'
        ]);
        $this->hasMany('Orders', [
            'foreignKey' => 'cart_id',
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
            ->scalar('name')
            ->maxLength('name', 191)
            ->allowEmpty('name');

        $validator
            ->numeric('total')
            ->allowEmpty('total');

        $validator
            ->boolean('active')
            ->allowEmpty('active');

        $validator
            ->integer('item_count')
            ->requirePresence('item_count', 'create')
            ->notEmpty('item_count');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
