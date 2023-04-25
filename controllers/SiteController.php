<?php

namespace app\controllers;

use app\models\User;
use app\models\Order;
use app\models\Tovar;

class SiteController extends AddController
{
    public function index()
    {
        if( !isset($_COOKIE['user']) ){
            $this->redirect(['/site/login']);
        }

        $this->render('index');
    }

    public function login()
    {
        if( isset($_COOKIE['user']) ){   
            $this->redirect(['/']);
        }
        
        if( $this->isAjax ){
            $model = new User();
            $arr = []; 
            if( strpos($this->post()['E-login'], '@') ){
                $arr = ['email' => $this->post()['E-login']];
            } else {
                $arr = ['login' => $this->post()['E-login']];
            }

            if( $results = $model->findOne($arr) ){
                $model->load($results);
                if($model->passwordVerify($this->post()['password'])){
                    $model->login();
                    return;
                }
            }
        }

        $this->render('login');
    }

    public function logout()
    {
        if( isset($_COOKIE['user']) ){
            setcookie('user', '', time()-1, '/');
        }
        $this->redirect(['/']);
    }

    public function reg()
    {
        if( isset($_COOKIE['user']) ){   
            $this->redirect(['/']);
        }
        
        if( $this->isAjax ){
            $model = new User();
            $model->load($this->post());
            if($user = $model->reg()){
                if( is_object($user) ){
                    if($user->login()){
                        return  $this->redirect(['/site/index']);
                    }
                }
            }
        }
        $this->render('reg');
    }

    public function dataAll()
    {
        $user = $_COOKIE['user'];
        $user = unserialize(base64_decode($user));
        $model = new User();
        $order = new Order();
        $data = $model->findOne(['login' => $user['login']]);
        $or = $order->findAll(['user_id' => $data['id']]);
        $query = [];
        foreach( $or as $value ){
            foreach( $value as $key => $val){
                if( $key == 'tovar_id' ){
                    $query[] = $val;
                }
            }
        }
        $tovar = new Tovar();
        $tov = $tovar->findAll(['in', 'id', $query], true);
        
        if( $data ){
            $this->renderAjax('data', ['user' => $data, 'order' => $or, 'tovar' => $tov]);
        }
    }
}