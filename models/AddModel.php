<?php

namespace app\models;

use Exception;
use finfo;
use Reflection;
use ReflectionClass;

class AddModel extends \PDO
{

    public function __construct()
    {
        $con = require APP . '/config/db.php';

        parent::__construct($con['db'],$con['username'],$con['password']);
    }

    public function load($params)
    {
        $vars = get_class_vars(get_called_class());
        foreach( $vars as $key => $value ){
            if( isset($params[$key]) ){
                $this->$key = $params[$key];
            }
        }
    }

    public function findOne(array $select)
    {
        $arr = [];
        foreach( $select as $key => $value ){
            $arr[] = "$key = '$value'";
        }
        $str = implode(' and ',$arr);

        $query = "SELECT * FROM " . $this->tableName() . " WHERE $str";
        $prs = $this->prepare($query);
        $prs->execute();
        return $prs->fetch();
    }

    public function findAll(array $select, $in = false)
    {
        $arr = [];
        if( !$in ){
            foreach( $select as $key => $value ){
                $arr[] = "$key = '$value'";
            }
            $str = implode(' and ',$arr);
        } else {
            $str = $select[1] . ' ' . $select[0] . "(" . implode(',' ,$select[2]) . ")";
        }

        $query = "SELECT * FROM " . $this->tableName() . " WHERE $str";
        $prs = $this->prepare($query);
        $prs->execute();
        return $prs->fetchAll();
    }

    public function save()
    {
        $pol = [];
        $val = [];
        $vop = [];
        $ref = new ReflectionClass(get_class($this));
        foreach( get_class_vars(get_called_class()) as $key => $value ){
            $prop = $ref->getProperty($key);
            if($prop->isProtected()){
                if( $key != 'id' ){
                    $pol[] = $key;
                    $vop[] = "?";
                    $val[] = $this->$key; 
                }
            }
        }

        $pol = implode(',', $pol);
        $vop = implode(',', $vop);

        $query = "INSERT INTO {$this->tableName()} ($pol) VALUES ($vop)";
        $prepare = $this->prepare($query);
        if( $prepare->execute($val) ){
            return true;
        } else {
            return false;
        }
    }

    public function login()
    {
        $arr = [];
        $arr['login'] = $this->login;
        $arr['email'] = $this->email;
        $cookie = base64_encode(serialize($arr));

        return setcookie('user', $cookie, time() + 3600*24*30, '/');
    }
}