<?php
/**
 * V5
 * LICENSE
 *
 * Insert License here
 *
 * @package Controller
 */

namespace Smd\Controller;

use Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\JsonModel;

use Smd\Factory\SmdFactory;

/**
 * Index Controller
 * @category  Smd
 * @package   Controller
 * @copyright Copyright (c) 2012 Doyousoft
 * @license   $license_information
 * @version   $Id
 */
class IndexController extends AbstractActionController
{
    /**
     * Index Action
     * @return JsonModel
     */
    public function indexAction()
    {
        $smd = $this->getServiceLocator()->get('smd_factory');
        return new JsonModel($smd);
    }
}
