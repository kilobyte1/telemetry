<?php

namespace Telemetry\Views;


class RegisterUserView
{
    public function __construct(){}

    public function __destruct(){}

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