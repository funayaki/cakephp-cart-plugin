<?php
namespace Cart\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Cart\Model\Table\CartsItemsTable;

/**
 * Cart\Model\Table\CartsItemsTable Test Case
 */
class CartsItemsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Cart\Model\Table\CartsItemsTable
     */
    public $CartsItems;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.cart.carts_items',
        'plugin.cart.carts'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('CartsItems') ? [] : ['className' => CartsItemsTable::class];
        $this->CartsItems = TableRegistry::get('CartsItems', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CartsItems);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
