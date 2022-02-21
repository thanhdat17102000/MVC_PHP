<?php
namespace Core\Interfaces;

interface ITranslate{
    public function __construct($path = "");
    public function load($path = "");
    public function translate($key = "");
    public function hasKey($key = "");
}