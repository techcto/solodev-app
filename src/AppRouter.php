<?php

// Public Routes
$app->get('/healthcheck', Solodev\App\Healthcheck::class)
    ->setName('healthcheck');

// Public Routes
$app->get('/', function ($request, $response, $args) { 
    return $response->withRedirect('/dashboard'); 
});

$app->get('/dashboard', \App\Dashboard::class)
    ->setName('dashboard');