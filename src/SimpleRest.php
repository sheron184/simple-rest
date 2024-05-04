<?php

namespace Sjtech;

use Sjtech\SimpleRest\Router;

class SimpleRest
{
    public function get($route, $callback)
    {
        Router::initGet($route, $callback);
    }

    public function finish()
    {
        if (!Router::$routeFound) {
            echo "404: Not found";
        }
    }
}
