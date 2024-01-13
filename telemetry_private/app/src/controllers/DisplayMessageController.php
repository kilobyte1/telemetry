<?php

namespace Telemetry\controllers;

class DisplayMessageController
{
    public function createHtmlOutput(object $container, object $request, object $response): void
    {
        $displayMessage = $container->get('displayMessagePageView');
        $view = $container->get('view');
        $settings = $container->get('settings');

        $telemetry_model = $container->get('messageValidationModel');
        //$validator = $validator->get('');


        $soap_wrapper = $container->get('soapClientWrapper');
        $telemetry_data_xml = $telemetry_model->get_telemetry_message($soap_wrapper);

        $switch_data_1 = $telemetry_data['switch 1'] ?? null;
        $switch_data_2 = $telemetry_data['switch 2'] ?? null;
        $switch_data_3 = $telemetry_data['switch 3'] ?? null;
        $switch_data_4 = $telemetry_data['switch 4'] ?? null;
        $fan_data = $telemetry_data['fan'] ?? null;
        $heater_data = $telemetry_data['heater'] ?? null;
        $bearer_data = $telemetry_data['bearer'] ?? null;
        $source_data = $telemetry_data['source'] ?? null;


        $displayMessage->createTelemetryMessagePageView($view, $settings, $response);
    }
}