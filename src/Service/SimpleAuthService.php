<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 15.08.14
 * Time: 19:04
 */

namespace Auth\Service;


use Auth\Adapter\DoctrineAdapterOptions;
use Auth\Adapter\SimpleAdapter;
use Zend\ServiceManager\ServiceLocatorInterface;

class SimpleAuthService extends AbstractAuthService {

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $entityManager = $serviceLocator->get('Doctrine\ORM\EntityManager');
        $options = new DoctrineAdapterOptions();
        $options->setEntityManager($entityManager);

        $adapter = new SimpleAdapter();
        $adapter->setOptions($options);

        return $adapter;
    }
}