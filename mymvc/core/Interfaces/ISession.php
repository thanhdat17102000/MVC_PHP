<?php
namespace Core\Interfaces;

interface ISession{
    public function __construct();
    public function get($key = '');
    public function has($key = '');
    public function set($key = '', $value = '');
    public function remove($key = '');
}