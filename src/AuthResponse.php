<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 15.08.14
 * Time: 21:00
 */

namespace Auth;


use Zend\Authentication\Result;
use Zend\View\Model\JsonModel;

class AuthResponse extends ApiResponse {

    const BAD_ADAPTER = 1;

    /**
     * @param Result|string $result
     */
    public function __construct($result) {
        if (is_string($result) && $result === static::BAD_ADAPTER) {
            $this->setCode(503);
            $this->addError('Authentication error', 'Authentication service temporary not available. Please try again later or contact with support team.');
        } elseif ($result instanceof Result) {
            switch ($result->getCode()) {
                case Result::SUCCESS:
                    break;
                case Result::FAILURE_IDENTITY_NOT_FOUND:
                    $this->addError('identity', "User not registered on the server");
                    break;
                case Result::FAILURE_IDENTITY_AMBIGUOUS:
                    $this->addError('Authentication error', 'User is blocked. Check your mailbox or contact with support team to get a reason.');
                    break;
                default:
                    $this->addError('credentials', "Wrong password");
            }
        }
    }
}