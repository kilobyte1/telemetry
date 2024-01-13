<?php

namespace Telemetry\controllers;


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Telemetry\Support\AuthenticationService;

/**
 * Controller for handling user login functionality.
 */
class LoginController

{
    /**
     * Creates HTML output for the login page.
     *
     * @param object $container Dependency injection container.
     * @param object $request HTTP request object.
     * @param object $response HTTP response object.
     *
     * @return void
     */

    public function createHtmlOutput(object $container, object $request, object $response): void
    {
        // Retrieve login page view, view renderer, and settings from the container
        $homepage_view = $container->get('loginPageView');
        $view = $container->get('view');
        $settings = $container->get('settings');


        // Generate and render the login page view
        $homepage_view->createLoginPageView($view, $settings, $response);


    }

}
