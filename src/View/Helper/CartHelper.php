<?php
namespace Cart\View\Helper;

use Cake\Utility\Hash;
use Cake\View\Helper;
use Cake\View\View;
use InvalidArgumentException;

/**
 * CartHelper
 *
 * @property \Cake\View\Helper\FormHelper Form
 * @author Florian Krämer
 */
class CartHelper extends Helper
{

    /**
     * Helpers
     *
     * @var array
     */
    public $helpers = array(
        'Html',
        'Form',
    );

    /**
     *
     */
    public $iterator = 0;

    /**
     * Composite list of item id and model of items that are in the cart session
     *
     * @var array
     */
    protected $_itemsInCart = array();

    /**
     * Construct method
     * @param  View $View the view object the helper is attached to.
     * @param  array $settings Array of settings.
     * @throws \Exception When the AjaxProvider helper does not implement a link method.
     */
    public function __construct(View $View, $settings = array())
    {
        parent::__construct($View, $settings);

        if (empty($this->_itemsInCart) && $this->request->session()->check('Cart.CartsItem')) {
            $items = $this->request->session()->read('Cart.CartsItem');
            $this->_itemsInCart = array();
            foreach ($items as $item) {
                $this->_itemsInCart[] = $item['foreign_key'] . '-' . $item['model'];
            }
        }
    }

    /**
     * Checks if an item exists in the cart session
     *
     * @param  string $id
     * @param  string $model
     * @return boolean
     */
    public function inCart($id, $model = '')
    {
        $item = $id . '-' . $model;
        return in_array($item, $this->_itemsInCart);
    }

    /**
     * Checks if an item exists in the cart session
     *
     * @param  string $id
     * @param  string $model
     * @return integer
     */
    public function quantity($id, $model = '')
    {
        if ($this->inCart($id, $model)) {
            $items = $this->request->session()->read('Cart.CartsItem');
            foreach ($items as $key => $item) {
                if ($item['foreign_key'] == $id && $item['model'] == $model) {
                    return $item['quantity'];
                }
            }
        }
        return 0;
    }

    /**
     * Input
     *
     * @param  $id
     * @param  $model
     * @param  array $options
     * @return void;
     */
    public function input($id, $model, $options = array())
    {
        $defaults = array('form');

        $string = $this->Form->input('Cart.' . $this->iterator . '.quantity', array(
            'type' => 'text',
            'label' => false,
            'default' => 1));
        $string .= $this->Form->hidden('Cart.' . $this->iterator . '.Model', array(
            'value' => $model
        ));
        $string .= $this->Form->hidden('Cart.' . $this->iterator . '.foreign_key', array(
            'value' => $id
        ));

        if (isset($options['div']) && $options['div'] !== false) {
            if (is_array($options['div'])) {
                $this->Html->div($string, $options['div']);
            } else {
                $this->Html->div($string, array(
                    'class' => 'cart-item-form'));
            }
        }
    }

    /**
     * Hidden
     *
     * @param  $name
     * @param  $value
     * @param  $options
     * @return void
     */
    public function hidden($name, $value, $options)
    {
        $options = array_merge($options, array('value' => $value));
        $this->Form->hidden($name, $options);
    }

    /**
     * Multi Input
     *
     * @param  $id
     * @param  $model
     * @return string
     */
    public function multiInput($id, $model = '')
    {
        $string = $this->Form->input('Cart.' . $this->iterator . '.quantity', array(
            'type' => 'text',
            'label' => false,
            'default' => 1));
        $string .= $this->Form->hidden('Cart.' . $this->iterator . '.Model', array(
            'value' => $model));
        $string .= $this->Form->hidden('Cart.' . $this->iterator . '.foreign_key', array(
            'value' => $id));
        $this->iterator++;

        return $string;
    }

    /**
     * Link
     *
     * @param  string $title
     * @param  array $url
     * @param  array $options
     * @throws \InvalidArgumentException
     * @return string
     */
    public function link($title, $url = array(), $options = array())
    {
        $urlDefaults = array(
            'controller' => $this->params['controller'],
            'action' => 'buy'
        );
        $optionDefaults = array(
            'class' => 'buy-link'
        );
        $url = Hash::merge($urlDefaults, $url);
        $options = Hash::merge($optionDefaults, $options);

        if (!isset($url['item'])) {
            throw new InvalidArgumentException(__d('cart', 'The 2nd argument $url array requires the item key to be present!'));
        }

        return $this->Html->link($title, $url, $options);
    }

    /**
     * Reset
     *
     * @return void
     */
    public function reset()
    {
        $this->iterator = 0;
    }

    /**
     * Returns the count of items in the current cart (session)
     *
     * @return integer
     */
    public function count()
    {
        return count($this->_itemsInCart);
    }

}
