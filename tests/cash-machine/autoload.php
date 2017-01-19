<?php

spl_autoload_register(function ($class_name) {
    $class_name = strpos($class_name, '\\') !== false ? substr($class_name, strrpos($class_name, '\\')+1) : $class_name;
    $directorys = array(
        'classes/',
        'exceptions/',
        'interfaces/'
    );
    
    foreach($directorys as $directory)
    {
        if(file_exists($directory.$class_name . '.php'))
        {
            require_once($directory.$class_name . '.php');
            return;
        }            
    }
});

require_once("./vendor/autoload.php");

?>