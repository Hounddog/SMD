<?php
/**
 * V5
 * LICENSE
 *
 * Insert License here
 *
 * @package Test
 */

namespace SmdModuleTest\Unit\Service;

use PHPUnit_Framework_TestCase as BaseTestCase;

use Smd\Service\Rest;

/**
 * Rest Test
 * @category  Smd
 * @package   Test_Asset
 * @copyright Copyright (c) 2012 Doyousoft
 * @license   $license_information
 * @version   $Id
 */
class RestTest extends BaseTestCase
{
    public $service;

    public function setUp() 
    {
        $params = array(
            'controller' => 'SmdModuleTest\TestAsset\DummyRestController',
            'dto' => 'SmdModuleTest\TestAsset\DummyDto',
            'route' => '/api/test',
        );

        $this->service = new Rest('dummyService', $params);
    }
    /**
     * test dto
     */
    public function testDto() 
    {
        $output = array(
            'id' => array(
                'type' => 'DocBlock Tag [ * @var ]'
            ),
            'name' => array(
                'type' => 'DocBlock Tag [ * @var ]'
            ),
            'language' => array(
                'type' => 'DocBlock Tag [ * @var ]'
            )
        );

        $dto = $this->service->getDto();

        $this->assertEquals($output, $dto);
    }

    public function testToArray() 
    {
        $output = array(
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
                    'id' => array('type' => 'object'),
                    'name' => array('type' => 'object'),
                    'language' => array('type' => 'object'),
                )
            );

        $result = $this->service->toArray();

        $this->assertEquals($output, $result);
    }

    /**
     * Throws exception no Docblock provided
     */
    public function testMissingDocBlockDto() 
    {
        $this->setExpectedException('InvalidArgumentException');

        $params = array(
            'controller' => 'SmdModuleTest\TestAsset\DummyRestController',
            'dto' => 'SmdModuleTest\TestAsset\DummyErrorDto',
            'route' => '/api/test',
        );

        $sservice = new Rest('dummyService', $params);


    }

    /**
     * Throws exception if no var provided in docblock
     */
    public function testMissingDocBlockVarDto() 
    {
        $this->setExpectedException('InvalidArgumentException');

        $params = array(
            'controller' => 'SmdModuleTest\TestAsset\DummyRestController',
            'dto' => 'SmdModuleTest\TestAsset\DummyErrorMissingVarDto',
            'route' => '/api/test',
        );

        $sservice = new Rest('dummyService', $params);


    }

}