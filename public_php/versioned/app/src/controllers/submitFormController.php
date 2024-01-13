<?php

namespace Telemetry\controllers;

class submitFormController
{
    public function createHtmlOutput(object $container, object $request, object $response): void
    {
        $homepage_view = $container->get('smsFormView');
        $view = $container->get('view');
        $settings = $container->get('settings');

        $homepage_view->createSubmitFormView($view, $settings, $response);


    }
}