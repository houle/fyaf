<?php

/**
 * Class     Base_Brand_Services
 * Brand的业务层基类
 *
 * @author   luoliang1
 */
class Base_Brand_Services extends Base_Services {

    /**
     * Variable  log_model
     * 日志模型
     *
     * @author   luoliang1
     * @var      null|Brand_LogModel
     */
    public $log_model = null;

    /**
     * Method  __construct
     * 构造方法
     *
     * @author luoliang1
     */
    public function __construct() {
        parent::__construct();

        //$this->log_model = new Brand_LogModel();
    }

}