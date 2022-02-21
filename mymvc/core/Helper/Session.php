<?php

namespace Core\Helper;

class Session implements \Core\Interfaces\ISession {
    public function __construct() {
        return $this;
    }
    
    public function get($key = ''){
        return ($this->has($key)) ? $_SESSION[$key] : null;
    }
    public function has($key = ''){
        return (isset($_SESSION[$key])) ? true : false;
    }
    public function set($key = '', $value = ''){
        $_SESSION[$key] = $value;
        return $this;
    }
    public function remove($key = ''){
        unset($_SESSION[$key]);
        return $this;
    }
}
