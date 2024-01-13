<?php
/**
 * class to contain all database access using Doctrine's QueryBulder
 *
 * A QueryBuilder provides an API that is designed for conditionally constructing a DQL query in several steps.
 *
 * It provides a set of classes and methods that is able to programmatically build queries, and also provides
 * a fluent API.
 * This means that you can change between one methodology to the other as you want, or just pick a preferred one.
 *
 * From https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/reference/query-builder.html
 */

namespace Telemetry;

class DoctrineSqlQueries
{
    public function __construct(){}

    public function __destruct(){}

    public static function queryStoreUserData(
        object $queryBuilder,
        array $cleaned_parameters,
        string $hashed_password
    ): array
    {
        $store_result = [];
        $username = $cleaned_parameters['sanitised_username'];
        $userage = $cleaned_parameters['validated_userage'];
        $email = $cleaned_parameters['sanitised_email'];

        $queryBuilder = $queryBuilder->insert('user_data')
            ->values([
                'user_name' => ':name',
                'user_age' => ':age',
                'email' => ':email',
                'password' => ':password',
            ])
            ->setParameters([
                'name' => $username,
                'age' => $userage,
                'email' => $email,
                'password' => $hashed_password
            ]);

        $store_result['outcome'] = $queryBuilder->execute();
        $store_result['sql_query'] = $queryBuilder->getSQL();

        return $store_result;
    }

    public static function queryRetrieveUserData(
        object $queryBuilder,
        array $cleaned_parameters
    ): array
    {
        $result = [];
        $username = $cleaned_parameters['sanitised_username'];

        $queryBuilder
            ->select('password', 'email')
            ->from('user_data', 'u')
            ->where('user_name = ' .  $queryBuilder->createNamedParameter($username));

        $query = $queryBuilder->execute();
        $result = $query->fetchAll();

        return $result;
    }
}
