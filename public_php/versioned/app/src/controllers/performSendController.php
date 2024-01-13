<?php

namespace Telemetry\controllers;

class performSendController
{
    public function createHtmlOutput(object $container, object $request, object $response): void
    {
        $homepage_view = $container->get('homePageView');
        $view = $container->get('view');
        $settings = $container->get('settings');



    }

}