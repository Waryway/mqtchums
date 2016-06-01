<?php
namespace mqtchums;

use mqtchums\view\vError;

class Router
{
    public function __construct()
    {
        $this->routeUrl(ltrim(urldecode($_SERVER['REQUEST_URI']), '/'));
    }

    /**
     * Oh yes. I broke the rule, I allow use input to call a class.  But, ya know what i think it will be ok.
     *
     * @param string $target
     */
    public function routeUrl($target = "")
    {
        if ($target == "" || is_null($target)) {
            $target = 'Index';
        }

        $className = 'mqtchums\view\v' . strtoupper(substr($target, 0, 1)) . strtolower(substr($target, 1));
        $found = false;
        error_log('looking for: ' . $className);
        if (class_exists($className)) {
            $implements = class_implements($className);

            foreach ($implements as $interface) {
                if ($interface === 'mqtchums\interfaces\iView') {

                    $found = true;
                }
            }
        }
        if ($found) {
            error_log('Found: '. $className);
            /* @var $view \mqtchums\interfaces\iView */
            $view = new $className();
        } elseif (file_exists($target)) {
            error_log('Found: '. $target);
            \header('Content-Type: '.\mime_content_type($target));
            echo \file_get_contents($target);
            exit();
        } else {
            $view = new vError(404);
        }

        $view->render();
    }

}

?>
