<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 15.08.14
 * Time: 21:21
 */

namespace Auth;


use Zend\View\Model\JsonModel;

class ApiResponse extends JsonModel {
    /** @var int  */
    protected $code;
    /** @var string  */
    protected $codeMessage;
    /** @var array */
    protected $warnings;
    /** @var array */
    protected $errors;
    /** @var array */
    protected $data;
    /** @var  array */
    protected $service;

    /**
     * @param int $code
     * @param string $codeMessage
     * @param array $data
     * @param array $errors
     * @param array $warnings
     */
    public function __construct($code = 200, $codeMessage = 'Ok', $data = array(), $errors = array(), $warnings = array()) {
        $this->code         = $code;
        $this->codeMessage  = $codeMessage;
        $this->data         = $data;
        $this->errors       = $errors;
        $this->warnings     = $warnings;
    }

    protected function _resetVariables() {
        $this->setVariables(array(
            'response-code' => $this->code,
            'response-message' => $this->codeMessage,
            'response-warnings' => $this->warnings,
            'response-errors' => $this->errors,
            'response-data' => $this->data,
            'response-service' => $this->service
        ));
    }

    /**
     * @param int $code
     */
    public function setCode($code) {
        $this->code = $code;
    }

    /**
     * @param string $codeMessage
     */
    public function setCodeMessage($codeMessage) {
        $this->codeMessage = $codeMessage;
    }

    /**
     * @param array $data
     */
    public function setData($data) {
        $this->data = $data;
    }

    /**
     * @param string $caption
     * @param string $message
     */
    public function addError($caption, $message) {
        $this->errors[$caption] = $message;
    }

    /**
     * @param string $caption
     * @param string $message
     */
    public function addWarning($caption, $message) {
        $this->warnings[$caption] = $message;
    }

    /**
     * @param string $name
     * @param mixed  $value
     */
    public function addServiceVariable($name, $value) {
        $this->service[$name] = $value;
    }


} 