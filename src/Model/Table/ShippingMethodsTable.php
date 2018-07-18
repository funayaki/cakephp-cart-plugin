<?php
namespace Cart\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ShippingMethods Model
 *
 * @method \Cart\Model\Entity\ShippingMethod get($primaryKey, $options = [])
 * @method \Cart\Model\Entity\ShippingMethod newEntity($data = null, array $options = [])
 * @method \Cart\Model\Entity\ShippingMethod[] newEntities(array $data, array $options = [])
 * @method \Cart\Model\Entity\ShippingMethod|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Cart\Model\Entity\ShippingMethod patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Cart\Model\Entity\ShippingMethod[] patchEntities($entities, array $data, array $options = [])
 * @method \Cart\Model\Entity\ShippingMethod findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ShippingMethodsTable extends Table
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

        $this->setTable('shipping_methods');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
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
            ->numeric('price')
            ->allowEmpty('price');

        $validator
            ->integer('currency')
            ->allowEmpty('currency');

        $validator
            ->integer('position')
            ->allowEmpty('position');

        return $validator;
    }
}
