<?php

// Public Routes
$app->get('/healthcheck', App\App\Healthcheck::class)
    ->setName('healthcheck');

$app->get('/', App\App\Dashboard::class)
    ->setName('dashboard');