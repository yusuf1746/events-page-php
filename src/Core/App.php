<?php declare(strict_types=1);

namespace App\Core;

class App {
    protected static $container;

    public static function setContainer($container) {
        static::$container = $container;
    }

    public static function container() {
        return static::$container;
    }
}