<?php

namespace Core;

use Core\Request;
/**
 * Chương trình chính
 */
class App {

    public \Core\Controller $controller;
    public \Core\Request $request;

    /**
     * Khởi tạo chương trình chính, xây dựng request
     */
    public function __construct() {
        $this->request = new Request();
    }

    /**
     * Khởi chạy chương trình
     * 
     * <p>Gọi controller và action tương ứng dựa vào request</p>
     */
    public function run() {
        $class = '\\App\\Controller\\' . ($this->request->controller);
        $this->controller = new $class();
        $this->controller->request = $this->request;
        $action = $this->request->action;
        $this->controller->$action(...$this->request->params);
    }

}
