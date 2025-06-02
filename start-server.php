<?php

// Intenta obtener el puerto de diferentes fuentes
$port = getenv('PORT');
if (!$port) {
    $port = isset($_ENV['PORT']) ? $_ENV['PORT'] : 8000;
}

// Asegurarse de que el puerto sea un número
$port = intval($port);
if ($port <= 0) {
    $port = 8000;
}

// Construir el comando
$command = sprintf(
    'php artisan serve --host=0.0.0.0 --port=%d',
    $port
);

// Mostrar información
echo "Starting Laravel development server on port {$port}...\n";
echo "Command: {$command}\n";

// Ejecutar el comando
passthru($command); 