<?php

namespace Telemetry\Models;

use Doctrine\DBAL\DriverManager;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class MessageValidationModel
{

    private $result;
    private $log;

    public function __construct()
    {
        $this->log = new Logger('/p3t/phpappfolder/logs');

    }

    public function __destruct()
    {
    }

    public function get_telemetry_message(object $soap_wrapper, $settings): array

    {
        $parsed_result = [];
        $this->log->info('Attempting to retrieve messages from API.');

        $soap_client_handle = $soap_wrapper->createSoapClient($settings);


            $webservice_function = 'readMessages';


            $username = '23_2562416';
            $password = 'Letmein1!!!!!!';
            $count = 10;
            $deviceMSISDN = '+447463351235';
            $countryCode = '+44';

            $webservice_parameters = [
                'username' => $username,
                'password' => $password,
                'count' => $count,
                'deviceMSISDN' => $deviceMSISDN,
                'countryCode' => $countryCode,
            ];
            if ($soap_client_handle !== false){

                $result = $soap_wrapper->performSoapCall($soap_client_handle, $webservice_function, $webservice_parameters);
            }

            foreach($result as $xml_message){
                $parsed_result[] = simplexml_load_string($xml_message);
            }
            // $webservice_value = 'peekMessagesResponse';
            return $parsed_result;

    }

    public function sendMessage($message_body, $device_msisdn)
    {
        $this->log->info('Attempting to send message to API: ' . $message_body);

        $soap_client_handle = $this->soap_wrapper->createSoapClient();

        if ($soap_client_handle !== false) {

            $webservice_function = 'sendMessage';
            $webservice_call_parameters = [
                'username' => '23_2562416',
                'password' => 'Letmein1!!!!!!',
                'deviceMsisdn' => $device_msisdn,
                'message' => $message_body,
                'deliveryReport' => true,
                'mtBearer' => 'SMS',
            ];
            $webservice_value = 'sendMessageResponse';

            $soapcall_result = $this->soap_wrapper->performSoapCall($soap_client_handle, $webservice_function, $webservice_call_parameters, $webservice_value);

            $this->result = $soapcall_result;
        }
    }



    /**
     * Saves telemetry messages in the database.
     *
     * @param array $telemetryMessages
     * @param array $database_connection_settings
     * @param object $doctrine_queries
     *  * @param object $validator
     */
    function saveTelemetryMessages(
        array $telemetryMessages,
        array $database_connection_settings,
        object $doctrine_queries,
        object $validator,
    ): void {
        $store_result = '';
        $database_connection = DriverManager::getConnection($database_connection_settings);
        $queryBuilder = $database_connection->createQueryBuilder();

        $keywordsToCheck = ['fan', 'switch', 'heater', 'keypad'];

        foreach ($telemetryMessages as $telemetryMessage) {
            $telemetryData = [
                'sourcemsisdn' => $validator->sanitiseString($telemetryMessage->sourcemsisdn),
                'destinationmsisdn' => $validator->sanitiseString($telemetryMessage->destinationmsisdn),
                'receivedtime' => $validator->sanitiseString($telemetryMessage->receivedtime),
                'bearer' => $validator->sanitiseString($telemetryMessage->bearer),
                'messageref' => $validator->sanitiseString($telemetryMessage->messageref),
                'message' => $validator->sanitiseString($telemetryMessage->message),
            ];

            // Check if the message contains any of the specified keywords
            if ($this->containsKeywords($telemetryData['message'], $keywordsToCheck)) {
                $store_result = $doctrine_queries::queryStoreTelemetryMessage($queryBuilder, $telemetryData);

                if ($store_result['outcome'] !== 1) {
                    $this->log->error('Error saving telemetry messages to the database.');
                } else {
                    $this->log->info('Telemetry messages saved successfully.');
                    $this->log->pushHandler(new StreamHandler('/p3t/phpappfolder/logs.log', Logger::DEBUG));
                }
            } else {
                $this->log->info('Telemetry message does not contain specified keywords. Not saved.');
            }
        }
    }

    function containsKeywords($message, $keywordsToCheck) {
        $message = strtolower($message);
        foreach ($keywordsToCheck as $keyword) {
            if (strpos($message, $keyword) !== false) {
                return true;
            }
        }
        return false;
    }


    function filterMessage($messageDetails)
    {
        $statusArray = [];


        $keyValuePairs = explode(',', $messageDetails);


        $keys = ['switch1', 'switch2', 'switch3', 'switch4', 'fan', 'keypad', 'temperature'];


        $allNotGiven = true;

        foreach ($keyValuePairs as $pair) {

            $pairParts = explode('=', $pair);

            // Check if the pair is valid
            if (count($pairParts) == 2) {
                $key = strtolower(trim($pairParts[0]));
                $value = trim($pairParts[1]);

                switch ($key) {
                    case 'switch1':
                    case 'switch2':
                    case 'switch3':
                    case 'switch4':
                        if (strtolower($value) === 'on' || strtolower($value) === 'off') {
                            $statusArray[$key] = strtolower($value); // Store as lowercase
                        } else {
                            $statusArray[$key] = "Incorrect switch status inputted. You said '{$value}' for {$key}.";
                        }
                        break;

                    case 'fan':
                        if (strtolower($value) === 'forward' || strtolower($value) === 'reverse') {
                            $statusArray[$key] = strtolower($value); // Store as lowercase
                        } else {
                            $statusArray[$key] = "Incorrect fan status inputted. You said '{$value}' for fan.";
                        }
                        break;

                    case 'temperature':
                        // Add validation logic for temperature if needed
                        $statusArray[$key] = $value;
                        break;

                    case 'keypad':
                        if (ctype_digit($value) && strlen($value) === 1) {
                            $statusArray[$key] = $value;
                        } else {
                            $statusArray[$key] = "Incorrect keypad value inputted. Keypad value must be a single digit (0-9). You said '{$value}'.";
                        }
                        break;

                    default:
                        $statusArray[$key] = "Unrecognized CircuitBoard Status '{$key}'.";
                }

                // Check if any data is given for the current key
                if (in_array($key, $keys) && isset($statusArray[$key]) && $statusArray[$key] !== 'not given') {
                    $allNotGiven = false;
                }
            }
        }

        // Set 'not given' for any missing keys
        foreach ($keys as $eachone) {
            if (!isset($statusArray[$eachone])) {
                $statusArray[$eachone] = 'not given';
            }
        }

        // If all keys are 'not given', set 'error'
        if ($allNotGiven) {
            $statusArray['error'] = "no data";
        }

        return $statusArray;
    }


}