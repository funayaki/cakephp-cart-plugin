<?php
namespace Cart\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ItemsFixture
 *
 * @author Florian Krämer
 * @copyright 2012 - 2014 Florian Krämer
 * @license MIT
 */
class ItemsFixture extends TestFixture
{

    /**
     * Name
     *
     * @var string $name
     */
    public $name = 'Item';

    /**
     * Table
     *
     * @var array $table
     */
    public $table = 'items';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'string', 'null' => false, 'length' => 36, 'key' => 'primary'],
        'name' => ['type' => 'string', 'null' => false, 'default' => null],
        'price' => ['type' => 'float', 'null' => false, 'default' => null, 'length' => 8.2],
        'active' => ['type' => 'boolean', 'null' => false, 'default' => 0],
        'is_virtual' => ['type' => 'boolean', 'null' => false, 'default' => 0],
        'max_quantity' => ['type' => 'integer', 'null' => false, 'default' => 0],
        'min_quantity' => ['type' => 'integer', 'null' => false, 'default' => 0],
        'indexes' => [
            'PRIMARY' => ['column' => 'id', 'unique' => 1]
        ]
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
                'id' => 'item-1',
                'name' => 'Eizo Flexscan S2431W',
                'price' => '720.37',
                'active' => 1
            ],
            [
                'id' => 'item-2',
                'name' => 'CakePHP',
                'price' => '999.10',
                'active' => 1
            ],
            [
                'id' => 'item-3',
                'name' => 'Low quality code',
                'price' => '0.99',
                'active' => 1
            ],
        ];
        parent::init();
    }
}
