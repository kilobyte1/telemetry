<?php

namespace Telemetry\views;

class smsPageView
{
    public function __construct()
    {

    }

    public function __destruct()
    {
    }

    //function that creates the view of the message page
    public function createSMSPageView($view, array $settings, $response): void
    {
        $landing_page = $settings['landing_page'];
        $application_name = $settings['application_name'];
        $css_path = $settings['css_path'];

        $view->render(
            $response,
            'sms-form.html.twig',
            [
                'css_path' => $css_path,
                'landing_page' => $landing_page,
                'action' => 'submit-form',
                'method' => 'post',
                'initial_input_box_value' => null,
                'page_title' => $application_name,
                'page_heading_1' => $application_name,
                'page_heading_2' => 'SMS Form'
            ]);
    }
}