Sample, skeleton module for use with the ZF2 MVC layer.

Sample For Rest Controllers

    'smd' => array(
        'factories' => array(
            'navigation' => function($sl) {
                $params = array(
                    'name' => 'testing',
                    'target' => 'api/navigation',
                    'params' => array(
                        0 => array(
                            'type' => 'string',
                            'name' => 'test'
                        ),
                    ),
                    'return' => 'array'
                );

                return new \Smd\Service\Rest($params, $sl);
            }
        ),
    ), 

Sample for Rest Controllers with Dto

    'smd' => array(
        'factories' => array(
            'site' => function($sl) {
                return  new \Smd\Service\RestDto(
                    'Site\Controller\Api\SiteController',
                    'Site\Dto\Site',
                    'api/site',
                    $sl
                );
                return $service;
            }
        ),
    ), 