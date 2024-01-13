<?php



namespace Telemetry\Support;

use Psr\Container\ContainerInterface;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Telemetry\Models\MessageModel;

class SoapClientWrapper
{

    public function __construct()
    {
    }

    public function createSoapClient(): object
    {
        $soap_client_handle = false;
        $soap_client_parameters = [];
        $exception = '';

        $wsdl = 'https://m2mconnect.ee.co.uk/orange-soap/services/MessageServiceByCountry?wsdl';
        $soap_client_parameters = ['trace' => true, 'exceptions' => true];

        try {
            $soap_client_handle = new \SoapClient($wsdl, $soap_client_parameters);
        } catch (\SoapFault $exception) {
            //get the log
            $this->logger->error('SOAP Error: ' . $exception->getMessage());        }

        return $soap_client_handle;
    }

    public function performSoapCall($soapClient, $webserviceFunction, $webserviceParameters): array
    {
        try {

            return $soapClient->__soapCall($webserviceFunction, $webserviceParameters);
        } catch (\SoapFault $e) {

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
