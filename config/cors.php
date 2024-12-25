<?php

return [
    'paths' => ['api/*', 'etudiants'], // Ajoutez vos routes ici si nécessaire
    'allowed_methods' => ['*'],
    'allowed_origins' => ['*'], // Autorise toutes les origines
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => false,
];
