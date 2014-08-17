<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 15.08.14
 * Time: 15:39
 */

namespace Auth\Adapter;


use Doctrine\ORM\EntityManager;

class DoctrineAdapterOptions {

    const ENTITY_MANAGER = 'entity_manager';

    /** @var EntityManager */
    protected $entityManager;

    function __construct($options = array()) {
        if ($options)
            $this->setFromArray($options);
    }


    protected function setFromArray($options = array()) {
        if (isset($options['entity_manager']) && $options['entity_manager'] instanceof EntityManager) {
            $this->setEntityManager($options['entity_manager']);
        }
    }

    /**
     * @param \Doctrine\ORM\EntityManager $entityManager
     * @return $this
     */
    public function setEntityManager($entityManager) {
        $this->entityManager = $entityManager;

        return $this;
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager() {
        return $this->entityManager;
    }



} 