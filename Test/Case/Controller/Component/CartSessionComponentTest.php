<?php

class CartSessionTestController extends Controller
{
    /**
     * uses property
     *
     * @var array
     */
    public $uses = array();

    /**
     * sessionId method
     *
     * @return string
     */
    public function sessionId()
    {
        return $this->Session->id();
    }

}

class CartSessionComponentTest extends TestCase
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
        'plugin.Cart.CartsItems'
    );

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        $_SESSION = null;
        $this->ComponentRegistry = new ComponentRegistry();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();
        Session::destroy();
    }

    /**
     * testWrite
     *
     * @return void
     */
    public function testWrite()
    {
        $Cart = new CartSessionComponent($this->ComponentRegistry);
        $Cart->addItem(array(
            'amount' => 10,
            'model' => 'Item',
            'foreign_key' => '1'));

        $Cart->addItem(array(
            'amount' => 1.21,
            'model' => 'Item',
            'foreign_key' => '2',
            'foo' => 'bar'));

        $result = $Cart->read();
        $this->assertEquals($result['CartsItem'], array(
            0 => array(
                'amount' => 10,
                'model' => 'Item',
                'foreign_key' => '1'),
            1 => array(
                'amount' => 1.21,
                'model' => 'Item',
                'foreign_key' => '2',
                'foo' => 'bar')));

        $Cart->addItem(array(
            'amount' => 2.21,
            'model' => 'Item',
            'foreign_key' => '2',
            'foo' => 'bar'));

        $result = $Cart->read();
    }

}
