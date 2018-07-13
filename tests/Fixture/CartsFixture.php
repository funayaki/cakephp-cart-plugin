<?php
namespace Cart\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CartsFixture
 *
 * @author Florian Krämer
 * @copyright 2012 - 2014 Florian Krämer
 * @license MIT
 */
class CartsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'string', 'length' => 36, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'user_id' => ['type' => 'string', 'length' => 36, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'name' => ['type' => 'string', 'length' => 191, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'total' => ['type' => 'float', 'length' => null, 'precision' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'active' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => '0', 'comment' => '', 'precision' => null],
        'item_count' => ['type' => 'integer', 'length' => 6, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
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
                'id' => 'cart-1',
                'user_id' => 'user-1',
                'name' => 'Default Cart',
                'total' => 720.37,
                'active' => 1,
                'item_count' => 1,
                'additional_data' => serialize([]),
                'created' => '2012-01-01 12:12:12',
                'modified' => '2012-01-01 12:12:12'
            ],
            [
                'id' => 'cart-2',
                'user_id' => 'user-1',
                'name' => 'Second Cart',
                'total' => '1000.00',
                'active' => 0,
                'item_count' => 3,
                'additional_data' => serialize([]),
                'created' => '2012-01-01 12:12:12',
                'modified' => '2012-01-01 12:12:12'
            ],
            [
                'id' => 'cart-3',
                'user_id' => 'user-2',
                'name' => 'Default Cart',
                'total' => '1000.00',
                'active' => 0,
                'item_count' => 1,
                'additional_data' => serialize([]),
                'created' => '2012-01-01 12:12:12',
                'modified' => '2012-01-01 12:12:12'
            ],
        ];
        parent::init();
    }
}
