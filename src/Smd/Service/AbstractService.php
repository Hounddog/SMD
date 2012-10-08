<?php
/**
 * V5
 * LICENSE
 *
 * Insert License here
 *
 * @package Service
 */

namespace Smd\Service;

use     Smd\Factory\SmdFactory as Smd,
        Zend\Json\Server\Smd\Service,
        Zend\ServiceManager\ServiceLocatorInterface,
        Zend\Mvc\Router\RouteStackInterface;
/**
 * Super Type Service for Smd.
 * @category  Smd
 * @package   Service
 * @copyright Copyright (c) 2012 Doyousoft
 * @license   $license_information
 * @version   $Id
 */
class AbstractService
    extends Service
{

    protected $serviceLocator;
    protected $route;

    /**
     * Allowed envelope types
     * @var array
     */
    protected $envelopeTypes = array(
        Smd::ENV_JSONRPC_1,
        Smd::ENV_JSONRPC_2,
        Smd::ENV_JSONRPC_PATH,
    );

    /**
     * Allowed transport types
     * @var array
     */
    protected $_transportTypes = array(
        'POST', 'GET'
    );

    /**
     * Constructor
     *
     * @param string $name
     * @param array $params
     * @throws Zend_Json_Server_Exception if no name provided
     */
    /*public function __construct($name, $params, ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        $this->router = $serviceLocator->get('router');

        $this->setName($name);
        $this->setParams($params);
    }*/

    /**
     * Set Docblock Options
     * @param Zend_Reflection_Docblock $docBlock [description]
     */
    public function setDocBlockOptions(Zend_Reflection_Docblock $docBlock)
    {
        $methods = get_class_methods($this);
        $tags = $docBlock->getTags();
        foreach ($tags as $tag) {
            $name = $tag->getName();
            $method = 'set' . ucfirst($name);
            if ( in_array($method, $methods) ) {
                if ( $name == 'return' ) {
                    $this->$method(trim($tag->getType()));
                    continue;
                }
                $this->$method(trim($tag->getDescription()));
            }
        }
    }

    /**
     * Get Content Type
     *
     * @return string
     */
    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * Set ContentType
     *
     * @param string $contentType
     */
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
    }

    /**
     * Set service target
     *
     * @param  string $target
     * @return Zend\Json\Server\Smd\Service
     */
    public function setTarget($target)
    {
        $router = $this->serviceLocator->get('router');
        if (!$router instanceof RouteStackInterface) {
            throw new Exception\DomainException(
                __METHOD__
                . ' cannot execute as no Zend\Mvc\Router\RouteStackInterface instance is composed'
            );
        }
        $params = array();
        $options = array('name' => $target);
        $url = $router->assemble($params, $options);
        $this->target = (string) $url;
        return $this;
    }

}
