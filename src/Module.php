<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 15.08.14
 * Time: 19:39
 */

namespace Auth;


use Auth\Service\AuthenticationService;
use Auth\Service\GodAuthService;
use Auth\Service\SimpleAuthService;
use Zend\ModuleManager\Feature\ServiceProviderInterface;

class Module implements ServiceProviderInterface {

    /**
     * Expected to return \Zend\ServiceManager\Config object or array to
     * seed such an object.
     *
     * @return array|\Zend\ServiceManager\Config
     */
    public function getServiceConfig() {
        return array(
            'aliases' => array(
                'Zend\Authentication\AuthenticationService' => 'dao.authentication.service'
            ),
            'factories' => array(
                'dao.authentication.simple' => new SimpleAuthService(),
                'dao.authentication.god' => new GodAuthService(),
                'dao.authentication.service' => new AuthenticationService()
            )
        );
    }
}