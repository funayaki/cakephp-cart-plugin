<?php
namespace Cart\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Cart\Model\Table\PaymentApiTransactionsTable;

/**
 * Cart\Model\Table\PaymentApiTransactionsTable Test Case
 */
class PaymentApiTransactionsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Cart\Model\Table\PaymentApiTransactionsTable
     */
    public $PaymentApiTransactions;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.cart.payment_api_transactions',
        'plugin.cart.orders'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('PaymentApiTransactions') ? [] : ['className' => PaymentApiTransactionsTable::class];
        $this->PaymentApiTransactions = TableRegistry::get('PaymentApiTransactions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PaymentApiTransactions);

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
