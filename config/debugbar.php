<?php

return [
    'enabled' => env('DEBUGBAR_ENABLED', false),
    'except' => [
        'telescope*',
        'horizon*',
    ],
]; 