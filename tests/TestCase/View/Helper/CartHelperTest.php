<?php

class CartHelperTest extends TestCase
{

    public function setUp()
    {
        parent::setUp();

        Configure::write('App.base', '');
        $this->Controller = new Controller();
        $this->View = new View($this->Controller);
        $this->Cart = new CartHelper($this->View);
        $this->Cart->Html = new HtmlHelper($this->View);
        $this->Cart->Form = new FormHelper($this->View);
        $this->Cart->request = new Request('/', false);
    }

    public function tearDown()
    {

    }

    public function testInput()
    {
        $this->Cart->input('1', 'Item');
    }
}
