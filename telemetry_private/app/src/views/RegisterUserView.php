<?php

namespace Telemetry\Views;

/**
 * View class for creating the register user view.
 */

class RegisterUserView
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
     * Creates the register user view.
     *
     * @param object $view View instance for rendering.
     * @param object $response HTTP response object.
     * @param array $settings Application settings.
     * @param array $tainted_parameters User input parameters.
     * @param array $cleaned_parameters Cleaned user input parameters.
     * @param array $results Results of processing user input.
     * @param string $storage_result Result of storing user details.
     *
     * @return void
     */

    public function createRegisterUserView(
        object $view,
        object $response,
        array $settings,
        array $tainted_parameters,
        array $cleaned_parameters,
        array $results,
        string $storage_result
    ): void
    {
        // Extract relevant settings and information
        $libsodium_version = SODIUM_LIBRARY_VERSION;
        $application_name = $settings['application_name'];
        $landing_page = $settings['landing_page'];
        $css_path = $settings['css_path'];

        $view->render(
            $response,
            'register_user_result.html.twig',
            [
                'landing_page' => $landing_page,
                'css_path' => $css_path,
                'page_title' => $application_name,
                'page_heading_1' => 'New User Registration',
                'page_heading_2' => 'New User Registration',
                'username' => $tainted_parameters['username'],
                'userage' => $tainted_parameters['userage'],
                'password' => $tainted_parameters['password'],
                'email' => $tainted_parameters['email'],
                'sanitised_username' => $cleaned_parameters['sanitised_username'],
                'validated_userage' => $cleaned_parameters['validated_userage'],
                'cleaned_password' => $cleaned_parameters['password'],
                'sanitised_email' => $cleaned_parameters['sanitised_email'],
                'hashed_password' => $results['hashed_password'],
                'libsodium_version' => $libsodium_version,
                'storage_result' => $storage_result,
            ]);
    }
}
