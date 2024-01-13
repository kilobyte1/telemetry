<?php

namespace Telemetry\controllers;

class DisplayMessageController
{
    /**
     * Create HTML output for telemetry message display.
     *
     * @param object $container Dependency injection container.
     * @param object $request    Request object.
     * @param object $response   Response object.
     *
     * @return void
     */
    public function createHtmlOutput(object $container, object $request, object $response): void
    {
        // Dependency injection for required services
        $displayMessage = $container->get('displayMessagePageView');
        $view = $container->get('view');
        $settings = $container->get('settings');

        // Dependency injection for telemetry model and SOAP client wrapper
        $telemetry_model = $container->get('messageValidationModel');
        //$validator = $validator->get('');


        $soap_wrapper = $container->get('soapClientWrapper');

        // Get telemetry data XML from the model
        $telemetry_data_xml = $telemetry_model->get_telemetry_message($soap_wrapper);


        // Extract telemetry data for specific switches, fan, heater, bearer, and source
        $switch_data_1 = $telemetry_data['switch 1'] ?? null;
        $switch_data_2 = $telemetry_data['switch 2'] ?? null;
        $switch_data_3 = $telemetry_data['switch 3'] ?? null;
        $switch_data_4 = $telemetry_data['switch 4'] ?? null;
        $fan_data = $telemetry_data['fan'] ?? null;
        $heater_data = $telemetry_data['heater'] ?? null;
        $bearer_data = $telemetry_data['bearer'] ?? null;
        $source_data = $telemetry_data['source'] ?? null;

        // Create telemetry message page view
        $displayMessage->createTelemetryMessagePageView($view, $settings, $response);
    }
}
