<?php
namespace Cart\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Cart\Model\Table\CartsItemsTable;

/**
 * Cart\Model\Table\CartsItemsTable Test Case
 *
 * @property \Cart\Model\Table\CartsItemsTable CartsItems
 * @author Florian Krämer
 * @copyright 2012 - 2014 Florian Krämer
 * @license MIT
 */
class CartsItemsTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = array(
        'plugin.cart.users',
        'plugin.cart.carts',
        'plugin.cart.items',
        'plugin.cart.orders',
        'plugin.cart.carts_items'
    );

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
     * testInstance
     *
     * @return void
     */
    public function testInstance()
    {
        $this->assertInstanceOf('Cart\Model\Table\CartsItemsTable', $this->CartsItems);
    }

    /**
     * testValidateItem
     *
     * @return void
     */
    public function testValidateItem()
    {
        $data = array(
            'foo' => 'bar'
        );
        $expected = array(
            'name' => array(
                (int)0 => 'required'
            ),
            'foreign_key' => array(
                (int)0 => 'required'
            ),
            'model' => array(
                (int)0 => 'required'
            ),
            'price' => array(
                (int)0 => 'required'
            ),
            'quantity' => array(
                (int)0 => 'You must enter a quantity'
            )
        );
        $result = $this->CartsItems->validateItem($data);
        $this->assertFalse($result);
        $this->assertEquals($this->CartsItems->validationErrors, $expected);

        $result = $this->CartsItems->validateItem(array(
                'name' => 'Eizo',
                'model' => 'CartsItem',
                'foreign_key' => 'item-1',
                'quantity' => 1,
                'price' => 52.00,
            )
        );
        $this->assertTrue($result);
    }

    /**
     * testMergeItems
     *
     * @return void
     */
    public function testMergeItems()
    {
        $data1 = array(
            'CartsItem' => array(
                0 => array(
                    'foreign_key' => 'asf123',
                    'model' => 'Foo')));

        $data2 = array(
            'CartsItem' => array(
                0 => array(
                    'foreign_key' => 'ufsfasf123',
                    'model' => 'Bar'),
                1 => array(
                    'foreign_key' => 'asf123',
                    'model' => 'Foo'),
                2 => array(
                    'foreign_key' => '1111111',
                    'model' => 'Foo'
                )
            )
        );

        $result = $this->CartsItems->mergeItems($data2, $data1);
        $this->assertEquals($result, array(
                'CartsItem' => array(
                    0 => array(
                        'foreign_key' => 'ufsfasf123',
                        'model' => 'Bar'),
                    1 => array(
                        'foreign_key' => 'asf123',
                        'model' => 'Foo'),
                    2 => array(
                        'foreign_key' => '1111111',
                        'model' => 'Foo')
                )
            )
        );

        $result = $this->CartsItems->mergeItems($data1, $data2);
        $this->assertEquals($result, array(
                'CartsItem' => array(
                    0 => array(
                        'foreign_key' => 'asf123',
                        'model' => 'Foo'),
                    1 => array(
                        'foreign_key' => 'ufsfasf123',
                        'model' => 'Bar'),
                    2 => array(
                        'foreign_key' => '1111111',
                        'model' => 'Foo')
                )
            )
        );
    }

    /**
     * testRemoveItem
     *
     * @return void
     */
    public function testRemoveItem()
    {
        $data = array(
            'foreign_key' => 'item-1',
            'model' => 'Item');
        $result = $this->CartsItems->removeItem('cart-1', $data);
        $this->assertTrue($result);

        $result = $this->CartsItems->find()
            ->where([
                'CartsItems.foreign_key' => 'item-1',
                'CartsItems.model' => 'Item',
                'CartsItems.cart_id' => 'cart-1'
            ])
            ->count();

        $this->assertEquals($result, 0);
    }

    /**
     * testAddItem
     *
     * @return void
     */
    public function testAddItem()
    {
        $result = $this->CartsItems->addItem('cart-1',
            array(
                'name' => 'Eizo',
                'model' => 'CartsItem',
                'foreign_key' => 'item-1',
                'quantity' => 1,
                'price' => 52.00,
            )
        );
        $this->assertInstanceOf('Cart\Model\Entity\CartsItem', $result);
        $this->assertEquals($result['CartsItem']['name'], 'Eizo');
        $this->assertEquals($result['CartsItem']['model'], 'CartsItem');
        $this->assertEquals($result['CartsItem']['foreign_key'], 'item-1');
        $this->assertEquals($result['CartsItem']['quantity'], 1);
        $this->assertEquals($result['CartsItem']['price'], 52.00);
    }

}
