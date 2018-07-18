<?php
namespace Cart\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Cart\Model\Table\ShippingMethodsTable;

/**
 * Cart\Model\Table\ShippingMethodsTable Test Case
 */
class ShippingMethodsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Cart\Model\Table\ShippingMethodsTable
     */
    public $ShippingMethods;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.cart.shipping_methods'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ShippingMethods') ? [] : ['className' => ShippingMethodsTable::class];
        $this->ShippingMethods = TableRegistry::get('ShippingMethods', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ShippingMethods);

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
}
