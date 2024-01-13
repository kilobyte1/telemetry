<?php

namespace Telemetry\Models;

use Monolog\Logger;
/**
 * Model class for message validation and handling SOAP requests.
 */
class MessageValidationModel
{

    private $result;
    private $log;

    /**
     * Constructor.
     */
    public function __construct()
    {
        // Initialize logger
        $this->log = new Logger('logs');
    }
    /**
     * Destructor.
     */
    public function __destruct()
    {
        // Destructor logic if needed
    }
    /**
     * Retrieves telemetry messages from the API.
     *
     * @param object $soap_wrapper SoapClientWrapper instance for handling SOAP requests.
     *
     * @return array Telemetry messages.
     */

    public function get_telemetry_message($soap_wrapper): array

    {
        $this->log->info('Attempting to retrieve messages from API.');

        // Create SOAP client
        $soap_client_handle = $soap_wrapper->createSoapClient();

        if ($soap_client_handle != false) {
            // Set up SOAP request parameters
            $webservice_function = 'peekMessages';
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

            $webservice_value = 'peekMessagesResponse';
            return $soap_wrapper->performSoapCall($soap_client_handle, $webservice_function, $webservice_parameters, $webservice_value);
        }
    }
    /**
     * Sends a message to the API.
     *
     * @param string $message_body Message content.
     * @param string $device_msisdn Device MSISDN.
     *
     * @return void
     */
    public function sendMessage($message_body, $device_msisdn)
    {
        $this->log->info('Attempting to send message to API: ' . $message_body);
        // Create SOAP client
        $soap_client_handle = $this->soap_wrapper->createSoapClient();

        if ($soap_client_handle !== false) {
            // Set up SOAP request parameters
            $webservice_function = 'sendMessage';
            $webservice_call_parameters = [
                'username' => 23_2562416,
                'password' => 'Letmein1!!!!!!',
                'deviceMsisdn' => $device_msisdn,
                'message' => $message_body,
                'deliveryReport' => true,
                'mtBearer' => 'SMS',
            ];
            $webservice_value = 'sendMessageResponse';
            // Perform SOAP call and store result
            $soapcall_result = $this->soap_wrapper->performSoapCall($soap_client_handle, $webservice_function, $webservice_call_parameters, $webservice_value);

            $this->result = $soapcall_result;
        }
    }

}
