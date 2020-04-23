<?php

return [
    'settings' => [
        // Slim genereal settings
        'determineRouteBeforeAppMiddleware' => true,
        'displayErrorDetails' => true,
        'addContentLengthHeader' => false,
        // View settings (template engine Twig)
        'view' => [
            'template_path' => __DIR__ . '/../ui/'
        ],
        'app' => [
            'var1' => 'solodev',
            'var2' => 'Main',
        ]
    ]
];