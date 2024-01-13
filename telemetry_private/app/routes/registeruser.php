<?php
/**
 * registeruser.php
 *
 * calculate the result
 *
 * produces a result according to the user entered values and calculation type
 *
 * Author: CF Ingrams
 * Email: <clinton@cfing.co.uk>
 * Date: 22/10/2015
 *
 * @author CF Ingrams <clinton@cfing.co.uk>
 */

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
//use Doctrine\DBAL\DriverManager;

$app->post(
    '/registeruser',
    function(Request $request, Response $response)
    use ($app)
    {
        $container = $app->getContainer();

        $registeruser_controller = $container->get('registerUserController');
        $registeruser_controller->createHtmlOutput($container, $request, $response);
        return $response;
    }
);
