<?php
namespace Cart\Test\TestCase\Model\Table;

use Cake\Event\EventManager;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Cake\Utility\Hash;
use Cart\Event\DefaultCartEventListener;
use Cart\Model\Table\CartsTable;

/**
 * Cart\Model\Table\CartsTable Test Case
 *
 *
 * @author Florian Krämer
 * @copyright 2012 - 2014 Florian Krämer
 * @license MIT
 *
 * @property \Cart\Model\Table\CartsTable Carts
 */
class CartsTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = array(
        'plugin.cart.carts',
        'plugin.cart.users',
        'plugin.cart.carts_items',
        'plugin.cart.orders',
        'plugin.cart.items'
    );

    /**
     * startUp
     *
     * @return void
     */
    public function setUp()
    {

        parent::setUp();
        $config = TableRegistry::exists('Carts') ? [] : ['className' => CartsTable::class];
        $this->Carts = TableRegistry::get('Carts', $config);
        $this->_detachAllListeners();
        EventManager::instance()->on(new DefaultCartEventListener());
    }

    /**
     * Detaches all listeners from the Cart events to avoid application level events changing the tests
     *
     * @return void
     */
    protected function _detachAllListeners()
    {
        $EventManager = EventManager::instance();
        $events = array(
            'Cart.beforeCalculateCart',
            'Cart.applyTaxRules',
            'Cart.applyDiscounts',
            'Cart.afterCalculateCart'
        );
        foreach ($events as $event) {
            $listeners = $EventManager->listeners($event);
            foreach ($listeners as $listener) {
                foreach ($listener['callable'] as $callable) {
                    $EventManager->detach($callable);
                }
            }
        }
    }

    /**
     * tearDown
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Carts);

        parent::tearDown();
    }

    /**
     * testInstance
     *
     * @return void
     */
    public function testInstance()
    {
        $this->assertInstanceOf('Cart\Model\Table\CartsTable', $this->Carts);
    }

    /**
     * testView
     *
     * @return void
     */
    public function testView()
    {
        $result = $this->Carts->view('cart-1');
        $this->assertInstanceOf('Cart\Model\Entity\Cart', $result);
        $this->assertEquals($result['Cart']['id'], 'cart-1');
    }

    /**
     * testView
     *
     * @expectedException \Cake\Http\Exception\NotFoundException
     * @return void
     */
    public function testViewNotFoundException()
    {
        $this->Carts->view('invalid-cart-id');
    }

    /**
     * testAddItem
     *
     * @return void
     */
    public function testAddItem()
    {
        $this->Carts->cartId = 1;
        $result = $this->Carts->addItem('cart-1',
            array(
                'name' => 'Eizo Flexscan S2431W',
                'model' => 'Item',
                'foreign_key' => 'item-1',
                'quantity' => 1,
                'price' => 52.00,
            )
        );
        $this->assertTrue(is_array($result));
        $this->assertEquals($result['CartsItem']['model'], 'Item');
        $this->assertEquals($result['CartsItem']['foreign_key'], 'item-1');
        $this->assertEquals($result['CartsItem']['quantity'], 1);
        $this->assertEquals($result['CartsItem']['price'], 52.00);
    }

    /**
     * testIsActive
     *
     * @return void
     */
    public function testIsActive()
    {
        $result = $this->Carts->isActive('cart-1');
        $this->assertTrue($result);
        $result = $this->Carts->isActive('cart-2');
        $this->assertFalse($result);
    }

    /**
     * testSetActive
     *
     * @return void
     */
    public function testSetActive()
    {
        $result = $this->Carts->setActive('cart-1', 'user-1');
        $this->assertFalse($result);
        $result = $this->Carts->setActive('cart-2', 'user-1');
        $this->assertTrue($result);
    }

    /**
     * testSetActiveNotFoundException
     *
     * @expectedException \Cake\Http\Exception\NotFoundException
     * @return void
     */
    public function testSetActiveNotFoundException()
    {
        $this->Carts->setActive('invalid-cart', 'user-1');
    }

    /**
     * testGetActive
     *
     * @return void
     */
    public function testGetActive()
    {
        $expected = array(
            'Cart' => array(
                'id' => 'cart-1',
                'user_id' => 'user-1',
                'name' => 'Default Cart',
                'total' => '720.37',
                'active' => true,
                'item_count' => '1',
                'created' => '2012-01-01 12:12:12',
                'modified' => '2012-01-01 12:12:12',
                'additional_data' => array()
            ),
            'CartsItem' => array(
                0 => array(
                    'id' => 'carts-item-1',
                    'cart_id' => 'cart-1',
                    'foreign_key' => 'item-1',
                    'model' => 'Item',
                    'quantity' => '1',
                    'name' => 'Eizo Flexscan S2431W',
                    'price' => '720.37',
                    'created' => '2012-01-01 12:30:00',
                    'modified' => '2012-01-01 12:30:00',
                    'additional_data' => 'a:0:{}'
                )
            )
        );
        $result = $this->Carts->getActive('user-1');
        $this->assertEquals($result, $expected);

        $result = $this->Carts->getActive('user-does-not-exist', false);
        $this->assertFalse($result);
    }

    /**
     * testRequiresShipping
     *
     * @return void
     */
    public function testRequiresShipping()
    {
        $items = array(
            array('foobar' => 'test'));
        $this->assertTrue($this->Carts->requiresShipping($items));

        $items = array(
            array('virtual' => 0));
        $this->assertTrue($this->Carts->requiresShipping($items));

        $items = array(
            array('virtual' => 1));
        $this->assertFalse($this->Carts->requiresShipping($items));
    }

    /**
     * testCalculateTotals
     *
     * @return void
     */
    public function testCalculateTotals()
    {
        $cart = array(
            'CartsItem' => array(
                array('price' => 12.01, 'quantity' => 2),
                array('price' => 21.10, 'quantity' => 1)
            )
        );
        $result = $this->Carts->calculateTotals($cart);
        $this->assertEquals($result['Cart']['total'], 45.12);
    }

    /**
     * testSyncWithSessionData
     *
     * @return void
     */
    public function testMergeItems()
    {
        $itemsBefore = $this->Carts->CartsItem->find('all', array(
            'contain' => array(),
            'conditions' => array(
                'cart_id' => 'cart-1')));

        $itemCount = count($itemsBefore);
        $sessionData = array(
            'Cart' => array(),
            'CartsItem' => array(
                // A new item to merge in
                array(
                    'name' => 'CakePHP',
                    'model' => 'Item',
                    'foreign_key' => 'item-2',
                    'quantity' => 1,
                    'price' => 999.10
                ),
                // Update an existing items quantity by +1
                array(
                    'model' => 'Item',
                    'foreign_key' => 'item-1',
                    'quantity' => 2,
                    'price' => 12
                )
            )
        );

        $result = $this->Carts->mergeItems('cart-1', $sessionData['CartsItem']);
        $this->assertEquals($result, 1);

        $itemsAfter = $this->Carts->CartsItem->find('all', array(
            'contain' => array(),
            'conditions' => array(
                'cart_id' => 'cart-1'
            )
        ));

        // Sort the items by name so that we can be sure an item is at a certain index in the array
        $itemsAfter = Hash::sort($itemsAfter, '{n}.CartsItem.name', 'desc');

        $this->assertEquals(count($itemsAfter), $itemCount + 1);
        $this->assertEquals($itemsAfter[0]['CartsItem']['name'], 'Eizo Flexscan S2431W');
        $this->assertEquals($itemsAfter[0]['CartsItem']['quantity'], 2);
    }

    /**
     * testAdd
     *
     * @return void
     */
    public function testAdd()
    {
        $data = array(
            'name' => 'test'
        );
        $result = $this->Carts->add($data, 'user-1');
        $this->assertTrue($result);
    }

    /**
     * testCalculateCart
     *
     * @return void
     */
    public function testCalculateCart()
    {
        $data = array(
            'Cart' => array(
                'id' => 'cart-1',
                'active' => true,
                'item_count' => '2',
            ),
            'CartsItem' => array(
                0 => array(
                    'id' => 'carts-item-1',
                    'cart_id' => 'cart-1',
                    'foreign_key' => 'item-1',
                    'model' => 'Item',
                    'quantity' => '1',
                    'name' => 'Eizo Flexscan S2431W',
                    'price' => '720.37',
                ),
                1 => array(
                    'id' => 'carts-item-2',
                    'cart_id' => 'cart-1',
                    'foreign_key' => 'item-2',
                    'model' => 'Item',
                    'quantity' => '15',
                    'name' => 'Some other Item',
                    'price' => '0.59',
                ),
            )
        );

        $result = $this->Carts->calculateCart($data);
        $this->assertEquals($result['Cart']['total'], 729.22);
    }

}