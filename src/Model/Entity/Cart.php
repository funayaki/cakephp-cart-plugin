<?php
namespace Cart\Model\Entity;

use Cake\ORM\Entity;

/**
 * Cart Entity
 *
 * @property string $id
 * @property string $user_id
 * @property string $name
 * @property float $total
 * @property bool $active
 * @property int $item_count
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property string $additional_data
 *
 * @property \Cart\Model\Entity\User $user
 * @property \Cart\Model\Entity\CartsItem[] $carts_items
 * @property \Cart\Model\Entity\Order[] $orders
 */
class Cart extends Entity
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
        'user_id' => true,
        'name' => true,
        'total' => true,
        'active' => true,
        'item_count' => true,
        'created' => true,
        'modified' => true,
        'additional_data' => true,
        'user' => true,
        'carts_items' => true,
        'orders' => true
    ];
}
