<?php
/**
 * V5
 * LICENSE
 *
 * Insert License here
 *
 * @package Smd
 */

namespace Smd\Service;

use Smd\Service\AbstractService;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use Zend\Code\Reflection\ClassReflection;
use Zend\Code\Reflection\PropertyReflection;
use Zend\ServiceManager\ServiceLocatorInterface;
/**
 * Rest Service for Smd.
 * @category  Smd
 * @package   Service
 * @copyright Copyright (c) 2012 Doyousoft
 * @license   $license_information
 * @version   $Id
 */
class Rest
    extends AbstractService
{

    /**
     * Content Type
     * @var string
     */
    protected $contentType = 'application/json';

    /**
     * Service metadata Transport
     * @var string
     */
    protected $transport = 'REST';

    /**
     * Constructor
     *
     * @param  string|array $spec
     * @throws Zend\Json\Server\Exception\InvalidArgumentException if no name provided
     */
    public function __construct($spec, ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;

        if (is_string($spec)) {
            $this->setName($spec);
        } elseif (is_array($spec)) {
            $this->setOptions($spec);
        }

        if (null == $this->getName()) {
            throw new InvalidArgumentException('SMD service description requires a name; none provided');
        }
    }

    /**
     * Cast service description to array
     *
     * @return array
     */
    public function toArray()
    {
        $paramInfo = array();
        $paramInfo['envelope'] = $this->getEnvelope();
        if (null !== ($target = $this->getTarget())) {
            $paramInfo['target'] = $target;
        }
        $paramInfo['transport'] = $this->getTransport();
        $paramInfo['contentType'] = $this->getContentType();
        $paramInfo['parameters'] = $this->getParams();
        $paramInfo['returns'] = $this->getReturn();
        
        return $paramInfo;
    }
}