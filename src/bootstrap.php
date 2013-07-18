<?php
/**
 *
 */

if (!defined('ROOT_DIR')) {
    define('ROOT_DIR', dirname(__DIR__));
}

require_once ROOT_DIR . '/vendor/autoload.php';

return require_once ROOT_DIR . '/src/app.php';
