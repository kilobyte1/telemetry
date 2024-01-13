<?php
/**
 * Wrapper class for the PHP BCrypt library.  Takes the pain out of using the library.
 *
 * @author CF Ingrams <cfi@dmu.ac.uk>
 * @copyright De Montfort University
 */

namespace Telemetry;

class BcryptWrapper
{

  public function __construct(){}

  public function __destruct(){}

  public function createHashedPassword(string $string_to_hash, array $settings): string
  {
    $password_to_hash = $string_to_hash;
    $bcrypt_hashed_password = '';

    $bcrypt_cost = $settings['bcrypt_cost'];
    $bcrypt_algorithm = $settings['bcrypt_algorithm'];

    if (!empty($password_to_hash))
    {
      $options = array('cost' => $bcrypt_cost);
      $bcrypt_hashed_password = password_hash($password_to_hash, $bcrypt_algorithm, $options);
    }
    return $bcrypt_hashed_password;
  }

  public function authenticatePassword(string $string_to_check, string $stored_user_password_hash): bool
  {
    $user_authenticated = false;
    $current_user_password = $string_to_check;
    if (!empty($current_user_password) && !empty($stored_user_password_hash))
    {
      if (password_verify($current_user_password, $stored_user_password_hash))
      {
        $user_authenticated = true;
      }
    }
    return $user_authenticated;
  }
}
