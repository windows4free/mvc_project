<?php
namespace Utilities;

class Router {

    private static $routes = [
        "home" => "Controllers\\HomeController",
        "index" => "Controllers\\Index",

        "dashboard" => "Controllers\\DashboardController",

        "sec.login" => "Controllers\\LoginController",
    ];

    public static function resolve($route) {
        return self::$routes[$route] ?? "Controllers\\Error";
    }
}