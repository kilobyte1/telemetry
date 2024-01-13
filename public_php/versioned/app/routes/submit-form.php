<?php


use Slim\Http\Request;
use Slim\Http\Response;
use Telemetry\Models\MessageModel;
use Telemetry\Support\SoapClientWrapper;

$app->post('/submit-form', function ($request, $response, $args) {
    global $container;
    $formData = $request->getParsedBody();

    // Extract form data
    $phoneNumber = isset($formData['phoneNumber']) ? $formData['phoneNumber'] : '';
    $messageContent = isset($formData['message']) ? $formData['message'] : '';

    // Create a MessageModel instance
    $message = new MessageModel($phoneNumber, $messageContent);

    // Make a SOAP request using the SoapClientWrapper
    try {
        $soapServiceUrl = $container->get('settings')['m2m_service_url'];
        $soapWrapper = new SoapClientWrapper($soapServiceUrl);

        $soapResponse = $soapWrapper->sendMessage($message);

        // Process the SOAP response

        // Redirect or render a success page
        return $response; //->withRedirect('/success');
    } catch (\Exception $e) {
        $error = 'Error: ' . $e->getMessage();
        return $response;
    }
});
