<?php

use app\controllers\AddController;

!defined('APP') && define('APP', $_SERVER['DOCUMENT_ROOT']);

include $_SERVER['DOCUMENT_ROOT'] . '/core/autoload.php';

(new AddController())->run();