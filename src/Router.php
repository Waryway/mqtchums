<?php
namespace mqtchums;


use mqtchums\view\vError;

class Router
{
    public function __construct()
    {
        /* @var $session \mqtchums\singleton\Session */

        $this->routeUrl(ltrim(urldecode($_SERVER['REQUEST_URI']), '/'));
    }

    /**
     * Oh yes. I broke the rule, I allow use input to call a class.  But, ya know what i think it will be ok.
     *
     * @param string $target
     */
    public function routeUrl($target = "")
    {
        /* @var $this->Session \mqtchums\singleton\Session */
       // $Session = \mqtchums\singleton\Session::inst();
       // $Session->Start();
      //  $this->Session = $Session;
        if ($target == "" || is_null($target)) {
            $target = 'Index';
        }

        $path = explode('/', $target);
        $targetName = array_shift($path);
        //error_log('Path: ' . print_r($path, true));
        $className = 'mqtchums\view\v' . strtoupper(substr($targetName, 0, 1)) . strtolower(substr($targetName, 1));
        $found = false;
        $args = [];
        for($i=0; $i< count($path); $i+=2)
        {
            if(isset($path[$i+1]))
            {
                $args[$path[$i]] = $path[$i+1];
            }
        }
        //error_log('looking for: ' . $className);


        if (file_exists($target)) {
            error_log('Found: ' . $target);
            \header('Content-Type: ' . \mime_content_type($target));
            echo \file_get_contents($target);
            exit();
        }
        else {
            while(count($path) > 1)
            {
                $subPathFile = implode('/', $path );
                if(file_exists($subPathFile))
                {
                    error_log('Found: ' . $subPathFile);
                    \header('Content-Type: ' . \mime_content_type($subPathFile));
                    echo \file_get_contents($subPathFile);
                    exit();
                }
                array_shift($path);
            }
            if (class_exists($className)) {
                $implements = class_implements($className);
                foreach ($implements as $interface) {
                    if ($interface === 'mqtchums\interfaces\iView') {

                        $found = true;
                    }
                }
            }

            if($found) {
                error_log('Found: '. $className);
                 /* @var $view \mqtchums\interfaces\iView */
                $view = new $className($args);
            }
            else {
                $view = new vError([404]);
            }
        }

        $view->render();
    }

}

?>
