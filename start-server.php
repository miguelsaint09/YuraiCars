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

echo "Starting server on port {$port}...\n";

// Cambiar al directorio public de Laravel
chdir(__DIR__ . '/public');

// Iniciar el servidor PHP directamente
$command = sprintf(
    'php -S 0.0.0.0:%d %s/server.php',
    $port,
    __DIR__
);

echo "Executing command: {$command}\n";
passthru($command); 