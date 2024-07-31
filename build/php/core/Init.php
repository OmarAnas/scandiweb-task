<?php

class Init
{
    public function __construct()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: access,content-type");
        header("Access-Control-Allow-Methods: GET,POST");
        header("Access-Control-Allow-Credentials: true");
        header('Content-Type: application/json');

        spl_autoload_register([$this,'autoloader']);
    }

    private function autoloader($class_name)
    {
        $paths = [
            '../controllers/',
            '../models/',
            '../models/FactoryModels/',
            '../helpers/',
             '../config/',
        ];

        foreach ($paths as $path) {
            $file = $path . $class_name . '.php';
            if (file_exists($file)) {
                require_once $file;
                return;
            }
        }
    }
}
