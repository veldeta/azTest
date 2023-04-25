<?php
namespace app\controllers;

use app\config\Result;

class AddController 
{
    public $request_url;
    public $isPost;
    public $isAjax;
    private $config;

    public function __construct()
    {
        $this->request_url = $_SERVER['REQUEST_URI'];
        $this->isPost = $_SERVER['REQUEST_METHOD'] == 'POST';
        $this->isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']);
    }

    public function init(String $action)
    {
        if( method_exists($this,$action) ){
            $this->$action();
        } else {
            $this->render('404');
        }
    }

    public function config()
    {
        $this->config = require_once APP . '/config/main.php';
        session_start();
        $_SESSION['__cfds'] = password_hash($this->config['__cfds'], PASSWORD_DEFAULT);
    }

    public function run()
    {
        $this->config();
        $answer = Result::result($this->request_url);
        $class = __NAMESPACE__ . '\\' . $answer['controller'];
        (new  $class())->init($answer['action']);
    }

    public function render(String $view, $params = [])
    {
        $str = explode('\\',get_called_class());
        $str = $str[count($str) - 1];
        $str = strtolower(substr($str, 0, strpos($str, 'Controller')));

        $layouts = APP . '/views/layouts/main.php';
        $file = APP . '/views/' . $str. '/' . $view . '.php';

        if( file_exists($file) ){
            $content = $file;
        } else {
            $content = APP . '/error/404.php';
        }
        include $layouts;
    }

    public function renderAjax(string $view, $params = [])
    {
        $str = explode('\\',get_called_class());
        $str = $str[count($str) - 1];
        $str = strtolower(substr($str, 0, strpos($str, 'Controller')));
        $file = APP . '/views/' . $str. '/' . $view . '.php';
        if( file_exists($file) ){
            include $file;
        }
    }

    public function redirect(Array $url)
    {
        header('Location: ' . $url[0]);
        die;
    }

    public function post()
    {
        return $_POST;
    }
}
