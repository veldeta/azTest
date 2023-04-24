<?php
spl_autoload_register(function($class){
    $str = substr($class, strpos($class, '\\'));
    $class = str_replace(['\\', 'app'], ['/', APP], $class) . '.php';
    if(file_exists($class)){
        require $class;
    }
})
?>