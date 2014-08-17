<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 15.08.14
 * Time: 14:41
 */

namespace Auth\Adapter;


use Auth\Exception\RuntimeException;

abstract class AbstractDoctrineAdapter implements AdapterInterface {

    /** @var DoctrineAdapterOptions */
    protected $options;
    /** @var \Doctrine\ORM\EntityManager */
    protected $entityManager;
    /** @var \Zend\Http\PhpEnvironment\Request */
    protected $request;

    /**
     * @param \Zend\Http\PhpEnvironment\Request $request
     */
    public function setRequest($request) {
        $this->request = $request;
    }

    /**
     * @return \Zend\Http\PhpEnvironment\Request
     */
    public function getRequest() {
        return $this->request;
    }

    /**
     * @param DoctrineAdapterOptions|array $options
     */
    public function setOptions($options = array()) {
        if (is_array($options))
            $options = new DoctrineAdapterOptions($options);
        $this->options = $options;
    }

    /**
     * @return DoctrineAdapterOptions
     */
    public function getOptions() {
        return $this->options;
    }

    /**
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    public function setEntityManager($entityManager) {
        $this->entityManager = $entityManager;
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     * @throws \Auth\Exception\RuntimeException
     */
    public function getEntityManager() {
        if (!$this->entityManager) {
            if ($this->getOptions()) {
                if ($this->getOptions()->getEntityManager()) {
                    $this->entityManager = $this->getOptions()->getEntityManager();
                    return $this->entityManager;
                }
            }
            throw new RuntimeException("EntityManager doesn't set!");
        }
        return $this->entityManager;

    }
}