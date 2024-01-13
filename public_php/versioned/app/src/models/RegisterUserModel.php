<?php
/**
 * Model.php
 *
 * stores the validated values in the relevant storage location
 *
 * Author: CF Ingrams
 * Email: <clinton@cfing.co.uk>
 * Date: 22/10/2017
 *
 *
 * @author CF Ingrams <clinton@cfing.co.uk>
 * @copyright CFI
 *
 */

namespace Telemetry\models;

use Doctrine\DBAL\DriverManager;

class RegisterUserModel
{

    public function __construct(){}

    public function __destruct() { }


    function cleanupParameters(object $validator, array $tainted_parameters): array
    {
        $cleaned_parameters = [];

        // Check if required fields are empty
        if (empty($tainted_parameters['password']) || empty($tainted_parameters['username']) || empty($tainted_parameters['userage']) || empty($tainted_parameters['email'])) {
            throw new \InvalidArgumentException("All fields are required. Please fill in all the fields.");
        }

        $tainted_username = $tainted_parameters['username'];
        $tainted_userage = $tainted_parameters['userage'];
        $tainted_email = $tainted_parameters['email'];

        $cleaned_parameters['password'] = $tainted_parameters['password'];
        $cleaned_parameters['sanitised_username'] = $validator->sanitiseString($tainted_username);
        $cleaned_parameters['validated_userage'] = $validator->validateInt($tainted_userage);
        $cleaned_parameters['sanitised_email'] = $validator->sanitiseEmail($tainted_email);
        return $cleaned_parameters;
    }





    function hash_password(object $bcrypt_wrapper, string $password_to_hash, array $settings): string
    {
        $hashed_password = $bcrypt_wrapper->createHashedPassword($password_to_hash, $settings);
        return $hashed_password;
    }



    /**
     *
     * Uses the Doctrine QueryBuilder API to store the sanitised user data.
     *
     * @param array $cleaned_parameters
     * @param string $hashed_password
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    function storeUserDetails(
        array $database_connection_settings,
        object $doctrine_queries,
        array $cleaned_parameters,
        string $hashed_password
    ): string
    {
        $storage_result = [];
        $store_result = '';

        $database_connection = DriverManager::getConnection($database_connection_settings);

        $queryBuilder = $database_connection->createQueryBuilder();

        $storage_result = $doctrine_queries::queryStoreUserData($queryBuilder, $cleaned_parameters, $hashed_password);

        if ($storage_result['outcome'] == 1)
        {
            $store_result = 'User data was successfully stored with the Doctrine ORM using the SQL query: ' . $storage_result['sql_query'];
        }
        else
        {
            $store_result = 'There appears to have been a problem when saving your details.  Please try again later.';

        }
        return $store_result;
    }
}
