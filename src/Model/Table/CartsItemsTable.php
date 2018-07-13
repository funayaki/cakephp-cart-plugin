<?php
namespace Cart\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CartsItems Model
 *
 * @property \Cart\Model\Table\CartsTable|\Cake\ORM\Association\BelongsTo $Carts
 *
 * @method \Cart\Model\Entity\CartsItem get($primaryKey, $options = [])
 * @method \Cart\Model\Entity\CartsItem newEntity($data = null, array $options = [])
 * @method \Cart\Model\Entity\CartsItem[] newEntities(array $data, array $options = [])
 * @method \Cart\Model\Entity\CartsItem|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Cart\Model\Entity\CartsItem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Cart\Model\Entity\CartsItem[] patchEntities($entities, array $data, array $options = [])
 * @method \Cart\Model\Entity\CartsItem findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CartsItemsTable extends Table
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

        $this->setTable('carts_items');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

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
