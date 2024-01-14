<?php

namespace Telemetry\controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Telemetry\Support\AuthenticationService;

class LoginValidateUserController
{
    public function createHtmlOutput(object $container, object $request, object $response): void
    {
        $tainted_parameters = $request->getParsedBody();

        $login_view = $container->get('loginPageView');
        $view = $container->get('view');
        $settings = $container->get('settings');
        $validator = $container->get('validator');
        $login_model = $container->get('loginModel');

        $database_connection_settings = $settings['doctrine_settings'];
        $doctrine_queries = $container->get('doctrineSqlQueries');
        $email = $validator->sanitiseString($tainted_parameters['email']);
        $password = $validator->sanitiseString($tainted_parameters['password']);

        $isAuthenticated = $login_model->validateUserCredentials($database_connection_settings, $doctrine_queries, $email, $password);

        if ($isAuthenticated) {
            $response = $response->withRedirect('/display_message');
        } else {
            $response = $response->withRedirect('/login');
        }


        $login_view->createLoginPageView($view, $settings, $response, $isAuthenticated);
    }
}
