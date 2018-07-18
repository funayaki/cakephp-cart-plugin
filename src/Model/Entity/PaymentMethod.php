<?php
namespace Cart\Model\Entity;

use Cake\ORM\Entity;

/**
 * PaymentMethod Entity
 *
 * @property string $id
 * @property string $name
 * @property string $alias
 * @property string $class
 * @property float $fee
 * @property bool $active
 * @property string $description
 * @property int $position
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 */
class PaymentMethod extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'name' => true,
        'alias' => true,
        'class' => true,
        'fee' => true,
        'active' => true,
        'description' => true,
        'position' => true,
        'created' => true,
        'modified' => true
    ];
}
