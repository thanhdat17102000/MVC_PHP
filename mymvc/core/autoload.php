<?php

function appAutoload($class) {
    $ar = [
        [
            'prefix' => 'Core\\',
            'path' => __DIR__ . '/'
        ],
        [
            'prefix' => 'App\\',
            'path' => __DIR__ . '/../app/'
        ],
    ];

    foreach ($ar as $autoloadItem) {
        // Sửa prefix thành định dạng dúng
        $prefix = preg_quote($autoloadItem['prefix']);
        
        // Xóa prefix ra khỏi tên class
        $classWithoutPrefix = preg_replace('/^' . $prefix . '/', '', $class);
        
        // Sửa tên class thành định dạng đúng
        $classWithoutPrefix = str_replace('\\', DIRECTORY_SEPARATOR, $classWithoutPrefix);
        
        // Lấy tên file dựa vào tên class
        $file = $classWithoutPrefix . '.php';
        
        // Lấy đường dẫn đầy đủ của file
        $path = $autoloadItem['path'] . '/' . $file;
        
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
}

spl_autoload_register('appAutoload');