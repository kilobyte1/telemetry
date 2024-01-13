<?php

/**
 * @autor Richard Kankam
 */

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;



// New route for the login page
$app->get(
    '/login',
    function(Request $request, Response $response)
    use ($app)
    {
        $container = $app->getContainer();

        $signup_page_controller = $container->get('loginPageController');
        $signup_page_controller->createHtmlOutput($container, $request, $response);
        return $response;
    }
);

// Route for handling the login form submission
//$app->post('/login', function (Request $request, Response $response) use ($app) {
//    $container = $app->getContainer();
//    $login_controller = $container->get('loginController');
//    return $login_controller->processLogin($request, $response);
//});