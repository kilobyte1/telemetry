<?php


$app->get(
'/submit-page',
    function(Request $request, Response $response)
    use ($app)
    {
        $container = $app->getContainer();

        $registeruser_controller = $container->get('submitFormController');
        $registeruser_controller->createHtmlOutput($container, $request, $response);
        return $response;
    }

);