<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 15.08.14
 * Time: 20:51
 */

namespace Auth;


use Auth\Adapter\AdapterInterface;
use Auth\Exception\RuntimeException;
use Zend\Http\PhpEnvironment\Request;
use Zend\ServiceManager\ServiceLocatorInterface;

class AdapterManager {

    protected $adapters = array(
        'simple' => 'dao.authentication.simple',
        'god' => 'dao.authentication.god',
//        'facebook' => '\Auth\Adapter\Facebook'
//        'twitter' => '\Auth\Adapter\Twitter'
    );

    /**
     * @param string $name
     * @param ServiceLocatorInterface $sl
     * @param Request $request
     * @throws Exception\RuntimeException
     * @return AdapterInterface
     */
    public function get($name, $sl, $request) {
        if ($this->has($name)) {
            $adapter = $sl->get($this->adapters[$name]);
            $adapter->setRequest($request);

            return $adapter;
        }
        throw new RuntimeException("Adapter '$name' not found");
    }

    /**
     * @param $name
     * @return bool
     */
    public function has($name) {
        return array_key_exists($name, $this->adapters);
    }
} 