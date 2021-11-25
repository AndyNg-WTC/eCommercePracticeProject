<?php

// Load Config
require_once 'config/config.php';

// Autoload Core Libraries
spl_autoload_register(function ($className) {
    $classPath = str_replace("\\", "/", $className);
    $filePath = dirname(__FILE__) . "/" . $classPath . ".php";
    if (file_exists($filePath)) {
        require_once $filePath;
    }
});
