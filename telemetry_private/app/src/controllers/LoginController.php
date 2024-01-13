<?php

namespace Telemetry\controllers;


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Telemetry\Support\AuthenticationService;

class LoginController

{



    public function createHtmlOutput(object $container, object $request, object $response): void
    {
        $homepage_view = $container->get('loginPageView');
        $view = $container->get('view');
        $settings = $container->get('settings');

        $homepage_view->createLoginPageView($view, $settings, $response);


    }

}