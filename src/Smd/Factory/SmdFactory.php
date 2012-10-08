<?php
/**
 * V5
 * LICENSE
 *
 * Insert License here
 *
 * @package Factory
 */

namespace Smd\Factory;

use Zend\Json\Server\Smd;

use Smd\Service\Rest;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
/**
 * Smd factory.
 * @category  Smd
 * @package   Factory
 * @copyright Copyright (c) 2012 Doyousoft
 * @license   $license_information
 * @version   $Id
 */
class SmdFactory extends Smd implements FactoryInterface
{
    protected $serviceLocator;

    const ENV_JSONRPC_PATH = 'PATH';

    /**
     * Current envelope
     * @var string
     */
    protected $envelope = self::ENV_JSONRPC_PATH;

    /**
     * {@inheritDoc}
     */
    protected $envelopeTypes = array(
        self::ENV_JSONRPC_1,
        self::ENV_JSONRPC_2,
        self::ENV_JSONRPC_PATH,
    );

    /**
     * Set envelope
     *
     * @param  string $envelopeType
     * @return Smd
     */
    public function setEnvelope($envelopeType)
    {
        print_r($this->envelopeTypes);
        exit;
        if (!in_array($envelopeType, $this->envelopeTypes)) {
            throw new InvalidArgumentException("Invalid envelope type '{$envelopeType}'");
        }
        $this->envelope = $envelopeType;
        return $this;
    }

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('config');
        $this->setDescription('Powerboutique API');
        $this->setId('/api');
        $this->serviceLocator = $serviceLocator;
        $smdConfig = $config['smd'];
        $factories = $smdConfig['factories'];
        foreach ($factories as $name => $service) {
            $this->resolveFactories($name, $service);
        }

        return $this->toArray();
    }

    public function resolveFactories($name, $service) 
    {
        $this->services[$name] = $service($this->serviceLocator);
        return $this;
    }
    
    /**
     * Add Rest Controller
     *
     * @param string $name
     * @param array $params
     * @return Smd
     */
    public function addRestController($name, $params)
    {
        $service = new Rest($name, $params, $this->serviceLocator);
        $name = $service->getName();

        if (array_key_exists($name, $this->services)) {
            require_once 'Zend/Json/Server/Exception.php';
            throw new Zend_Json_Server_Exception(
                'Attempt to register a service already registered detected'
            );
        }
        $this->services[$name] = $service;
        var_dump($this->services);
        exit;
        return $this;
    }
}