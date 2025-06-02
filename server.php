<?php

/**
 * Servidor Laravel para el servidor PHP incorporado (built-in)
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? ''
);

// Este archivo permite ejecutar el proyecto como lo haría el servidor Apache/Nginx
if ($uri !== '/' && file_exists(__DIR__.'/public'.$uri)) {
    return false;
}

require_once __DIR__.'/public/index.php'; 