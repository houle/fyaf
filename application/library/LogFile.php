<?php

/**
 * Class     LogFile
 * 日志文件类
 *
 * @author   yangyang3
 */
class LogFile {

    /**
     * Variable  _file_template
     * 文件模板
     *
     * @author   yangyang3
     * @static
     * @var      null
     */
    private static $_file_template = null;

    /**
     * Variable  _default_file_template
     * 默认文件模板
     *
     * @author   yangyang3
     * @static
     * @var      string
     */
    private static $_default_file_template = '{date}(Ymd)_{module}_{type}.log';

    /**
     * Variable  _content_template
     * 内容模板
     *
     * @author   yangyang3
     * @static
     * @var      null
     */
    private static $_content_template = null;

    /**
     * Variable  _default_content_template
     * 默认内容模板
     *
     * @author   yangyang3
     * @static
     * @var      string
     */
    private static $_default_content_template = "{date}(Y-m-d H:i:s) {request_id} {content} in {file} at {line}\n";

    /**
     * Variable  _module_name
     * 模块名称
     *
     * @author   yangyang3
     * @static
     * @var      null
     */
    private static $_module_name = null;

    /**
     * Variable  _default_module_name
     * 默认模块名称
     *
     * @author   yangyang3
     * @static
     * @var      string
     */
    private static $_default_module_name = 'default';

    /**
     * Variable  _type_list
     * 类型列表
     *
     * @author   yangyang3
     * @static
     * @var      array
     */
    private static $_type_list = array(
        'trace',
        'debug',
        'info',
        'warning',
        'error',
        'message',
        'mail',
        'api',
        'post',
        'crm',
    );

    /**
     * Variable  _default_type
     * 默认类型
     *
     * @author   yangyang3
     * @static
     * @var      string
     */
    private static $_default_type = 'default';

    /**
     * Method  setConfig
     * 设置配置
     *
     * @author yangyang3
     * @static
     *
     * @param array $config
     */
    public static function setConfig($config = array()) {
        if (empty($config['file_template'])) {
            if (self::$_file_template === null) {
                self::$_file_template = Yaf_Registry::get('config')->application->logs . '/' . self::$_default_file_template;
            }
        } else {
            self::$_file_template = Yaf_Registry::get('config')->application->logs . '/' . $config['file_template'];
        }

        if (empty($config['content_template'])) {
            if (self::$_content_template === null) {
                self::$_content_template = self::$_default_content_template;
            }
        } else {
            self::$_content_template = $config['content_template'];
        }

        if (empty($config['module_name'])) {
            if (self::$_module_name === null) {
                $module_name = Yaf_Registry::get('module_name');
                if (!empty($module_name)) {
                    self::$_module_name = strtolower($module_name);
                } else {
                    self::$_module_name = self::$_default_module_name;
                }
            }
        } else {
            self::$_module_name = $config['module_name'];
        }
    }

    /**
     * Method  setFileTemplate
     * 设置文件模板
     *
     * @author yangyang3
     * @static
     *
     * @param $file_template
     */
    public static function setFileTemplate($file_template) {
        self::$_file_template = Yaf_Registry::get('config')->application->logs . '/' . $file_template;
    }

    /**
     * Method  setContentemplate
     * 设置内容模板
     *
     * @author yangyang3
     * @static
     *
     * @param $content_template
     */
    public static function setContentemplate($content_template) {
        self::$_content_template = $content_template;
    }

    /**
     * Method  setModuleName
     * 设置模块名称
     *
     * @author yangyang3
     * @static
     *
     * @param $module_name
     */
    public static function setModuleName($module_name) {
        self::$_module_name = $module_name;
    }

    /**
     * Method  trace
     * 写入trace类型日志
     *
     * @author yangyang3
     * @static
     *
     * @param $content
     */
    public static function trace($content) {
        self::write('trace', $content, true);
    }

    /**
     * Method  debug
     * 写入debug类型日志
     *
     * @author yangyang3
     * @static
     *
     * @param $content
     */
    public static function debug($content) {
        self::write('debug', $content, true);
    }

    /**
     * Method  info
     * 写入info类型日志
     *
     * @author yangyang3
     * @static
     *
     * @param $content
     */
    public static function info($content) {
        self::write('info', $content, true);
    }

