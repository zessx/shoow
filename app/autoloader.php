<?php

ini_set('include_path', ini_get('include_path') . ':./app/shoow');

define('ROOT_PATH',   __DIR__ . '/..');
define('TMPL_PATH',   __DIR__ . '/shoow/template');
define('PUBLIC_PATH', ROOT_PATH . '/public');
define('PUBLIC_URL',  '/public');

require_once(ROOT_PATH .'/vendor/simplehtmldom/simple_html_dom.php');


function autoloader($className){
    $parts = explode('\\', $className);
    $relative_path = strtolower(implode(DIRECTORY_SEPARATOR, $parts)) . '.php';
    $full_path = str_replace('autoloader.php', '', __FILE__) . $relative_path;
    if (is_file($full_path)) {
        require_once $full_path;
    }
}

spl_autoload_register('autoloader');