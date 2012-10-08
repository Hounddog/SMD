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
 * Dummy Controller
 * @category  Smd
 * @package   Test
 * @copyright Copyright (c) 2012 Doyousoft
 * @license   $license_information
 * @version   $Id
 */
class DummyRestController extends AbstractRestfulController
{
    /**
     * Set Allowed Criterias
     * @see Pwb_ControllerRestAbstract::_criteres
     * @param int $reference
     * @param int $language
     */
    protected $criteria = array('reference','language');
}