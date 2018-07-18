<?php
namespace Cart\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Cart\Model\Table\PaymentMethodsTable;

/**
 * Cart\Model\Table\PaymentMethodsTable Test Case
 */
class PaymentMethodsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Cart\Model\Table\PaymentMethodsTable
     */
    public $PaymentMethods;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.cart.payment_methods'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('PaymentMethods') ? [] : ['className' => PaymentMethodsTable::class];
        $this->PaymentMethods = TableRegistry::get('PaymentMethods', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PaymentMethods);

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
