<?php

include_once("/home/laetitia/Rendu/PHP_Rush_MVC/Models/Users.php");
include_once("/home/laetitia/Rendu/PHP_Rush_MVC/Models/Articles.php");
include_once("/home/laetitia/Rendu/PHP_Rush_MVC/Models/Comments.php");

class AppController
{
    protected $table;

    function __construct()
    {

    }

    public function loadModel($model) //creates new object
    {
        return new $model;
    }

    public function render($file = null) //returns the path of the view file
    {
        // if($file != null) //layouts not used 
        // {
        //     $path = 'Location: /PHP_Rush_MVC/Views/Layouts/'.$file;
        //     if (file_exists($path) == false) 
        //     {
        //         return "file doesn't exist";
        //     }
        // }
        if($file != null) 
        {
            $path = '/home/laetitia/Rendu/PHP_Rush_MVC/Views/'.$this->table.'/'.$file;
            if (file_exists($path) == false) 
            {
                return "file doesn't exist";
            }
        }
        return $path;
    }

    public function beforeRender()
    {
        
    }

    protected function redirect($param)
    {

    }
}

?>