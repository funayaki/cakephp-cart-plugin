<?php
namespace Cart\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * Users Fixture
 *
 * @author Florian Krämer
 * @copyright 2012 - 2014 Florian Krämer
 * @license MIT
 */
class UsersFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = array(
        'id' => array('type' => 'string', 'null' => false, 'length' => 36, 'key' => 'primary'),
        'username' => array('type' => 'string', 'null' => false, 'default' => null),
        'email' => array('type' => 'string', 'null' => true, 'default' => null),
        'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
        'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
        'indexes' => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1))
    );
    // @codingStandardsIgnoreEnd

    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            [
                'id' => 1,
                'username' => 'user-1',
                'email' => 'user-1@carttest.com',
            ],
        ];
        parent::init();
    }
}
