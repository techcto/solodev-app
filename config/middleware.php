<?php

use Tuupola\Middleware\JwtAuthentication;

$container = $app->getContainer();

$container["token"] = function ($container) {
    return new StdClass;
};

$container["JwtAuthentication"] = function ($container) {

    $publicKeyContents = file_get_contents(CORE_DIR."/clients/solodev/jwt/public.pem");

    return new JwtAuthentication([
        "path" => "/",
        "algorithm" => ["RS256"],
        "secure" => false, // needed if not doing https
        "ignore" => ["/healthcheck"],
        "secret" => $publicKeyContents,
        "logger" => $container["logger"],
        "attribute" => false,
        "relaxed" => ["127.0.0.1", "localhost"]
    ]);
};

$app->add("JwtAuthentication");
$app->add(new App\Middleware\SSLVerification($container));

//App Protection
$app->add($container->csrf);