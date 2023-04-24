<?php
namespace app\config;

class Result 
{
    public static function result($uri)
    {
        if( $uri == '/' ){
            return ['controller' => 'SiteController', 'action' => 'index'];
        }
        $arr = explode('/', $uri);
        $uri = ['controller' => ucfirst($arr[1]) . 'Controller', 'action' => $arr[2]];
        return $uri;
    }
}