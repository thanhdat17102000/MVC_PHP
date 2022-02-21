<?php

namespace Core;

class Request {

    public $controller = '';
    public $action = '';
    public $params = [];
    public $query = [];

    public function __construct() {
        return $this->init();
    }

    private function init() {
        $uri = $this->getUri();
        $uri = explode('?', $uri);

        $this->parseUri($uri[0]);

        if (isset($uri[1])) {
            $this->parseQuery($uri[1]);
        }

        return $this;
    }

    private function parseUri($uri) {
        $uri = explode('/', $uri);
        if (isset($uri[0])) {
            $this->controller = $uri[0];
        }
        if (isset($uri[1])) {
            $this->action = $uri[1];
        }
        if (isset($uri[2])) {
            unset($uri[0]);
            unset($uri[1]);
            $this->params = $uri;
        }

        if ($this->controller === '') {
            $this->controller = \App\Config\Routes::getDefaulController();
        }
        if ($this->action === '') {
            $this->action = \App\Config\Routes::getDefaulAction();
        }
        return $this;
    }

    private function getUri() {
        $uri = $_SERVER['REQUEST_URI'];
        $uri = ltrim($uri, '/');
        // For routes
        $routes = \App\Config\Routes::getRoutes();
        if (!empty($routes)) {
            foreach ($routes as $key => $route) {
                $regix = $route[\App\Config\Routes::KEY_FROM];
                $to = $route[\App\Config\Routes::KEY_TO];
                $mode = $route[\App\Config\Routes::KEY_MODE];

                $uriNew = preg_replace("/$regix/", $to, $uri);
                if ($uriNew != $uri) {
                    if ($mode == \App\Config\Routes::VALUE_MODE_REDIRECT) {
                        header('location: ' . \App\Config\Routes::getBaseUrl() . $uriNew);
                        return;
                    }
                    $uri = $uriNew;
                    break;
                }
            }
        }
        return $uri;
    }

    private function parseQuery($query = '') {
        if ($query == '') {
            $this->query = [];
            return;
        }
        $chuoi = explode("&", $query);
        foreach ($chuoi as $item) {
            $arr = explode("=", $item);
            $this->query[$arr[0]] = isset($arr[1]) ? $arr[1] : '';
        }
    }

}
