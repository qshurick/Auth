<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 15.08.14
 * Time: 15:47
 */

namespace Auth\Adapter;


use Auth\Adapter\Simple\Entity\AuthData;
use Auth\Exception\EmptyCredentialsException;
use Logger\Logger;
use Logger\LoggerInterface;
use Zend\Authentication\Result;

class SimpleAdapter extends AbstractDoctrineAdapter {

    public static $DEBUG_MODE = false;
    /** @var LoggerInterface */
    protected static $logger;

    /**
     * @var string
     */
    protected $login;
    /**
     * @var string
     */
    protected $password;

    function __construct($login = null, $password = null, $options = array()) {
        $this->login = $login;
        $this->password = $password;

        if ($options)
            $this->setOptions($options);

        static::$logger = Logger::getLogger(__CLASS__);
    }

    /**
     * @param string $login
     */
    public function setLogin($login) {
        $this->login = $login;
    }

    /**
     * @param string $password
     */
    public function setPassword($password) {
        $this->password = $password;
    }

    /**
     * @return null|string
     */
    protected function getLogin() {
        if (!$this->login && $this->getRequest()) {
            $this->login = $this->getRequest()->getPost('login');
        }
        return $this->login;
    }

    /**
     * @return null|string
     */
    protected function getPassword() {
        if (!$this->password && $this->getRequest()) {
            $this->password = $this->getRequest()->getPost('password');
        }
        return $this->password;
    }

    /**
     * @param string $login
     * @return AuthData
     */
    private function getUserData($login) {
        $em = $this->getEntityManager();
        $repo = $em->getRepository('\Auth\Adapter\Simple\Entity\AuthData');

        /** @var AuthData $data */
        $data = $repo->findOneBy(array(
            'login' => $this->login
        ));

        return $data;
    }

    /**
     * Performs an authentication attempt
     *
     * @return \Zend\Authentication\Result
     * @throws \Zend\Authentication\Adapter\Exception\ExceptionInterface If authentication cannot be performed
     */
    public function authenticate() {

        $login    = $this->getLogin();
        $password = $this->getPassword();

        if (!$login || !$password) {
            throw new EmptyCredentialsException();
        }

        $data = $this->getUserData($login);

        if ($data === null) {
            static::$logger->info("Fail login: user not found '$login'");
            return new Result(Result::FAILURE_IDENTITY_NOT_FOUND, null);
        }

        if ($data->getPassword() === md5($data->getSecret() . $password)) {
            if ($data->isValid()) {
                static::$logger->info("Successful authentication for '$login'");
                return new Result(Result::SUCCESS, $data->getUserId());
            }
            static::$logger->info("Fail authentication for '$login'. User is blocked: '" . $data->getStatus() . "'");
            return new Result(Result::FAILURE_IDENTITY_AMBIGUOUS, $data->getUserId());
        }

        static::$logger->info("Fail authentication: wrong password for '$login'");
        return new Result(Result::FAILURE_CREDENTIAL_INVALID, null);
    }
}