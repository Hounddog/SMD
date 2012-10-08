<?php
/**
 * V5
 * LICENSE
 *
 * Insert License here
 *
 * @package Config
 */

namespace Smd;

return array(
    'router' => array(
        'routes' => array(
            'api' => array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/api',
                    'defaults' => array(
                        'controller' => 'Smd\Controller\Index',
                        'action' => 'index'
                    ),
                ),
                'may_terminate' => true,
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Smd\Controller\Index' => 'Smd\Controller\IndexController'
        ),
    ),
    'bjyauthorize' => array(
        'guards' => array(
            'DysAcl\Guard\Route' => array(
                'route' => array(
                    'api' => array(),
                ),
            ),
        ),
    ),

);
