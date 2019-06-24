<?php

namespace App\Middleware;

class SSLVerification
{

    public function __construct($container)
    {
        $this->container = $container;
    }
    /**
     * SSLVerification middleware invokable class
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param  callable                                 $next     Next middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke($request, $response, $next)
    {
        $settings = $this->container->get('settings');

        if ($settings['isSSL'] && !$settings['sslVerified']) {
            //Set SSL_VERIFIED, they are locked into being secure from now on
            if ($settings['clientSettingsEnvPath']) {
                $txt = PHP_EOL . 'SSL_VERIFIED=true' . PHP_EOL;
                file_put_contents($settings['clientSettingsEnvPath'], $txt, FILE_APPEND | LOCK_EX);
            }
        }

        if (!$settings['isSSL'] && $settings['solodev']['ssl_active'] && !strpos($_SERVER['REQUEST_URI'], 'healthcheck')) {
            //SSL_VERIFIED is on, they need to be redirected to use HTTPS using old school PHP
            
            $redirect_url = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            header("Location: $redirect_url");
            exit();
        }

        $response = $next($request, $response);
        return $response;
    }
}
