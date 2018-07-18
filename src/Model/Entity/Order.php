<?php
namespace Cart\Model\Entity;

use Cake\ORM\Entity;

/**
 * Order Entity
 *
 * @property string $id
 * @property string $user_id
 * @property string $cart_id
 * @property string $cart_snapshot
 * @property string $token
 * @property string $processor
 * @property string $status
 * @property string $payment_reference
 * @property string $payment_status
 * @property float $transaction_fee
 * @property string $invoice_number
 * @property float $total
 * @property int $currency
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property int $order_item_count
 * @property string $order_number
 * @property string $shipping_address_id
 * @property string $billing_address_id
 *
 * @property \Cart\Model\Entity\BillingAddress $billing_address
 * @property \Cart\Model\Entity\ShippingAddress $shipping_address
 * @property \Cart\Model\Entity\User $user
 * @property \Cart\Model\Entity\Cart $cart
 * @property \Cart\Model\Entity\OrderAddress[] $order_addresses
 * @property \Cart\Model\Entity\OrderItem[] $order_items
 * @property \Cart\Model\Entity\PaymentApiTransaction[] $payment_api_transactions
 */
class Order extends Entity
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
        'cart_id' => true,
        'cart_snapshot' => true,
        'token' => true,
        'processor' => true,
        'status' => true,
        'payment_reference' => true,
        'payment_status' => true,
        'transaction_fee' => true,
        'invoice_number' => true,
        'billing_address' => true,
        'shipping_address' => true,
        'total' => true,
        'currency' => true,
        'created' => true,
        'modified' => true,
        'order_item_count' => true,
        'order_number' => true,
        'shipping_address_id' => true,
        'billing_address_id' => true,
        'user' => true,
        'cart' => true,
        'order_addresses' => true,
        'order_items' => true,
        'payment_api_transactions' => true
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
