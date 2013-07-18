<?php
/**
 *
 */


$app = require_once dirname(__DIR__). '/src/bootstrap.php';

use Symfony\Component\HttpFoundation\Request;

$app['session']->start();
$app->run();

