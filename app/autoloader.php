<?php

function autoloader($className){
    $parts = explode('\\', $className);
    $relative_path = strtolower(implode(DIRECTORY_SEPARATOR, $parts)) . '.php';
    $full_path = str_replace('autoloader.php', '', __FILE__) . $relative_path;
    if (is_file($full_path)) {
        require_once $full_path;
    }
}

spl_autoload_register('autoloader');