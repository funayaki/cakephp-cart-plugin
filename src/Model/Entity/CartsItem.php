<?php
namespace Cart\Model\Entity;

use Cake\ORM\Entity;

/**
 * CartsItem Entity
 *
 * @property string $id
 * @property string $cart_id
 * @property string $foreign_key
 * @property string $model
 * @property int $quantity
 * @property string $name
 * @property float $price
 * @property bool $virtual
 * @property string $status
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property int $quantity_limit
 * @property string $additional_data
 *
 * @property \Cart\Model\Entity\Cart $cart
 */
class CartsItem extends Entity
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
        'cart_id' => true,
        'foreign_key' => true,
        'model' => true,
        'quantity' => true,
        'name' => true,
        'price' => true,
        'virtual' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'quantity_limit' => true,
        'additional_data' => true,
        'cart' => true
    ];
}
