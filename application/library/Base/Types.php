<?php

/**
 * Class     Base_Types
 * 全局的类型基类
 *
 * @author   yangyang3
 */
class Base_Types {

    /**
     * Variable  reflecation_class_list
     * 反射类列表
     *
     * @author   yangyang3
     * @static
     * @var      array
     */
    private static $reflecation_class_list = array();

    /**
     * Method  getConstantList
     * 获取对应类的常量列表
     *
     * @author yangyang3
     * @static
     * @return bool|array
     */
    public static function getConstantList() {
        //获取类名
        $class_name = get_called_class();

        //验证对应的反射类是否存在
        if (!isset(self::$reflecation_class_list[$class_name])) {
            //实例化反射对象
            self::$reflecation_class_list[$class_name] = new ReflectionClass($class_name);
        }

        //通过反射对象获取常量列表
        $constant_list = self::$reflecation_class_list[$class_name]->getConstants();

        //验证常量列表, 返回结果
        if (false === $constant_list || !is_array($constant_list)) {
            return false;
        }

        return $constant_list;
    }

    /**
     * Method  get
     * 获取value对应的常量名称
     *
     * @author yangyang3
     * @static
     *
     * @param $value
     *
     * @return bool|string
     */
    public static function get($value) {
        //获取常量列表
        $constant_list = self::getConstantList();

        //验证constant_list
        if (false === $constant_list) {
            return false;
        }

        //交换键值
        $constant_list = array_flip($constant_list);

        //验证是否为数字, 显示转换为整型
        if (is_numeric($value)) {
            $value = intval($value);
        }

        //验证value是否存在, 返回结果
        if (isset($constant_list[$value])) {
            return $constant_list[$value];
        } else {
            return false;
        }
    }

    /**
     * Method  getDesc
     * 获取value对应的描述
     *
     * @author yangyang3
     * @static
     *
     * @param $value
     *
     * @return bool|string
     */
    public static function getDesc($value) {
        //获取value对应的常量名称
        $constant = self::get($value);

        //验证常量名称
        if (false === $constant) {
            return false;
        }

        //转换格式返回
        return ucwords(strtolower(str_replace('_', ' ', $constant)));
    }

    /**
     * Method  getProperty
     * 获取对应类的属性
     *
     * @author yangyang3
     * @static
     * @return array
     */
    public static function getProperty($property = '_mapping') {
        $class = get_called_class();

        if (property_exists($class, $property)) {
            return $class::$$property;
        } else {
            return false;
        }
    }

    /**
     * Method  getString
     * 获取value对应的字符串
     *
     * @author yangyang3
     * @static
     *
     * @param $value
     *
     * @return string
     */
    public static function getString($value) {
        $mapping = self::getProperty('_mapping');

        if (false === $mapping) {
            return false;
        }

        if (isset($mapping[$value])) {
            return $mapping[$value];
        } else {
            return '';
        }
    }

    /**
     * Method  getMapping
     * 获取状态码和中文的映射关系
     *
     * @author yangyang3
     * @static
     * @return array
     */
    public static function getMapping() {
        return self::getProperty('_mapping');
    }

}