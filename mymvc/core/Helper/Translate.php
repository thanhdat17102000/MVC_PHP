<?php

namespace Core\Helper;

class Translate implements \Core\Interfaces\ITranslate {
    private $data = [];
    
    public function __construct($path = "") {
        if ($path != ""){
            $this->load($path);
        }
        return $this;
    }
    
    public function load($path = ""){
        
    }

    public function translate($key = "") {
        
    }

    public function hasKey($key = "") {
        
    }
}
