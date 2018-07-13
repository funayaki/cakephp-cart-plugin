<?php

class ShippingMethodTestCase extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = array(
        'plugin.Cart.Carts',
        'plugin.Cart.Items',
        'plugin.Cart.Orders',
        'plugin.Cart.OrderItems',
        'plugin.Cart.CartsItems',
        'plugin.Cart.OrderAddresses',
        'plugin.Cart.Users',
        'plugin.Cart.ShippingMethods'
    );

    /**
     * Test to run for the test case (e.g array('testFind', 'testView'))
     * If this attribute is not empty only the tests from the list will be executed
     *
     * @var array
     * @access protected
     */
    protected $_testsToRun = array();

    /**
     * setUp
     *
     * @return void
     */
    public function setUp()
    {
        $this->ShippingMethod = ClassRegistry::init('Cart.ShippingMethod');
        $fixture = new ShippingMethodFixture();
        $this->record = array('ShippingMethod' => $fixture->records[0]);
    }

    /**
     * tearDown
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ShippingMethod);
        ClassRegistry::flush();
    }

    /**
     * testInstance
     *
     * @return void
     */
    public function testInstance()
    {
        $this->assertTrue(is_a($this->ShippingMethod, 'ShippingMethod'));
    }

}
