<?php

namespace Telemetry\Views;
/**
 * View class for displaying telemetry messages.
 */
class DisplayMessageView
{
    /**
     * Constructor.
     */
    public function __construct()
    {

    }
    /**
     * Destructor.
     */

    public function __destruct()
    {

    }

    /**
     * Creates the telemetry message page view.
     *
     * @param object $view View instance for rendering.
     * @param array $settings Application settings.
     * @param object $response HTTP response object.
     *
     * @return void
     */

    public function createTelemetryMessagePageView($view, array $settings, $response): void
    {
        // Extract relevant settings
        $landing_page = $settings['landing_page'];
        $application_name = $settings['application_name'];
        $css_path = $settings['css_path'];

        // Render the view with provided parameters
        $view->render(
            $response,
            'display-messages.html.twig',
            [
                'css_path' => $css_path,
                'landing_page' => $landing_page,
                'action' => 'login',
                'method' => 'post',
                'initial_input_box_value' => null,
                'page_title' => $application_name,
                'page_heading_1' => $application_name,
                'page_heading_2' => 'Welcome back',
            ]);
    }
}
