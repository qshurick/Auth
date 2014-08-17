<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 17.08.14
 * Time: 12:36
 */

namespace Auth\Service;


use Auth\AuthenticationManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AuthenticationService implements FactoryInterface {

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator) {
        return AuthenticationManager::getInstance()->getAuthenticationService();
    }
}