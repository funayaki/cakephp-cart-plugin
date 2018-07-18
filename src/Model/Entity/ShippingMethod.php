<?php
namespace Cart\Model\Entity;

use Cake\ORM\Entity;

/**
 * ShippingMethod Entity
 *
 * @property string $id
 * @property string $name
 * @property float $price
 * @property int $currency
 * @property int $position
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 */
class ShippingMethod extends Entity
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
        'price' => true,
        'currency' => true,
        'position' => true,
        'created' => true,
        'modified' => true
    ];
}
