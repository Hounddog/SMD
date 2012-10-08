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
class RestDto
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

    //protected $_envelope = Pwb_Smd::ENV_PATH;

    /**
     * Reflection from Controller Class
     * @var Zend_Reflection_Class
     */
    protected $controller;

    /**
     * Class Name
     * @var string
     */
    protected $className;

    /**
     * Dto Name
     * @var string
     */
    protected $dtoName;

    public function __construct($controller, $dto, $route, ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        $this->route = $route;
        $this->dtoName = $dto;
        $this->className = $controller;

        $this->factory();
    }

    public function factory() 
    {
        $this->setTarget($this->route);

        $this->setControllerParameters();
        $this->setReturn($this->getDto());
    }

    /**
     * Set all parameters
     *
     * @return Rest
     */
    public function setControllerParameters()
    {
        $reflectionClass = new ClassReflection($this->className);

        $propertyByName = $reflectionClass->getProperty('criteria');

        $docComment = $propertyByName->getDocBlock();
        if ( !$docComment ) {
            throw new \Smd\Service\Exception\InvalidArgumentException(
                $e->getMessage(),
                500,
                $e
            );
            $this->setError(
                'DocBlock missing for _criteres in ' .
                $this->_className
            );
        }
        $docParams = $docComment->getTags('param');
        if ( !$docParams ) {
            $this->setError(
                'Parameters description missing for _criteres in ' .
                $this->_className
            );
        }


        foreach ($docParams as $key => $param) {
            $optional = false;
            $name = $param->getVariableName();
            if ( empty($name) ) {
                $this->setError(
                    'Parameters Variable missing for _criteres in ' .
                    $this->_className
                );
            }
            if ( preg_match('/\[optional\]/is', $param->getDescription()) ) {
                $optional = true;
            }
            $option[ 'name' ] = substr($param->getVariableName(), 1);
            $option[ 'optional' ] = $optional;
            $this->addParam($param->getType(), $option);
        }
        
        return $this;
    }

    /**
     * Get Dto Data for Return
     * @return array
     */
    public function getDto()
    {
        $dtoReflection = new ClassReflection($this->dtoName);
        $properties = $dtoReflection->getProperties(
            PropertyReflection::IS_PUBLIC
        );

        $dto = array( );
        foreach ($properties as $property) {
            $docComment = $property->getDocBlock();

            if ( !$docComment ) {
                throw new \Smd\Service\Exception\InvalidArgumentException(
                    'DocBlock missing for dto property "' .
                    $property->getName() . '" in ' . $this->dtoName
                );
            }

            if ( !$docComment->hasTag('var') ) {
                throw new \Smd\Service\Exception\InvalidArgumentException(
                    'Description incorrect or missing for dto property "' .
                    $property->getName() . '" in ' . $this->dtoName
                );
            }

            $docVar = trim($docComment->getTag('var'));

            if (trim(strtolower($docVar)) == 'array') {
                $docParams = $docComment->getTags('param');
                $docRef = $docComment->getTag('ref');
                $docDto = $docComment->getTag('dto');
                $params = array( );
                if ( $docParams ) {
                    foreach ($docParams as $param) {
                        // echo $param->getType();
                        //$params[ $param->getDescription() ] = array(
                        //    'type' => $param->getType()
                        //);
                    }
                    $dto[ $property->getName() ][ 'items' ] = $params;
                } else if ( $docRef ) {
                    $params[ '$ref' ] = $docRef->getDescription();
                    $dto[ $property->getName() ][ 'items' ] = $params;
                } else if ( $docDto ) {
                    $dto[ $property->getName() ][ 'items' ] = $this->_getDto(
                        trim($docDto->getDescription())
                    );
                } else {
                    $dto[ $property->getName() ][ 'items' ] = false;
                }
            } else if ( $docComment->getTag('ref') ) {
                $docRef = $docComment->getTag('ref');
                $params[ '$ref' ] = $docRef->getContent();
                $dto[ $property->getName() ] = $params;
            }

            $dto[ $property->getName() ][ 'type' ] = $docVar;
        }

        return $dto;
    }

    /**
     * Set return type
     *
     * @param  string|array $type
     * @return Zend_Json_Server_Smd_Service
     */
    public function setReturn($type)
    {
        if ( is_string($type) ) {
            $type = $this->_validateParamType($type, true);
        } elseif ( is_array($type) ) {
            foreach ($type as $key => $returnType) {
                $typeArray = array( );
                $typeArray[ 'type' ] = $this->_validateParamType(
                    $returnType[ 'type' ], true
                );
                if ( $returnType[ 'type' ] == 'array' ) {
                    if ( $returnType[ 'items' ] ) {
                        $typeArray[ 'items' ] = $returnType[ 'items' ];
                    }
                }

                if (
                    isset(
                        $returnType[ '$ref' ])
                    && $returnType[ 'type' ] != 'array'
                ) {
                    $typeArray[ '$ref' ] = $returnType[ '$ref' ];
                    unset($typeArray[ 'type' ]);
                }
                $type[ $key ] = $typeArray;
            }
        } else {
            require_once 'Zend/Json/Server/Exception.php';
            throw new Zend_Json_Server_Exception(
                'Invalid param type provided ("' . gettype($type) . '")'
            );
        }
        $this->return = $type;
        return $this;
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