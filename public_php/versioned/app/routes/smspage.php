<?php

/**
 * @autor Richard Kankam
 */

namespace Telemetry;


use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;



// New route for the signup page
$app->get(
    '/smspage',
    function(Request $request, Response $response)
    use ($app)
    {
        $container = $app->getContainer();

        $sms_page_controller = $container->get('smsPageController');
        $sms_page_controller->createHtmlOutput($container, $request, $response);
        return $response;
    })->setName('smspage');