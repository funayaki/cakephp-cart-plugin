<?php
namespace Cart\Model\Entity;

use Cake\ORM\Entity;

/**
 * OrderAddress Entity
 *
 * @property string $id
 * @property string $order_id
 * @property string $user_id
 * @property string $first_name
 * @property string $last_name
 * @property string $company
 * @property string $street
 * @property string $street2
 * @property string $city
 * @property string $zip
 * @property string $country
 * @property string $type
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property string $state
 *
 * @property \Cart\Model\Entity\Order $order
 * @property \Cart\Model\Entity\User $user
 */
class OrderAddress extends Entity
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
        'order_id' => true,
        'user_id' => true,
        'first_name' => true,
        'last_name' => true,
        'company' => true,
        'street' => true,
        'street2' => true,
        'city' => true,
        'zip' => true,
        'country' => true,
        'type' => true,
        'created' => true,
        'modified' => true,
        'state' => true,
        'order' => true,
        'user' => true
    ];
}
