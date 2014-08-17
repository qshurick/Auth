<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 15.08.14
 * Time: 15:50
 */

namespace Auth\Adapter\Simple\Entity;


class AuthData {

    const SOFT_BLOCKED = 'soft-blocked';
    const HARD_BLOCKED = 'hard-blocked';
    const CHANGE_PASSWORD = 'change-password';
    const VALID = 'valid';

    /**
     * @var int
     */
    protected $userId;
    /**
     * @var string
     */
    protected $password;
    /**
     * @var string
     */
    protected $login;
    /**
     * @var string
     */
    protected $secret;

    /**
     * @var string
     */
    protected $status;

    /**
     * @param string $status
     */
    public function setStatus($status) {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * @param string $login
     */
    public function setLogin($login) {
        $this->login = $login;
    }

    /**
     * @return string
     */
    public function getLogin() {
        return $this->login;
    }

    /**
     * @param string $password
     */
    public function setPassword($password) {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * @param string $secret
     */
    public function setSecret($secret) {
        $this->secret = $secret;
    }

    /**
     * @return string
     */
    public function getSecret() {
        return $this->secret;
    }

    /**
     * @param int $userId
     */
    public function setUserId($userId) {
        $this->userId = $userId;
    }

    /**
     * @return int
     */
    public function getUserId() {
        return $this->userId;
    }

    public function isValid() {
        if ($this->getStatus()) {
            return $this->getStatus() === static::VALID || $this->getStatus() === static::CHANGE_PASSWORD;
        }
        return false;
    }

} 