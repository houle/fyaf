<?php

/**
 * Class     Type_Error
 * 错误类型
 *
 * @author   yangyang3
 */
class Type_Error extends Base_Types {

    /* 系统错误: 10000 */
    const SYSTEM_ERROR = 10001;

    const SYSTEM_READONLY = 10002;

    const CONFIG_FILE_ERROR = 10003;

    const CURRENT_IP_PERMISSION_DENIED = 10004;

    /* 请求方式错误: 11000 */
    const REQUEST_METHOD_MUST_BE_GET = 11001;

    const REQUEST_METHOD_MUST_BE_POST = 11002;

    const REQUEST_METHOD_MUST_BE_AJAX = 11003;

    /* 数据库错误: 12000 */
    const DB_SELECT_ERROR = 12001;

    const DB_INSERT_ERROR = 12002;

    const DB_UPDATE_ERROR = 12003;

    const DB_DELETE_ERROR = 12004;

    const DB_COMMIT_ERROR = 12005;

    /**
     * Variable  _mapping
     * 状态码和中文的映射
     *
     * @author   yangyang3
     * @static
     * @var      array
     */
    protected static $_mapping = array(
        self::SYSTEM_ERROR                 => '系统错误',
        self::SYSTEM_READONLY              => '当前时间系统不允许做任何写入操作',
        self::CONFIG_FILE_ERROR            => '配置文件错误',
        self::CURRENT_IP_PERMISSION_DENIED => '当前IP没有权限访问',

        self::REQUEST_METHOD_MUST_BE_GET   => '请求方式必须为GET',
        self::REQUEST_METHOD_MUST_BE_POST  => '请求方式必须为POST',
        self::REQUEST_METHOD_MUST_BE_AJAX  => '请求方式必须为AJAX',

        self::DB_SELECT_ERROR              => '数据库查询失败',
        self::DB_INSERT_ERROR              => '数据库写入失败',
        self::DB_UPDATE_ERROR              => '数据库更新失败',
        self::DB_DELETE_ERROR              => '数据库删除失败',
        self::DB_COMMIT_ERROR              => '数据库事务提交失败',
    );

}