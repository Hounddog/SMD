<?php
/**
 * V5
 * LICENSE
 *
 * Insert License here
 *
 * @package Test
 */

namespace SmdModuleTest;

require_once __DIR__. '/../../../DysBase/Test/AbstractBootstrap.php';

use DysBase\Test\AbstractBootstrap;

error_reporting(E_ALL | E_STRICT);
chdir(__DIR__);

/**
 * Rest Service for Smd.
 * @category  Smd
 * @package   Test
 * @copyright Copyright (c) 2012 Doyousoft
 * @license   $license_information
 * @version   $Id
 */
class Bootstrap  extends AbstractBootstrap
{
    
}

Bootstrap::init(__NAMESPACE__);