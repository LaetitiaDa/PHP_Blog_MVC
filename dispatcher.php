<?php

class Dispatcher
{
    public $controller;
    public $action;

    public function dispatch($param)
    {
        $controller = $param[0];
        $action = $param[1];
        $controller = $controller.'Controller';

        if(class_exists($controller))
        {
            $new_controller = new $controller;

            if(method_exists($new_controller, $action))
            {
                $new_controller->$action();
            }
            else
            {
                echo "Invalid method";
            }
        }
        else
        {
            echo "Invalid class";
        }
    }
}


?>