<?php

/**
 * AllComponentTest
 *
 * @author Florian Krämer
 * @copyright 2012 - 2014 Florian Krämer
 * @license MIT
 */
class AllComponentTest extends PHPUnit_Framework_TestSuite
{

    /**
     * suite method, defines tests for this suite.
     *
     * @return void
     */
    public static function suite()
    {
        $suite = new CakeTestSuite('All Model related class tests');
        $suite->addTestDirectory(__DIR__ . DS . 'Controller' . DS . 'Component' . DS);
        return $suite;
    }
}

