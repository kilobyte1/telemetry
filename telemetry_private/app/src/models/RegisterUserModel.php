<?php
/**
 * RegisterUserModel.php
 *
 * Model for storing validated user data in a storage location.
 *
 * Author: CF Ingrams
 * Email: <clinton@cfing.co.uk>
 * Date: 22/10/2017
 *
 * @package Telemetry\Models
 * @author CF Ingrams <clinton@cfing.co.uk>
 * @copyright CFI
 */

namespace Telemetry\Models;

use Doctrine\DBAL\DriverManager;
/**
 * Model class for registering user data.
 */
class RegisterUserModel
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

    public function __destruct() { }
    /**
     * Cleans up and validates parameters received from the user input.
     *
     * @param object $validator Validator instance for sanitization and validation.
     * @param array $tainted_parameters User input parameters.
     *
     * @return array Cleaned and validated parameters.
     */
    function cleanupParameters(object $validator, array $tainted_parameters): array
    {
        $cleaned_parameters = [];

        $tainted_username = $tainted_parameters['username'];
        $tainted_userage = $tainted_parameters['userage'];
        $tainted_email = $tainted_parameters['email'];

        $cleaned_parameters['password'] = $tainted_parameters['password'];
        $cleaned_parameters['sanitised_username'] = $validator->sanitiseString($tainted_username);
        $cleaned_parameters['validated_userage'] = $validator->validateInt($tainted_userage);
        $cleaned_parameters['sanitised_email'] = $validator->sanitiseEmail($tainted_email);
        return $cleaned_parameters;
    }
    /**
     * Encrypts sensitive data using libsodium.
     *
     * @param object $libsodium_wrapper LibsodiumWrapper instance for encryption.
     * @param array $cleaned_parameters Cleaned and validated parameters.
     *
     * @return array Encrypted data.
     */

    function encrypt(object $libsodium_wrapper, array $cleaned_parameters): array
    {
        $encrypted = [];
        $encrypted['encrypted_username_and_nonce'] = $libsodium_wrapper->encrypt($cleaned_parameters['sanitised_username']);
        $encrypted['encrypted_userage_and_nonce'] = $libsodium_wrapper->encrypt($cleaned_parameters['validated_userage']);
        $encrypted['encrypted_email_and_nonce'] = $libsodium_wrapper->encrypt($cleaned_parameters['sanitised_email']);

        return $encrypted;
    }
    /**
     * Encodes encrypted data using base64.
     *
     * @param object $base64_wrapper Base64Wrapper instance for encoding.
     * @param array $encrypted_data Encrypted data.
     *
     * @return array Encoded data.
     */
    function encode(object $base64_wrapper, array $encrypted_data): array
    {
        $encoded = [];
        $encoded['encoded_username'] = $base64_wrapper->encode_base64($encrypted_data['encrypted_username_and_nonce']['nonce_and_encrypted_string']);
        $encoded['encoded_userage'] = $base64_wrapper->encode_base64($encrypted_data['encrypted_userage_and_nonce']['nonce_and_encrypted_string']);
        $encoded['encoded_email'] = $base64_wrapper->encode_base64($encrypted_data['encrypted_email_and_nonce']['nonce_and_encrypted_string']);
        return $encoded;
    }

    /**
     * Hashes the user's password using Bcrypt.
     *
     * @param object $bcrypt_wrapper BcryptWrapper instance for password hashing.
     * @param string $password_to_hash Password to be hashed.
     * @param array $settings Configuration settings.
     *
     * @return string Hashed password.
     */
    function hash_password(object $bcrypt_wrapper, string $password_to_hash, array $settings): string
    {
        $hashed_password = $bcrypt_wrapper->createHashedPassword($password_to_hash, $settings);
        return $hashed_password;
    }
    /**
     * Decrypts encoded data.
     *
     * @param object $libsodium_wrapper LibsodiumWrapper instance for decryption.
     * @param object $base64_wrapper Base64Wrapper instance for decoding.
     * @param array $encoded Encoded data.
     *
     * @return array Decrypted data.
     */

    function decrypt(object $libsodium_wrapper, object $base64_wrapper, array $encoded): array
    {
        $decrypted_values = [];

        $decrypted_values['username'] = $libsodium_wrapper->decrypt(
            $base64_wrapper,
            $encoded['encoded_username']
        );

        $decrypted_values['email'] = $libsodium_wrapper->decrypt(
            $base64_wrapper,
            $encoded['encoded_email']
        );


        return $decrypted_values;
    }
    /**
     * Stores user details using Doctrine QueryBuilder.
     *
     * @param array $database_connection_settings Database connection settings.
     * @param object $doctrine_queries DoctrineSqlQueries instance for SQL queries.
     * @param array $cleaned_parameters Cleaned and validated parameters.
     * @param string $hashed_password Hashed password.
     *
     * @return string Result of the storage operation.
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
