<?php
/**
 * RegisterUserController.php
 *
 *
 * @author CF Ingrams - cfi@dmu.ac.uk
 * @copyright De Montfort University
 * @package encryption
 */

namespace Telemetry\controllers;

class RegisterUserController
{

    public function createHtmlOutput(object $container, object $request, object $response): void
    {
        $tainted_parameters = $request->getParsedBody();

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

        $cleaned_parameters = $registeruser_model->cleanupParameters($validator, $tainted_parameters);

        $results['encrypted'] = $registeruser_model->encrypt($libsodium_wrapper, $cleaned_parameters);
        $results['encoded'] = $registeruser_model->encode($base64_wrapper, $results['encrypted'] );
        $results['hashed_password'] = $registeruser_model->hash_password($bcrypt_wrapper, $cleaned_parameters['password'], $settings);
        $results['decrypted'] = $registeruser_model->decrypt($libsodium_wrapper, $base64_wrapper, $results['encoded']);

        $storage_result = $registeruser_model->y($database_connection_settings, $doctrine_queries, $cleaned_parameters, $results['hashed_password']);
        $registeruser_view->createRegisterUserView($view, $response, $settings, $tainted_parameters, $cleaned_parameters, $results, $storage_result);
    }

}