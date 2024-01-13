<?php

namespace Telemetry\controllers;

class SmsPageController
{

    public function createHtmlOutput(object $container, object $request, object $response): void
    {

        $sms_page_view = $container->get('smsPageView');
        $view = $container->get('view');
        $settings = $container->get('settings');

        $sms_page_view->createSMSPageView($view, $settings, $response);
    }
}