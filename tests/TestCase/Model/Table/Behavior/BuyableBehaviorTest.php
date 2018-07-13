<?php
namespace Cart\Test\TestCase\Model\Table\Behavior;

use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * CartTestItemModel
 */
class CartTestItemModel extends Table
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
        'plugin.cart.carts',
        'plugin.cart.items',
        'plugin.cart.orders',
        'plugin.cart.carts_items'
    );

    /**
     * startUp
     *
     * @return void
     */
    public function setUp()
    {
        $this->Model = TableRegistry::get('CartTestItemModel');
        $this->Model->alias = 'Item';
    }

    /**
     * tearDown
     *
     * @return void
     */
    public function tearDown()
    {
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
