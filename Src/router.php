<?php

class Router
{
    public $path;
    public $path_explode;

    public function parse_url()
    {
        $path = trim($_SERVER['REQUEST_URI'], '/');

        $path_explode = explode('/', $path);

        if($path_explode[0] == 'PHP_Rush_MVC' && $path_explode[1] == 'Controllers')
        {
            $url = array_shift($path_explode);
            $url = array_shift($path_explode);

            if(count($path_explode) < 2)
            {
                echo "missing arguments: Should be 2 minimum";
                return;
            }
            return $path_explode;            
        }
        else
        {
            echo "error. wrong path";
            return;
        }
    }
}


?>