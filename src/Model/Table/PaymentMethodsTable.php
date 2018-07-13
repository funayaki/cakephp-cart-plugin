<?php
namespace Cart\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PaymentMethods Model
 *
 * @method \Cart\Model\Entity\PaymentMethod get($primaryKey, $options = [])
 * @method \Cart\Model\Entity\PaymentMethod newEntity($data = null, array $options = [])
 * @method \Cart\Model\Entity\PaymentMethod[] newEntities(array $data, array $options = [])
 * @method \Cart\Model\Entity\PaymentMethod|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Cart\Model\Entity\PaymentMethod patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Cart\Model\Entity\PaymentMethod[] patchEntities($entities, array $data, array $options = [])
 * @method \Cart\Model\Entity\PaymentMethod findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PaymentMethodsTable extends Table
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

        $this->setTable('payment_methods');
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
            ->scalar('alias')
            ->maxLength('alias', 191)
            ->allowEmpty('alias');

        $validator
            ->scalar('class')
            ->maxLength('class', 191)
            ->allowEmpty('class');

        $validator
            ->numeric('fee')
            ->allowEmpty('fee');

        $validator
            ->boolean('active')
            ->allowEmpty('active');

        $validator
            ->scalar('description')
            ->maxLength('description', 191)
            ->allowEmpty('description');

        $validator
            ->integer('position')
            ->allowEmpty('position');

        return $validator;
    }
}
