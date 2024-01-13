<?php


namespace Telemetry;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Telemetry\Models\MessageModel;

class SoapClientWrapper
{
    private $wsdl;
    private $logger;

    public function __construct(string $wsdl)
    {
        $this->wsdl = $wsdl;

        // Set up Monolog logger
        $this->logger = new Logger('soap_logger');
        $this->logger->pushHandler(new StreamHandler('log.log', Logger::DEBUG));
    }

    /**
     * use send message function to send a message
     *
     * @return MessageModel
     */
    public function sendMessage(MessageModel $message)
    {
        $soapClient = new \SoapClient($this->wsdl, [
            'trace' => 1,
            'exceptions' => true,
        ]);

        try {
            // Make SOAP request
            $soapResponse = $soapClient->__soapCall('sendMessage', [
                'username' => '23_2562416',
                'password' => 'Letmein1!!!!!!',
                'deviceMSISDN' => $message->getPhoneNumber(),
                'message' => $message->getMessage(),
                'deliveryReport' => true,
                'mtBearer' => 'SMS',
            ]);

            // Log success message
            $this->logger->info('Message sent by user');

            return $soapResponse;
        } catch (\SoapFault $e) {
            // Log failure message
            $this->logger->error('Failed to send message');

            throw new \Exception('SOAP Error: ' . $e->getMessage());
        }
    }
}
