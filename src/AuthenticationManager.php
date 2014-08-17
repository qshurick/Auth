<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 17.08.14
 * Time: 12:30
 */

namespace Auth;


use Auth\Adapter\AdapterInterface;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session;
use Zend\Session\SessionManager;

class AuthenticationManager {
    /** @var  SessionManager */
    protected $sessionManager;
    /** @var AdapterInterface */
    protected $adapter;

    /** @var AuthenticationManager */
    protected static $instance;

    /**
     * @return AuthenticationManager
     */
    public static function getInstance() {
        if (!static::$instance)
            static::$instance = new self();
        return static::$instance;
    }

    /**
     * @param \Zend\Session\SessionManager $sessionManager
     */
    public function setSessionManager($sessionManager) {
        $this->sessionManager = $sessionManager;
    }

    /**
     * @param \Auth\Adapter\AdapterInterface $adapter
     */
    public function setAdapter($adapter) {
        $this->adapter = $adapter;
    }

    /**
     * @return AuthenticationService
     */
    public function getAuthenticationService() {
        return new AuthenticationService(new Session('dao-auth', null, $this->sessionManager), $this->adapter);
    }
} 