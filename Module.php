<?php
/**
 * V5
 * LICENSE
 *
 * Insert License here
 *
 */

namespace Smd;

use DysBase\Module\AbstractModule;

use Zend\Mvc\MvcEvent;
use Zend\ModuleManager\Feature;
use Zend\EventManager\EventInterface;
/**
 * Base Module for Applicationion
 * @category  Smd 
 * @package   Module
 * @copyright Copyright (c) 2012 Doyousoft
 * @license   $license_information
 * @version   $Id
 */
class Module extends AbstractModule
    implements Feature\BootstrapListenerInterface
{

    /**
     * @{inheritdoc}
     */
    public function onBootstrap(EventInterface $e)
    {
        $app = $e->getParam('application');
        $em  = $app->getEventManager();

        $em->attach(MvcEvent::EVENT_ROUTE, function($e) {
            
        }, 100);
    }

    public function getServiceConfig() 
    {
        return array(
            'factories' => array(
                'smd_factory' => 'Smd\Factory\SmdFactory',
            ),
        );
    }

    public function getDir() 
    {
        return __DIR__;
    }

    public function getNamespace() 
    {
        return __NAMESPACE__;
    }

    public function getDoctrineConfig()
    {
        return array();
    }
}