    /**
     * Method  warning
     * 写入warning类型日志
     *
     * @author yangyang3
     * @static
     *
     * @param $content
     */
    public static function warning($content) {
        self::write('warning', $content, true);
    }

    /**
     * Method  error
     * 写入error类型日志
     *
     * @author yangyang3
     * @static
     *
     * @param $content
     */
    public static function error($content) {
        self::write('error', $content, true);
    }

    /**
     * Method  message
     * 写入message类型日志
     *
     * @author yangyang3
     * @static
     *
     * @param $content
     */
    public static function message($content) {
        self::write('message', $content, true);
    }

    /**
     * Method  mail
     * 写入mail类型日志
     *
     * @author yangyang3
     * @static
     *
     * @param $content
     */
    public static function mail($content) {
        self::write('mail', $content, true);
    }

    /**
     * Method  api
     * 写入api类型日志
     *
     * @author yangyang3
     * @static
     *
     * @param $content
     */
    public static function api($content) {
        self::write('api', $content, true);
    }

    /**
     * Method  post
     * 写入post类型日志
     *
     * @author yangyang3
     * @static
     *
     * @param $content
     */
    public static function post($content) {
        self::write('post', $content, true);
    }

    /**
     * Method  crm
     * 写入crm类型日志
     *
     * @author yangyang3
     * @static
     *
     * @param $content
     */
    public static function crm($content) {
        self::write('crm', $content, true);
    }

    /**
     * Method  write
     * 写入日志
     *
     * @author yangyang3
     * @static
     *
     * @param string $type
     * @param string $content
     * @param bool   $is_self_call
     */
    public static function write($type, $content, $is_self_call = true) {
        //验证所需变量
        if (empty(self::$_file_template) || empty(self::$_content_template) || empty(self::$_module_name)) {
            self::setConfig();
        }

        //过滤日志类型
        if (!in_array(strtolower($type), self::$_type_list)) {
            $type = self::$_default_type;
        }

        //获取back trace
        $backtrace_list = debug_backtrace();

        //验证是否为类内调用
        if (true === $is_self_call && isset($backtrace_list[1])) {
            //如果是类内调用, 取下标为1的元素
            $file = $backtrace_list[1]['file'];
            $line = $backtrace_list[1]['line'];
        } else {
            //如果非类内调用, 取下标为0的元素
            $file = $backtrace_list[0]['file'];
            $line = $backtrace_list[0]['line'];
        }

        //替换内容
        $search = array(
            '{request_id}',
            '{content}',
            '{file}',
            '{line}',
        );

        $replace = array(
            Yaf_Registry::get('request_id'),
            $content,
            $file,
            $line,
        );

        $content = self::_replaceTemplate($search, $replace, self::$_content_template);

        //替换文件
        $search = array(
            '{module}',
            '{type}'
        );

        $replace = array(
            self::$_module_name,
            $type
        );

        $file = self::_replaceTemplate($search, $replace, self::$_file_template);

        //写入文件
        self::_writeToFile($file, $content);
    }

    /**
     * Method  _replaceTemplate
     * 解析模板
     *
     * @author yangyang3
     * @static
     *
     * @param $type
     * @param $template
     *
     * @return mixed
     */
    private static function _replaceTemplate($search, $replace, $template) {
        $template = preg_replace('/{date}\((.*)\)/e', "date('\\1')", $template);

        return str_replace($search, $replace, $template);
    }

    /**
     * Method  _writeToFile
     * 写入文件
     *
     * @author yangyang3
     * @static
     *
     * @param string $file
     * @param string $content
     * @param string $mode
     *
     * @return bool
     */
    private static function _writeToFile($file, $content, $mode = 'a') {
        $handle = fopen($file, $mode);

        if (false === $handle) {
            return false;
        }

        $is_locked = flock($handle, LOCK_EX);

        $micro_start_time = microtime(true);

        do {
            if (false === $is_locked) {
                usleep(round(rand(0, 100) * 100));
            }
        } while (false === $is_locked && (microtime(true) - $micro_start_time) < 1000);

        if (true === $is_locked) {
            fwrite($handle, $content);

            flock($handle, LOCK_UN);
        }

        fclose($handle);

        return true;
    }
}