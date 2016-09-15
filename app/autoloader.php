<?php

ini_set('include_path', ini_get('include_path') . ':./app/shoow');

require_once('/vendor/simplehtmldom/simple_html_dom.php');

define('TMPL_PATH',   __DIR__ . '/shoow/template/');
define('PUBLIC_PATH', __DIR__ . '/../../public/');
define('PUBLIC_URL',  '/public/');

function autoloader($className){
    $parts = explode('\\', $className);
    $relative_path = strtolower(implode(DIRECTORY_SEPARATOR, $parts)) . '.php';
    $full_path = str_replace('autoloader.php', '', __FILE__) . $relative_path;
    if (is_file($full_path)) {
        require_once $full_path;
    }
}

spl_autoload_register('autoloader');