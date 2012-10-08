<?php

namespace SiteModuleTest\Unit\Service;

use ApplicationModuleTest\ServiceManagerTestCase;

use PHPUnit_Framework_TestCase as BaseTestCase;

use Application\Service\RestService;

class SiteTest extends BaseTestCase
{
    public function testGet() 
    {
        $serviceManagerTestCase = new ServiceManagerTestCase;
        $serviceManager = $serviceManagerTestCase->getServiceManager();
        $service = new RestService;
    }
    
    public function testGetList() 
    {
        $serviceManagerTestCase = new ServiceManagerTestCase;
        $serviceManager = $serviceManagerTestCase->getServiceManager();
        $service = new RestService;
    }
}