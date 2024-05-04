<?php

namespace Sjtech\SimpleRest;

use Sjtech\Router\RouterData;

class Router
{
    use RouterData;

    public static $routeFound = false;

    public static function initGet($route, $callback): bool
    {
        if (!self::$routeFound) {
            // Get current path uri from $_SERVER
            $currentRoute = self::getRoute();
            $dynamicParam = self::checkForDynamicParams($route);
            if ($dynamicParam != '') {
                $dynamicParamValue = self::getdynamicParamValue($currentRoute);
                if ($currentRoute == self::getDynamicRoute($route, $dynamicParamValue)) {
                    $callback($dynamicParamValue);
                    self::$routeFound = true;
                    return true;
                }
            } else if ($currentRoute == $route) {
                $callback();
                self::$routeFound = true;
                return true;
            }
        }

        return false;
    }

    public static function getRoute(): string
    {
        return $_SERVER["REQUEST_URI"];
    }

    /**
     * Getting dynamic params if user has defined them in the route
     *
     * @param [type] $userDefinedRoute
     * @return void
     */
    public static function checkForDynamicParams($userDefinedRoute): string
    {
        $regex = '/\([^)]+\)/';
        preg_match($regex, $userDefinedRoute, $matches);

        if (empty($matches)) {
            return '';
        }
        return $matches[0];
    }

    public static function getDynamicRoute($currentRoute, $dynamicParam): string
    {
        $url = preg_replace('~[^/]+$~', '', $currentRoute);
        // Add a new variable as the last segment
        $url .= $dynamicParam;
        return $url;
    }

    public static function getdynamicParamValue($currentRoute): string
    {
        $segments = explode('/', $currentRoute);
        // Get the last segment
        return end($segments);
    }
}
