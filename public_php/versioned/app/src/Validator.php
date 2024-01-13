<?php

namespace Telemetry;

class Validator
{
    public function __construct() { }

    public function __destruct() { }

    public function validateInt(int $age_to_validate): int
    {
        $validated_age = false;

        $options = [
            'options' => [
                'default' => -1, // value to return if the filter fails
                'min_range' => 0,
                'max_range' => 150,
            ]
        ];

        $sanitised_age = filter_var($age_to_validate, FILTER_SANITIZE_NUMBER_INT);
        $validated_age = filter_var($sanitised_age, FILTER_VALIDATE_INT, $options);

        return $validated_age;
    }

    public function sanitiseString(string $string_to_sanitise): string
    {
        $sanitised_string = false;

        if (!empty($string_to_sanitise))
        {
            $sanitised_string = htmlspecialchars($string_to_sanitise);
        }
        return $sanitised_string;
    }

    public function sanitiseEmail(string $email_to_sanitise): string
    {
        $cleaned_string = false;

        if (!empty($email_to_sanitise))
        {
            $sanitised_email = filter_var($email_to_sanitise, FILTER_SANITIZE_EMAIL);

            // Check if the email is valid
            $cleaned_string = filter_var($sanitised_email, FILTER_VALIDATE_EMAIL);


            //error message if email is not in the right format
            if (!$cleaned_string) {
                throw new \InvalidArgumentException("Invalid email address. Please enter a valid email.");
            }
        }
        return $cleaned_string;
    }



}