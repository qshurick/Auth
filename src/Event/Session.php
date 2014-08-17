<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 17.08.14
 * Time: 12:27
 */

namespace Auth\Event;


use Auth\AuthenticationManager;
use Zend\Mvc\MvcEvent;
use Zend\Session\SessionManager;

class Session {
    public function preDispatch(MvcEvent $event) {
        $sessionManager = new SessionManager();

        $existedSessionId = $this->getSessionIfFromRequest($event->getRequest());
        if ($existedSessionId)
            $sessionManager->setId($existedSessionId);

        AuthenticationManager::getInstance()->setSessionManager($sessionManager);
    }
} 