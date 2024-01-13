<?php
/**
 * Created by PhpStorm.
 * User: slim
 * Date: 13/10/17
 * Time: 12:33
 */

declare (strict_types = 1);

use DI\Container;


// callback function to make settings available in an array

return function (Container $container, string $app_dir)
{

    $app_url = dirname($_SERVER['SCRIPT_NAME']);

    $container->set(
        'settings',
        function()
        use ($app_dir, $app_url)
        {
            return [
                'application_name' => 'Telemetry Processing',
                'landing_page' => '/telemetry/',
                'signup_page' =>'/signup/',
                '$log_file_path' => '/p3t/phpappfolder/logs/',
                'css_path' => $app_url . '/css/standard.css',
                'displayErrorDetails' => true,
                'logErrorDetails' => true,
                'logErrors' => true,
                'addContentLengthHeader' => false,
                'mode' => 'development',
                'debug' => true,
                'bcrypt_cost' => 12,
                'bcrypt_algorithm' => PASSWORD_DEFAULT,
                'view' => [
                    'template_path' => $app_dir . 'templates/',
                    'cache_path' => $app_dir . 'cache/',
                    'twig' => [
                        'cache' => false,
                        'auto_reload' => true
                    ],
                ],
                'doctrine_settings' => [
                    'driver' => 'pdo_mysql',
                    'host' => 'localhost',
                    'dbname' => 'registered_users_db',
                    'port' => '3306',
                    'user' => 'registered_user',
                    'password' => 'registered_user_pass',
                    'charset' => 'utf8mb4'
                ],
                'm2m_service_url' => 'https://m2mconnect.ee.co.uk/orange-soap/services/MessageServiceByCountry?wsdl',

            ];
        }
    );
};
