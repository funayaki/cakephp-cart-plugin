<?php

use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

Router::plugin(
    'Cart',
    ['path' => '/'],
    function (RouteBuilder $routes) {

        $routes->prefix('admin', function (RouteBuilder $routes) {
            $routes->scope('/cart', [], function (RouteBuilder $routes) {
                $routes->fallbacks();
            });
        });
    }
);
