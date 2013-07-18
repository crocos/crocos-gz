<?php

if (!file_exists($configFile = __DIR__ . '/../config/config.php')) {
    echo "Error: config/config.php not found.\n";
    exit(255);
}

$config = require $configFile;
$scriptSrc = __DIR__ . '/../src/gzclient.app/Contents/Resources/script.src';
$scriptDst = __DIR__ . '/../src/gzclient.app/Contents/Resources/script';

$vars = [
    '{{ server_name }}' => preg_replace('#https?://#', '', $config['url']),
    '{{ client_version }}' => $config['client']['version'],
    '{{ client_user_agent }}' => $config['client']['user_agent'],
    '{{ client_app_name }}' => $config['client']['app_name'],
];

file_put_contents($scriptDst, replaceVars(file_get_contents($scriptSrc), $vars));

function replaceVars($string, $vars)
{
    return str_replace(array_keys($vars), array_values($vars), $string);
}
