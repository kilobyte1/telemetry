<?php


namespace Telemetry\controllers;

class SmsPageController
{
    public function createHtmlOutput(object $container, object $request, object $response): void
    {
        $homepage_view = $container->get('smsPageView');
        $view = $container->get('view');
        $settings = $container->get('settings');

        $homepage_view->createSmsPageView($view, $settings, $response);


    }

}
