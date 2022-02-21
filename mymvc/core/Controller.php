<?php

namespace Core;

class Controller {
    public \Core\Request $request;
    
    public function __construct() {
        
    }
    public function view($template, $data = []){
        if (!empty($data)){
            foreach ($data as $key => $value) {
                $$key = $value;
            }
        }
        include_once __DIR__ . "/../app/View/" . $template . ".php";
    }
}
