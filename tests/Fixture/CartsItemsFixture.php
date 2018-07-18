<?php
namespace Cart\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CartsItemsFixture
 *
 */
class CartsItemsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'string', 'length' => 36, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'cart_id' => ['type' => 'string', 'length' => 36, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'foreign_key' => ['type' => 'string', 'length' => 36, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'model' => ['type' => 'string', 'length' => 64, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'quantity' => ['type' => 'integer', 'length' => 4, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'name' => ['type' => 'string', 'length' => 191, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'price' => ['type' => 'float', 'length' => null, 'precision' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'virtual' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => '0', 'comment' => 'Virtual as a download or a service', 'precision' => null],
        'status' => ['type' => 'string', 'length' => 16, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => 'internal status, up to the app', 'precision' => null, 'fixed' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'quantity_limit' => ['type' => 'integer', 'length' => 8, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'additional_data' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => 'For serialized data', 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8mb4_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            [
                'id' => 'carts-item-1',
                'cart_id' => 'cart-1',
                'foreign_key' => 'item-1',
                'model' => 'Item',
                'quantity' => 1,
                'name' => 'Eizo Flexscan S2431W',
                'price' => 720.37,
                'additional_data' => serialize([]),
                'created' => '2012-01-01 12:30:00',
                'modified' => '2012-01-01 12:30:00',
            ],
            [
                'id' => 'carts-item-2',
                'cart_id' => 'cart-2',
                'foreign_key' => 'item-2',
                'model' => 'Item',
                'quantity' => 2,
                'name' => 'CakePHP',
                'price' => 999.10,
                'additional_data' => serialize([]),
                'created' => '2012-01-01 12:30:00',
                'modified' => '2012-01-01 12:30:00',
            ],
            [
                'id' => 'carts-item-3',
                'cart_id' => 'cart-2',
                'foreign_key' => 'item-3',
                'model' => 'Item',
                'quantity' => 15,
                'name' => 'Low quality code',
                'price' => 0.99,
                'additional_data' => serialize([]),
                'created' => '2012-01-01 12:30:00',
                'modified' => '2012-01-01 12:30:00',
            ],

        ];
        parent::init();
    }
}
