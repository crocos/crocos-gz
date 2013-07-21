<?php
/**
 *
 */

namespace Gz;

use Silex\Application as SilexApplication;
use Monolog\Logger;

class Application extends SilexApplication
{
    use SilexApplication\TwigTrait;
    use SilexApplication\MonologTrait;

    public function debug($msg, $vars = []) {
        if (!is_array($msg)) {
            $this->log(vsprintf($msg, $vars), [], Logger::DEBUG);
        } else {
            $this->log('Debug variable: ' . var_export($msg, true), [], Logger::DEBUG);
        }
    }
}
