<?php

namespace Telemetry\Support;

class AuthenticationService
{
    public function __construct(){}

    public function __destruct(){}

    public function authenticateUser($username, $password)
    {
        // Query the database to retrieve user data
        $userData = DoctrineSqlQueries::queryRetrieveUserData($username);

        // Compare the stored hashed password with the user-provided password
        if (!empty($userData) && password_verify($password, $userData['password'])) {
            // Authentication successful
            return true;
        }

        // Authentication failed
        return false;
    }

}