<?php
namespace Core;

class Model
{
    public \Core\Db $db;
    public function __construct() {
        $this->db = new \Core\Db();
    }
}
