<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 15.08.14
 * Time: 17:11
 */

namespace Auth\Adapter;


use Auth\Exception\EmptyCredentialsException;
use Logger\Logger;
use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Result;

class GodAdapter implements  AdapterInterface {

    protected $userId;

    public function __construct($userId = null) {
        $this->userId = $userId;
    }

    /**
     * @param null $userId
     */
    public function setUserId($userId) {
        $this->userId = $userId;
    }


    /**
     * Performs an authentication attempt
     *
     * @return \Zend\Authentication\Result
     * @throws \Zend\Authentication\Adapter\Exception\ExceptionInterface If authentication cannot be performed
     */
    public function authenticate() {
        if (!$this->userId)
            throw new EmptyCredentialsException("C'mon! It's a test things, user ID just cannot be null.");
        Logger::getLogger(__CLASS__)->alert("Be sure it's only for testing: user #$this->userId was authenticated without credentials.");
        return new Result(Result::SUCCESS, $this->userId);
    }
}