<?php

/**
 * Class     Base_Command_Controllers
 * 命令行的控制器基类
 *
 * @author   yangyang3
 */
class Base_Command_Controllers extends Base_Controllers {

    /**
     * Method  init
     * 初始化方法
     *
     * @author yangyang3
     */
    public function init() {
        parent::init();

        $this->_validation();
    }

    /**
     * Method  _validation
     * 验证方法
     *
     * @author yangyang3
     */
    private function _validation() {
        if (!$this->request->isCli()) {
            $this->error(Type_Error::SYSTEM_ERROR);
        }
    }

}