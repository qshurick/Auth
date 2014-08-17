<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 14.08.14
 * Time: 18:43
 */

namespace Auth\Event;


use Acl\Acl;
use Acl\Controller\SecureControllerInterface;
use Auth\Controller\Plugin\AuthPlugin;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\MvcEvent;
use Zend\Session\Container;
use Zend\Session\SessionManager;

class Authentication {

    const SESSION_ID_ALIAS = "ssid";

    /** @var AuthPlugin */
    protected $authPlugin;
    /** @var Acl */
    protected $acl;
    /** @var string */
    protected $sessionId;

    /**
     * @param string $sessionId
     */
    protected function setSessionId($sessionId) {
        $this->sessionId = $sessionId;
    }

    /**
     * @return string
     */
    protected function getSessionId() {
        return $this->sessionId;
    }

    /**
     * @param \Acl\Acl $acl
     * @return $this
     */
    public function setAcl($acl) {
        $this->acl = $acl;
        return $this;
    }

    /**
     * @return \Acl\Acl
     */
    public function getAcl() {
        return $this->acl;
    }

    /**
     * @param \Auth\Controller\Plugin\AuthPlugin $authPlugin
     * @return $this
     */
    public function setAuthPlugin($authPlugin) {
        $this->authPlugin = $authPlugin;
        return $this;
    }

    /**
     * @return \Auth\Controller\Plugin\AuthPlugin
     */
    public function getAuthPlugin() {
        return $this->authPlugin;
    }

    /**
     * @param \Zend\Http\PhpEnvironment\Request $request
     * @return string|null
     */
    protected function getSessionIdFromRequest($request) {
        $ssid = $request->getPost(static::SESSION_ID_ALIAS);
        if (!$ssid)
            $ssid = $request->getQuery(static::SESSION_ID_ALIAS);
        if (!$ssid)
            return null;
        return $ssid;
    }

    /**
     * @return string
     */
    protected function newSessionId() {
        return uniqid();
    }

    public function preDispatch(MvcEvent $event) {

        /** @var SessionManager $session */
        $session = $event->getTarget()->getServiceLocator()->get('Zend\Session\SessionManager');
        $oldSessionId = $this->getSessionIdFromRequest($event->getRequest());
        if ($oldSessionId)
            $session->setId($oldSessionId);
        $container = new Container('initialized');
        if ($container->offsetGet('init') === null) {
            $session->regenerateId();
            $container->offsetSet('init', 1);
        }

        $auth = $this->getAuthPlugin();
        $acl  = $this->getAcl();

        if ($auth->hasIdentity()) {
            $acl->setUserId($auth->getIdentity());
        }

        /** @var AbstractActionController|SecureControllerInterface $controller */
        $controller = $event->getTarget();
        if ($controller instanceof SecureControllerInterface &&
            !$acl->isAllowed($controller->getPrivileges())) {

            /** @var \Zend\Http\PhpEnvironment\Response $response */
            $response = $controller->getResponse();
            $response->setStatusCode(403);
            $response->setReasonPhrase("Permission denied");

            $model = new ApiModel($response);
            $model->setSessionId($this->getSessionId());

            $event->setViewModel($model);
            $event->stopPropagation(true);

        }
    }


} 