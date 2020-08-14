<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */

function out(...$obj){
    printLog($obj);
}
function printLog(...$objects)
{
    $out = new \Symfony\Component\Console\Output\ConsoleOutput();
    $printed = "";
    for ($i = 0; $i < sizeof($objects); $i ++) {
        $object = $objects[$i];
        $str = "";
        if (is_array($object)) {
            $str = implode(" ", $object);
        } else {
            $str = $object;
        }
        $printed .= " " . $str;
    }
    
    $out->writeln("Message from Terminal: " . $printed);
}

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

// This file allows us to emulate Apache's "mod_rewrite" functionality from the
// built-in PHP web server. This provides a convenient way to test a Laravel
// application without having installed a "real" web server software here.
if ($uri !== '/' && file_exists(__DIR__.'/public'.$uri)) {
    return false;
}

require_once __DIR__.'/public/index.php';
