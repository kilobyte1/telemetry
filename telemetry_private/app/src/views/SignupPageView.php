<?php

namespace Telemetry\Views;

/**
 * View class for creating the signup page view.
 */
class SignupPageView
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
     * Creates the signup page view.
     *
     * @param object $view View instance for rendering.
     * @param array $settings Application settings.
     * @param object $response HTTP response object.
     *
     * @return void
     */
    public function createSignupView($view, array $settings, $response): void
    {
        // Extracting relevant settings for the signup page
        $landing_page = $settings['landing_page'];
        $application_name = $settings['application_name'];
        $css_path = $settings['css_path'];
         // Render the signup page using the Twig template
        $view->render(
            $response,
            'signuppage.html.twig',
            [
                'css_path' => $css_path,
                'landing_page' => $landing_page,
                'action' => 'registeruser',
                'method' => 'post',
                'initial_input_box_value' => null,
                'page_title' => $application_name,
                'page_heading_1' => $application_name,
                'page_heading_2' => 'Sign Up for an Account'
            ]);
    }
}
