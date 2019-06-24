<?php

// Public Routes
$app->get('/healthcheck', Solodev\App\Healthcheck::class)
    ->setName('healthcheck');

// Public Routes
$app->get('/', function ($request, $response, $args) { 
    return $response->withRedirect('/dashboard'); 
});

$app->get('/settings', Solodev\App\Settings::class)
    ->setName('Settings');

$app->get('/dashboard', Solodev\App\Dashboard::class)
    ->setName('dashboard');

$app->get('/404', Solodev\App\PageNotFound::class)
    ->setName('404');

// Login Routes
$app->get('/login', Solodev\App\Login::class)
    ->setName('login');

$app->get('/logout', Solodev\App\Logout::class)
    ->setName('logout');

$app->group('/forgot-password', function() use ($app) {
    $app->get('', Solodev\App\ForgotPassword::class)->setName('Forgot Password');
    $app->post('', 'Solodev\App\ForgotPassword:post')->setName('Forgot Password');
});

$app->group('/forgot-reset', function() use ($app) {
    $app->get('', Solodev\App\ForgotReset::class)->setName('Forgot Reset');
    $app->post('', 'Solodev\App\ForgotReset:post')->setName('Forgot Reset');
});

$app->group('/accept-invite', function() use ($app) {
    $app->get('', Solodev\App\AcceptInvite::class)->setName('Accept Invite');
    $app->post('', 'Solodev\App\AcceptInvite:post')->setName('Accept Invite');
});

$app->group('/filemanager', function() use ($app) {
    $app->get('', Solodev\App\Filemanager::class)->setName('Filemanager');
});

$app->get('/reset-password', Solodev\App\ResetPassword::class)
    ->setName('reset-password');

$app->get('/token-password', Solodev\App\TokenPassword::class)
  ->setName('token-password');

$app->get('/delete/{className}/{id}', Solodev\App\DeleteObject::class)
    ->setName('delete-object');