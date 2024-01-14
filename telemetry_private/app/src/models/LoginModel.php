<?php

namespace Telemetry\Models;


use Doctrine\DBAL\DriverManager;
use Telemetry\Support\BcryptWrapper;

class LoginModel
{

    public function __construct(){

    }

    public function __destruct() { }

    public function validateUserCredentials(
        array $database_connection_settings,
        object $doctrine_queries,
        string $email,
        string $password
    ): bool
    {
        $database_connection = DriverManager::getConnection($database_connection_settings);
        $allUserData = $doctrine_queries::getAllUserData($database_connection->createQueryBuilder());

        $bcryptWrapper = new BcryptWrapper();

        foreach ($allUserData as $userData) {
            if ($userData['email'] === $email && $bcryptWrapper->authenticatePassword($password, $userData['password'])) {
                return true;
            }
        }
        return false;
    }
}