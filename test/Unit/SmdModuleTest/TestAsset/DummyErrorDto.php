<?php
/**
 * V5
 * LICENSE
 *
 * Insert License here
 * @package Test
 */

namespace SmdModuleTest\TestAsset;

use DysBase\Controller\AbstractRestfulController,
    Zend\View\Model\JsonModel;

/**
 * Dummy Dto
 * @category  Smd
 * @package   Test
 * @copyright Copyright (c) 2012 Doyousoft
 * @license   $license_information
 * @version   $Id
 */
class DummyErrorDto extends AbstractRestfulController
{
    public $id;
    public $name;
    public $language;
}