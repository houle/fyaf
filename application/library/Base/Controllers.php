<?php

/**
 * Class     Base_Controllers
 * 全局的控制器基类
 *
 * @author   yangyang3
 */
class Base_Controllers extends Yaf_Controller_Abstract {

    // 模型
    protected $models = array();
    // 用户信息
    protected $userInfo = array();
    // 管理员信息
    protected $adminInfo = array();


    /**
     * Variable  request
     * request对象
     *
     * @author   yangyang3
     * @var      object
     */
    public $request = null;

    /**
     * Variable  view
     * view对象
     *
     * @author   yangyang3
     * @var      object
     */
    public $view = null;

    /**
     * Method  init
     * 初始化方法
     *
     * @author yangyang3
     */
    public function init() {
        $this->request = $this->getRequest();

        $this->view = $this->getView();
        
    }

    /**
     * Method  matchRequestSuffix
     * 匹配请求后缀
     *
     * @author yangyang3
     *
     * @param string $suffix
     *
     * @return bool
     */
    public function matchRequestSuffix($suffix = '') {
        $result = Yaf_Registry::get('request_suffix') === ltrim($suffix, '.');

        return $result;
    }

    /**
     * Method  jsonOutput
     * 转换为JSON格式输出
     *
     * @author yangyang3
     *
     * @param array|null $data
     */
    public function jsonOutput($data = array()) {
        echo json_encode($data);

        exit();
    }

    /**
     * Method  jsonReturn
     * JSON返回方法
     *
     * @author yangyang3
     *
     * @param array|null $data
     * @param bool       $is_unescaped_unicode
     */
    public function jsonReturn($data = array(), $is_unescaped_unicode = false) {
        $message = array(
            'data' => $data
        );

        if (false === $is_unescaped_unicode) {
            echo json_encode($message);
        } else {
            echo json_encode($message, JSON_UNESCAPED_UNICODE);
        }

        exit();
    }

    /**
     * Method  commandReturn
     * 命令返回方法
     *
     * @author yangyang3
     *
     * @param array|null $data
     */
    public function commandReturn($data) {
        print_r($data);

        exit();
    }

    /**
     * Method  success
     * 返回成功方法
     *
     * @author yangyang3
     */
    public function success() {
        $message = array(
            'result' => true
        );

        echo json_encode($message);

        exit();
    }

    /**
     * Method  error
     * 返回失败方法
     *
     * @author yangyang3
     *
     * @param int    $error_code
     * @param string $error
     */
    public function error($error_code, $error = null) {
        $message = array(
            'request'    => Yaf_Registry::get('request_uri'),
            'error_code' => intval($error_code),
            'error'      => $error
        );

        if (null === $message['error']) {
            $message['error'] = Type_Error::getDesc($error_code);
        }

        echo json_encode($message);

        exit();
    }

    /**
     * Method  jsonSuccess
     * JSON返回成功方法
     *
     * @author yangyang3
     *
     * @param array $data
     */
    public function jsonSuccess(array $data = array()) {
        $data = array(
            'data'       => $data,
            'statusInfo' => array(),
            'status'     => Type_Ajax::SUCCESS
        );

        $this->jsonOutput($data);
    }

    /**
     * Method  jsonError
     * JSON返回失败方法
     *
     * @author yangyang3
     *
     * @param int    $error_code
     * @param string $message
     */
    public function jsonError($error_code, $message = null) {
        $data = array(
            'data'       => new stdClass(),
            'statusInfo' => array(),
            'status'     => Type_Ajax::BUSINESS_ERROR
        );

        if (null === $message) {
            $message = Type_Error::getString($error_code);
        }

        $data['statusInfo'][] = $message;

        $this->jsonOutput($data);
    }

}