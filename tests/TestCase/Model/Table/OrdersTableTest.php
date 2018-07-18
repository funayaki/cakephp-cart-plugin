<?php
namespace Cart\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Cart\Model\Table\OrdersTable;

/**
 * Cart\Model\Table\OrdersTable Test Case
 */
class OrdersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Cart\Model\Table\OrdersTable
     */
    public $Orders;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.cart.orders',
        'plugin.cart.users',
        'plugin.cart.carts',
        'plugin.cart.shipping_addresses',
        'plugin.cart.billing_addresses',
        'plugin.cart.order_addresses',
        'plugin.cart.order_items',
        'plugin.cart.payment_api_transactions'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Orders') ? [] : ['className' => OrdersTable::class];
        $this->Orders = TableRegistry::get('Orders', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Orders);

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
