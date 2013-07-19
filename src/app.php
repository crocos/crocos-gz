<?php
/**
 *
 */

use Silex\Provider\TwigServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use Gz\Application;

$config = require_once ROOT_DIR . '/config/config.php';

$app = new Application();
require_once ROOT_DIR . '/config/di.php';

// Define middlewares
$requiredLoginApi = function(Request $request) use($app) {
};

// FIXME monolog 使う
function gzlog()
{
    $log = ROOT_DIR . '/web/data/log';
    $vars = func_get_args();
    foreach ($vars as $var) {
        file_put_contents($log, var_export($var, true) . PHP_EOL, FILE_APPEND);
    }
}

$app->get('/data/{ymd}/{file}', function(Application $app, Request $request, $ymd, $file) {
    $basedir = ROOT_DIR . '/web/data/';
    $files = glob($basedir . "$ymd/$file*");
    if (count($files) == 0) {
        $fn = null;
    } else {
        $fn = '/data/' . str_replace($basedir, '', array_shift($files));
    }

    return $app->render('file.html.twig', array(
        'request'  => $request,
        'file'     => $fn,
    ));
});

$app->post('/upload{suffix}', function(Application $app, Request $request) use ($config) {
    // from client
    if ($image = $request->files->get('imagedata')) {
        if ($image->getError() != UPLOAD_ERR_OK) {
            return $app->json(['status' => 'failed', 'message' => $image->getErrorMessage()]);
        }
    } else {
        return new Response('Error', 500);
    }

    $ext = $image->getExtension();
    $name = sha1(uniqid() . $image->getClientOriginalName());

    $monthdir = (new DateTime())->format('Ymd');
    $basedir = ROOT_DIR . '/web/data/';
    if (!is_dir($basedir . $monthdir)) {
        mkdir($basedir . $monthdir);
    }

    $fn = $name . '.' . $ext;

    // TODO: service 化
    $file = $image->move("$basedir/$monthdir", $fn);
    $url = $config['url'] . "/data/$monthdir/$name";

    if (false !== strpos($request->headers->get('User-Agent'), $config['client']['user_agent'])) {
        if ($request->get('version') != $config['client']['version']) {
            $url = "Client version outdated. Please visit {$config['url']} and download new client. " . $url;
        }
        return $url;
    }
    return $app->json(['status' => 'success', 'url' => $url]);
})->assert('suffix', '.*');

$app->match('/', $fallback = function(Application $app, Request $request) {
    // 再読み込み時、または新規のスコア
    return $app->render('index.html.twig', array(
        'request'  => $request,
        'time'     => date('Y-m-d H:i:s'),
    ));
});
$app->get('/upload{suffix}', $fallback);

$app->match('/{_any}', $fallback)->assert('_any', '.*');

return $app;
