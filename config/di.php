<?php
/**
 *
 */

use Silex\Provider\TwigServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\DoctrineServiceProvider;

use Monolog\Logger;

$app['config'] = $config;
$app['env'] = isset($app['config']['env']) ? $app['config']['env'] : 'prod';


// register session
$app->register(new SessionServiceProvider(), array());

// register Twig
$app->register(new TwigServiceProvider(), array(
    'twig.path'       => ROOT_DIR.'/views',
));
$app['twig'] = $app->share($app->extend('twig', function($twig, $app) use ($config) {
    $twig->addGlobal('env', $app['debug'] ? 'dev' : 'prod');
    $twig->addGlobal('config', $config);

    return $twig;
}));

$app->register(new Silex\Provider\MonologServiceProvider(), [
    'monolog.name' => 'gz',
    'monolog.logfile' => ROOT_DIR . '/logs/' . $app['env'] . '.log',
    'monolog.level' =>  $app['env'] === 'dev' ? Logger::DEBUG : Logger::ERROR,
]);

//$app['gz.upload_service'] = $app->share(function($app) {
//    return new UploadService(
//        $app['gz.upload_repository']
//    );
//});
