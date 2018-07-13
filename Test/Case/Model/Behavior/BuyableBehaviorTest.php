<?php

/**
 * CartTestItemModel
 */
class CartTestItemModel extends Model
{

    public $useTable = 'items';
    public $alias = 'Item';

    /**
     * Behaviors
     *
     * @var array
     */
    public $actsAs = array(
        'Cart.Buyable' => array());
}

/**
 * CartsItem Test
 *
 * @property mixed Model
 * @author Florian Krämer
 * @copyright 2012 - 2014 Florian Krämer
 * @license MIT
 */
class BuyableBehaviorTest extends TestCase
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
     * startUp
     *
     * @return void
     */
    public function setUp()
    {
        $this->Model = ClassRegistry::init('CartTestItemModel');
        $this->Model->alias = 'Item';
    }

    /**
     * tearDown
     *
     * @return void
     */
    public function tearDown()
    {
        ClassRegistry::flush();
        unset($this->Model);
    }

    /**
     *
     */
    public function testBindCartModel()
    {
        $this->Model->bindCartModel();
    }

}
