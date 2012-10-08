<?php
/**
 * V5
 * LICENSE
 *
 * Insert License here
 *
 * @package Test
 */

namespace SmdModuleTest\Unit\Factory;

use PHPUnit_Framework_TestCase as BaseTestCase;

use Smd\Factory\SmdFactory;

/**
 * Rest Test
 * @category  Smd
 * @package   Test_Asset
 * @copyright Copyright (c) 2012 Doyousoft
 * @license   $license_information
 * @version   $Id
 */
class SmdFactoryTest extends BaseTestCase
{
    public $factory;

    public function setUp() 
    {
        $params = array(
            'controller' => 
                'SmdModuleTest\TestAsset\DummyRestController',
            'dto' => 'SmdModuleTest\TestAsset\DummyDto',
            'route' => '/api/test',
        );

        $this->factory = new SmdFactory('dummyService', $params);
    }
    
    public function testFactory() 
    {
        $output = array(
            'transport' => 'POST',
            'envelope' => 'JSON-RPC-1.0',
            'contentType' => 'application/json',
            'SMDVersion' => '2.0',
            'id' => '/api',
            'services' => array(
                'testService' => array(
                    'envelope' => 'JSON-RPC-1.0',
                    'target' => '/api/test',
                    'transport' => 'REST',
                    'contentType' => 'application/json',
                    'parameters' => array(
                        0 => array(
                            'type' => 'integer',
                            'name' => 'reference',
                            'optional' => '',
                        ),
                        1 => array(
                            'type' => 'integer',
                            'name' => 'language',
                            'optional' => ''
                        )
                    ),
                    'returns' => array(
                        'id' => array(
                            'type' => 'object',
                        ),
                        'name' => array(
                            'type' => 'object',
                        ),
                        'language' => array(
                            'type' => 'object',
                        )

                    )
                )
            ),
            'methods' => array(
                'testService' => array(
                    'envelope' => 'JSON-RPC-1.0',
                    'target' => '/api/test',
                    'transport' => 'REST',
                    'contentType' => 'application/json',
                    'parameters' => array(
                        0 => array(
                            'type' => 'integer',
                            'name' => 'reference',
                            'optional' => '',
                        ),
                        1 => array(
                            'type' => 'integer',
                            'name' => 'language',
                            'optional' => '',
                        )

                    ),
                    'returns' => array(
                        'id' => array(
                            'type' => 'object'
                        ),
                        'name' => array(
                            'type' => 'object'
                        ),
                        'language' => array(
                            'type' => 'object'
                        ),
                    )
                )
            )
        );

        $config = array('smd' =>
            array('testService' => 
                array(
                    'controller' => 
                    'SmdModuleTest\TestAsset\DummyRestController',
                    'dto' => 'SmdModuleTest\TestAsset\DummyDto',
                    'route' => '/api/test',
                )
            )
        );

        $result = $this->factory->factory($config);

        $this->assertEquals($output, $result);
    }
}