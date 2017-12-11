<?php

function autoloader($class)
{
    $path = "includes/{$class}.php";

    if (is_file($path) && ! class_exists($class)) {
        require_once($path);
    }
}

spl_autoload_register('autoloader');

function redirect($location)
{
    header("Location:{$location}");
}