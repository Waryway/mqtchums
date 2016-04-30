<?php
namespace mqtchums;

use mqtchums\view\vError;

class Router
{
    public function __construct()
    {
        $this->RouteUrl(ltrim($_SERVER["REQUEST_URI"],'/'));
    }

    /**
     * Oh yes. I broke the rule, I allow use input to call a class.  But, ya know what i think it will be ok.
     *
     * @param string $target
     */
    public function RouteUrl($target = "")
    {
        if($target == "" || is_null($target) )
        {
            $target = 'Index';
        }

        $className = 'mqtchums\view\v'.strtoupper(substr($target, 0,1)) . strtolower(substr($target,1));
        $found = false;
        if(class_exists($className)) {
            $implements = class_implements($className);

            foreach($implements as $interface)
            {
                if($interface === 'mqtchums\interfaces\iView')
                {
                    $found = true;
                }
            }
        }
        if($found){
            /* @var $view \mqtchums\interfaces\iView */
            $view = new $className();
        }
        else
        {
            $view = new vError(404);
        }

        $view->Render();
    }

}

?>