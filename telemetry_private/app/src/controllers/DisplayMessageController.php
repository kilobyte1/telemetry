<?php

namespace Telemetry\controllers;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use RuntimeException;

class DisplayMessageController
{

    public function createHtmlOutput(object $container, object $request, object $response): void
    {
        $login_tainted_parameters = $request->getParsedBody();

        $displayMessageView = $container->get('displayMessagePageView');
        $view = $container->get('view');
        $settings = $container->get('settings');
        $validator = $container->get('validator');
        $telemetry_model = $container->get('messageValidationModel');
        $login_model = $container->get('loginModel');


        $soap_wrapper = $container->get('soapClientWrapper');
        $database_connection_settings = $settings['doctrine_settings'];
        $doctrine_queries = $container->get('doctrineSqlQueries');

        $email = $validator->sanitiseEmail($login_tainted_parameters['login_email']);
        $password = $validator->sanitiseString($login_tainted_parameters['login_password']);
        $isAuthenticated = $login_model->validateUserCredentials($database_connection_settings, $doctrine_queries, $email, $password);


        $telemetry_data = $telemetry_model->get_telemetry_message($soap_wrapper, $settings);

        $storage_result = $telemetry_model->saveTelemetryMessages($telemetry_data,$database_connection_settings, $doctrine_queries,$validator);
        $telemetry_messages = $doctrine_queries->getAllTelemetryMessages($database_connection_settings);

        if ($isAuthenticated) {
            $displayMessageView->createTelemetryMessagePageView($view, $settings, $response,$telemetry_messages, $isAuthenticated);
        } else {
            throw new RuntimeException('Authentication failed. Invalid email or password.');

        }

    }

}