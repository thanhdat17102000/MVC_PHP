<?php

namespace App\Config;

class Routes {

    const KEY_FROM = 'from';
    const KEY_TO = 'to';
    const KEY_MODE = 'mode';
    
    const VALUE_MODE_DEFAULT = 'default';
    const VALUE_MODE_REDIRECT = 'redirect';

    public static function getRoutes() {
        return [
            [
                self::KEY_FROM => 'demo-(.+)-(.+)\.html',
                self::KEY_TO => 'Democtrl/index/$1/$2',
                self::KEY_MODE => self::VALUE_MODE_DEFAULT
            ]
        ];
    }

    public static function getDefaulController() {
        return 'Home';
    }

    public static function getDefaulAction() {
        return 'index';
    }
    
    public static function getBaseUrl() {
        return 'http://mymvc.com/';
    }

}
