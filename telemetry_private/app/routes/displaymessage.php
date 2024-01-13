<?php

global $app;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get('/display-message',
    function(Request $request, Response $response)
    use ($app)
    {
        $container = $app->getContainer();

        $display_message_controller = $container->get('displayMessagePageController');
        $display_message_controller->createHtmlOutput($container, $request, $response);
        return $response;
    }
);

    // Perform SOAP call and validate response
//    $soapResponse = $messageValidationModel->telemetry_message($soapWrapper, $container->get('settings')['wsdl']);
//    $message = $messageValidationModel->validateSoapResponse($soapResponse);

//
//
//    // Prepare data for the Twig template
//    $received_messages = [];
//
//    if ($message !== null) {
//        // Parse the XML message and populate $received_messages array
//        $xml = simplexml_load_string($message);
//
//        foreach ($xml->message as $messageElement) {
//            $received_messages[] = [
//                'source_number' => (string)$messageElement->source,
//                'destination_number' => (string)$messageElement->destination,
//                'received_time' => (string)$messageElement->received_time,
//                'bearer' => (string)$messageElement->bearer,
//                'message_ref' => (string)$messageElement->message_ref,
//                'switch' => (string)$messageElement->switch,
//                'fan_fwd_or_rvs' => (string)$messageElement->fan_fwd_or_rvs,
//                'heater_temp' => (string)$messageElement->temperature,
//                'keypad_number' => (string)$messageElement->keypad_no,
//            ];
//        }
//    }
//
//// Render the template and pass the data
//    return $container->get('view')->render($response, 'display-messages.html.twig', [
//        'received_messages' => $received_messages
//    ]);

//});



