<?php

/**
 * Class     Base_Brand_Models
 * Brand的模型基类
 *
 * @author   luoliang1
 */
class Base_Brand_Models extends Base_Models {

    /**
     * Method  __construct
     * 构造方法
     *
     * @author luoliang1
     *
     * @param string $module_name
     * @param string $table_name
     */
    public function __construct($module_name = null, $table_name = null) {
        if (null === $module_name) {
            $module_name = Yaf_Registry::get('module_name');
        }

        parent::__construct($module_name, $table_name);
    }

}