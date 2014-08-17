<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 15.08.14
 * Time: 18:17
 */

namespace Auth\Adapter;


use Zend\Http\PhpEnvironment\Request;

interface AdapterInterface extends \Zend\Authentication\Adapter\AdapterInterface {
    /**
     * @param array $options
     */
    public function setOptions($options = array());

    /**
     * @param \Zend\Http\PhpEnvironment\Request $request
     */
    public function setRequest($request);
} 