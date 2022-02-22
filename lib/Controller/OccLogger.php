<?php
namespace OCA\OCCWeb\Controller;

use Psr\Log\LoggerInterface;
use OC;

class OccLogger implements LoggerInterface
{

    public function debug($message, array $context = [])
    {
        OC::$server->getLogger()->debug($message, $context);
    }

    public function critical($message, array $context = [])
    {
        OC::$server->getLogger()->critical($message, $context);
    }

    public function alert($message, array $context = [])
    {
        OC::$server->getLogger()->alert($message, $context);
    }

    public function log($level, $message, array $context = [])
    {
        OC::$server->getLogger()->log($message, $context);
    }

    public function emergency($message, array $context = [])
    {
        OC::$server->getLogger()->emergency($message, $context);
    }

    public function warning($message, array $context = [])
    {
        OC::$server->getLogger()->warning($message, $context);
    }

    public function error($message, array $context = [])
    {
        OC::$server->getLogger()->error($message, $context);
    }

    public function notice($message, array $context = [])
    {
        OC::$server->getLogger()->notice($message, $context);
    }

    public function info($message, array $context = [])
    {
        OC::$server->getLogger()->info($message, $context);
    }
}


