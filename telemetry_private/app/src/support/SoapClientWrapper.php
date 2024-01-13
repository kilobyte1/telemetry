<?php



namespace Telemetry\Support;

use Psr\Container\ContainerInterface;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Telemetry\Models\MessageModel;

/**
 * Wrapper class for SoapClient handling.
 */
class SoapClientWrapper
{
    /**
     * Constructor.
     */
    public function __construct()
    {
    }
    /**
     * Creates a SoapClient instance.
     *
     * @return object SoapClient instance.
     */

    public function createSoapClient(): object
    {
        $soap_client_handle = false;
        $soap_client_parameters = [];
        $exception = '';

        $wsdl = 'https://m2mconnect.ee.co.uk/orange-soap/services/MessageServiceByCountry?wsdl';
        $soap_client_parameters = ['trace' => true, 'exceptions' => true];

        try {
            // Attempt to create a SoapClient
            $soap_client_handle = new \SoapClient($wsdl, $soap_client_parameters);
        } catch (\SoapFault $exception) {
            // Log SOAP error
            $this->logger->error('SOAP Error: ' . $exception->getMessage());        }

        return $soap_client_handle;
    }
    /**
     * Performs a SOAP call.
     *
     * @param object $soapClient SoapClient instance.
     * @param string $webserviceFunction Name of the webservice function to call.
     * @param array $webserviceParameters Parameters for the webservice function.
     *
     * @return array Result of the SOAP call.
     * @throws \Exception If a SOAP fault occurs.
     */
    public function performSoapCall($soapClient, $webserviceFunction, $webserviceParameters): array
    {
        try {
            // Attempt SOAP call
            return $soapClient->__soapCall($webserviceFunction, $webserviceParameters);
        } catch (\SoapFault $e) {


            // Log SOAP error and throw exception
            throw new \Exception('SOAP Error: ' . $e->getMessage());
        }
    }




//    /**
//     * use send message function to send a message
//     *
//     * @return MessageModel
//     */
//    public function sendMessage(MessageModel $message)
//    {
//        $soapClient = new \SoapClient($this->wsdl, [
//            'trace' => 1,
//            'exceptions' => true,
//        ]);
//
//        try {
//            // Make SOAP request
//            $soapResponse = $soapClient->__soapCall('sendMessage', [
//
//
//                'username' => '23_2562416',
//                'password' => 'Letmein1!!!!!!',
//                'deviceMSISDN' => $message->getPhoneNumber(),
//                'message' => ,
//                'deliveryReport' => true,
//                'mtBearer' => 'SMS',
//            ]);
//
//            // Log success message
//            $this->logger->info('Message sent by user');
//
//            return $soapResponse;
//        } catch (\SoapFault $e) {
//            // Log failure message
//            $this->logger->error('Failed to send message');
//
//            throw new \Exception('SOAP Error: ' . $e->getMessage());
//        }
//    }
}
