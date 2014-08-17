<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 15.08.14
 * Time: 19:36
 */

namespace Auth\Service;


use Auth\Adapter\GodAdapter;
use Zend\ServiceManager\ServiceLocatorInterface;

class GodAuthService extends AbstractAuthService {

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator) {
        return new GodAdapter();
    }
}