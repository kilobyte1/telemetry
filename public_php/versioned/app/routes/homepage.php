<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get(
    '/',
    function(Request $request, Response $response)
    use ($app)
    {
        $container = $app->getContainer();

        $home_page_controller = $container->get('homePageController');
        $home_page_controller->createHtmlOutput($container, $request, $response);
        return $response;
    });


$app->post('/login', function ($request, $response) use ($app) {
    $isLoggedIn = true;  // Replace with your actual login logic

    if ($isLoggedIn) {
        // Redirect to the SMS page on successful login
        return $response
            ->withHeader('Location', $app->getRouteCollector()->getRouteParser()->urlFor('smspage'))
            ->withStatus(302); // 302 Found status code for redirect
    } else {
        // Handle login failure
        // You can render the login form again with an error message
        $container = $app->getContainer();
        $login_page_controller = $container->get('LoginPageController');
        $login_page_controller->createHtmlOutput($container, $request, $response, 'Invalid credentials. Please try again.');
        return $response;
    }
});

