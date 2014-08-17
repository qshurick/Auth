<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 15.08.14
 * Time: 19:52
 */

namespace Auth\Controller;


use Auth\AdapterManager;
use Auth\AuthenticationManager;
use Auth\AuthResponse;
use Zend\Mvc\Controller\AbstractActionController;

class AuthController extends AbstractActionController {
    public function indexAction() {
        $adapter = $this->params()->fromPost('adapter');
        $adapterManager = new AdapterManager();

        if ($adapterManager->has($adapter)) {
            $adapter = $adapterManager->get($adapter, $this->getServiceLocator(), $this->getRequest());
            $result = AuthenticationManager::getInstance()->getAuthenticationService()->authenticate($adapter);

            return new AuthResponse($result);
        }

        return new AuthResponse(AuthResponse::BAD_ADAPTER);
    }
} 