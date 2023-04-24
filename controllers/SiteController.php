<?php

namespace app\controllers;

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
            $this->redirect(['/site/index']);
        }

        $this->render('login');
    }

    public function reg()
    {
        if( $this->isAjax ){
            var_dump($this->post());
            die;
        }
        // var_dump($_SERVER);die;
        $this->render('reg');
    }
}