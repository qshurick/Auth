<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 15.08.14
 * Time: 19:04
 */

namespace Auth\Service;


use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

abstract class AbstractAuthService implements FactoryInterface {

    public function getOptions(ServiceLocatorInterface $sm, $alias) {
        $options = $sm->get('Configuration');
        return isset($options[$alias]) ? $options[$alias] : array();
    }

}