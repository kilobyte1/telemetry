<?php

namespace Telemetry\Models;

use Monolog\Logger;

class MessageValidationModel
{

    private $result;
    private $log;

    public function __construct()
    {
        $this->log = new Logger('logs');
    }

    public function __destruct()
    {
    }

    public function get_telemetry_message($soap_wrapper): array

    {
        $this->log->info('Attempting to retrieve messages from API.');

        $soap_client_handle = $soap_wrapper->createSoapClient();

        if ($soap_client_handle != false) {
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

    public function sendMessage($message_body, $device_msisdn)
    {
        $this->log->info('Attempting to send message to API: ' . $message_body);

        $soap_client_handle = $this->soap_wrapper->createSoapClient();

        if ($soap_client_handle !== false) {

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

            $soapcall_result = $this->soap_wrapper->performSoapCall($soap_client_handle, $webservice_function, $webservice_call_parameters, $webservice_value);

            $this->result = $soapcall_result;
        }
    }

}