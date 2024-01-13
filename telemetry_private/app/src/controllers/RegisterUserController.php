<?php
/**
 * RegisterUserController.php
 *
 * Controller for handling user registration functionality.
 * Manages data validation, encryption, encoding, and storage processes for user registration.
 *
 * @author CF Ingrams - cfi@dmu.ac.uk
 * @copyright De Montfort University
 * @package Encryption
 */


namespace Telemetry\controllers;

/**
 * Controller for user registration.
 */
class RegisterUserController
{
    /**
     * Processes the user registration request and creates HTML output for the registration page.
     *
     * @param object $container Dependency injection container.
     * @param object $request HTTP request object, containing user input.
     * @param object $response HTTP response object.
     *
     * @return void
     */
    public function createHtmlOutput(object $container, object $request, object $response): void
    {
        // Retrieve user input from request
        $tainted_parameters = $request->getParsedBody();

        // Retrieve services from the container
        $view = $container->get('view');
        $settings = $container->get('settings');
        $validator = $container->get('validator');
        $libsodium_wrapper = $container->get('libSodiumWrapper');
        $base64_wrapper = $container->get('base64Wrapper');
        $bcrypt_wrapper = $container->get('bcryptWrapper');

        $registeruser_model = $container->get('registerUserModel');
        $registeruser_view = $container->get('registerUserView');

        $database_connection_settings = $settings['doctrine_settings'];
        $doctrine_queries = $container->get('doctrineSqlQueries');

        // Clean and validate user input
        $cleaned_parameters = $registeruser_model->cleanupParameters($validator, $tainted_parameters);

        // Encrypt, encode, hash, and decrypt user data
        $results['encrypted'] = $registeruser_model->encrypt($libsodium_wrapper, $cleaned_parameters);
        $results['encoded'] = $registeruser_model->encode($base64_wrapper, $results['encrypted'] );
        $results['hashed_password'] = $registeruser_model->hash_password($bcrypt_wrapper, $cleaned_parameters['password'], $settings);
        $results['decrypted'] = $registeruser_model->decrypt($libsodium_wrapper, $base64_wrapper, $results['encoded']);

        $storage_result = $registeruser_model->storeUserDetails($database_connection_settings, $doctrine_queries, $cleaned_parameters, $results['hashed_password']);

        // Create and display the registration page view
        $registeruser_view->createRegisterUserView($view, $response, $settings, $tainted_parameters, $cleaned_parameters, $results, $storage_result);
    }
}
