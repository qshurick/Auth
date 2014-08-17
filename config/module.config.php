<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 17.08.14
 * Time: 12:01
 */

return array(
    'router' => array(
        'routes' => array(
            'auth-api-v1' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route' => '/api/v1/auth[/:adapter]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]+'
                    ),
                    'defaults' => array(
                        'controller' => 'AuthController',
                        'action' => 'index',
                        'adapter' => 'simple'
                    ),
                ),
            )
        )
    ),
    'controllers' => array(
        'invokables' => array(
            'AuthController' => 'Auth\Controller\AuthController'
        ),
    )
);