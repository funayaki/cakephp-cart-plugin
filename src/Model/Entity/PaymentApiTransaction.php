<?php
namespace Cart\Model\Entity;

use Cake\ORM\Entity;

/**
 * PaymentApiTransaction Entity
 *
 * @property string $id
 * @property string $order_id
 * @property string $token
 * @property string $processor
 * @property string $type
 * @property string $message
 * @property string $file
 * @property int $line
 * @property string $trace
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \Cart\Model\Entity\Order $order
 */
class PaymentApiTransaction extends Entity
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
        'token' => true,
        'processor' => true,
        'type' => true,
        'message' => true,
        'file' => true,
        'line' => true,
        'trace' => true,
        'created' => true,
        'order' => true
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'token'
    ];
}
