<?php

/**
 * Class     Type_Ajax
 * Ajax类型
 *
 * @author   yangyang3
 */
class Type_Ajax extends Base_Type {

    /**
     * Variable  SUCCESS
     * 成功
     *
     * @author   yangyang3
     * @static
     * @var      int
     */
    const SUCCESS = 0;

    /**
     * Variable  SYSTEM_ERROR
     * 系统异常
     *
     * @author   yangyang3
     * @static
     * @var      int
     */
    const SYSTEM_ERROR = 1;

    /**
     * Variable  BUSINESS_ERROR
     * 业务异常
     *
     * @author   yangyang3
     * @static
     * @var      int
     */
    const BUSINESS_ERROR = 2;

    /**
     * Variable  _mapping
     * 状态码和中文的映射
     *
     * @author   yangyang3
     * @static
     * @var      array
     */
    protected static $_mapping = array(
        self::SUCCESS        => '成功',
        self::SYSTEM_ERROR   => '系统异常',
        self::BUSINESS_ERROR => '业务异常',
    );

}