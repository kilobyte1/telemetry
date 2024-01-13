<?php

/**
 * @autor Richard Kankam
 */

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;



// New route for the signup page
$app->get(
    '/signup',
    function(Request $request, Response $response)
    use ($app)
    {
    $container = $app->getContainer();

    $signup_page_controller = $container->get('signupPageController');
    $signup_page_controller->createHtmlOutput($container, $request, $response);
    return $response;
    }
);