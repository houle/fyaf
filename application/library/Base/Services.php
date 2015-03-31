<?php

/**
 * Class     Base_Services
 * 全局的业务层基类
 *
 * @author   yangyang3
 */
class Base_Services {

    /**
     * Variable  _error_code
     * 错误编码
     *
     * @author   yangyang3
     * @var      int
     */
    protected $_error_code = 0;

    /**
     * Method  __construct
     * 构造方法
     *
     * @author yangyang3
     */
    public function __construct() {

    }

    /**
     * Method  _setErrorCode
     * 设置错误编码
     *
     * @author yangyang3
     *
     * @param $error_code
     */
    protected function _setErrorCode($error_code) {
        $this->_error_code = $error_code;
    }

    /**
     * Method  getErrorCode
     * 获取错误编码
     *
     * @author yangyang3
     * @return int
     */
    public function getErrorCode() {
        return $this->_error_code;
    }

}