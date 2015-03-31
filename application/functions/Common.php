<?php
/**
 * Method  dump
 * dump调试方法
 *
 * @author yangyang3
 */
function dump() {
    $argument_list = func_get_args();

    echo "<pre>";

    foreach ($argument_list as $variable) {
        if (is_array($variable)) {
            print_r($variable);
        } else {
            var_dump($variable);
        }
    }

    echo "</pre>\n";
}

/**
 * Method  x
 * 调试方法
 *
 * @author luoliang1
 */
function x() {
    $argument_list = func_get_args();

    $called = debug_backtrace();

    echo '<pre>' . PHP_EOL;

    foreach ($argument_list as $variable) {

        echo '<strong>' . $called[0]['file'] . ' (line ' . $called[0]['line'] . ')</strong> ' . PHP_EOL;

        if (is_array($variable)) {
            print_r($variable);
        } else {
            var_dump($variable);
        }

        echo PHP_EOL;
    }

    echo '</pre>' . PHP_EOL;
    exit();
}

/**
 * Method  import_service_by_module_name
 * 根据Module名称导入对应的Service
 *
 * @author yangyang3
 *
 * @param $module_name
 *
 * @return bool
 */
function import_service_by_module_name($module_name) {
    $config = Yaf_Registry::get('config')->application->toArray();

    $key = strtolower($module_name);

    if (empty($config[$key]['services'])) {
        return false;
    }

    foreach ($config[$key]['services'] as $service_name) {
        Yaf_Loader::import("{$config['services']}/{$module_name}/{$service_name}.{$config['ext']}");
    }

    return true;
}

/**
 * Method  get_config_by_key
 * 通过Key获取对应的配置
 *
 * @author yangyang3
 *
 * @param $key
 *
 * @return mixed|Yaf_Config_Ini
 */
function get_config_by_key($key) {
    $config_key = $key . '_config';

    $config = Yaf_Registry::get($config_key);

    if (null === $config) {
        $config_file = Yaf_Registry::get('config')->application->config->$key;

        if (null !== $config_file) {
            //dump($config_file);
            $config = new Yaf_Config_Ini($config_file);

            Yaf_Registry::set($config_key, $config);
        }
    }
    //var_dump($config);die;
    return $config;
}

/**
 * Method  underline_to_camel
 * 下划线转驼峰
 *
 * @author yangyang3
 *
 * @param string $string
 * @param bool   $is_ignore_uppercase
 *
 * @return string
 */
function underline_to_camel($string, $is_ignore_uppercase = false) {
    if (false === $is_ignore_uppercase) {
        return preg_replace('/_([a-zA-Z])/e', "strtoupper('\\1')", $string);
    } else {
        return preg_replace('/_([a-z])/e', "strtoupper('\\1')", $string);
    }
}

/**
 * Method  camel_to_underline
 * 驼峰转下划线
 *
 * @author yangyang3
 *
 * @param $string
 *
 * @return string
 */
function camel_to_underline($string) {
    return strtolower(preg_replace('/(?!^)(?=[A-Z])/', '_', $string));
}

/**
 * Method  replace_space_character
 * 替换空格字符
 *
 * @author yangyang3
 *
 * @param string $string
 * @param string $replace_string
 *
 * @return string
 */
function replace_space_character($string, $replace_string = '') {
    return preg_replace('/\s+|　/', $replace_string, $string);
}

/**
 * Method  replace_tab_character
 * 替换制表符
 *
 * @author yangyang3
 *
 * @param string $string
 * @param string $replace_string
 *
 * @return mixed
 */
function replace_tab_character($string, $replace_string = '') {
    return preg_replace('/[\n\r\t]/', $replace_string, $string);
}

/**
 * Method  calculate_signature
 *
 * @author yangyang3
 *
 * @param $id
 * @param $secret_key
 * @param $timestamp
 *
 * @return string
 */
function calculate_signature($id, $secret_key, $timestamp) {
    return md5(intval($id) . $secret_key . $timestamp);
}

/**
 * Method  get_client_ip
 * 获取客户端IP
 *
 * @author yangyang3
 * @return bool|string
 */
function get_client_ip() {
    //验证HTTP头中是否有REMOTE_ADDR
    if (!isset($_SERVER['REMOTE_ADDR'])) {
        return '127.0.0.1';
    }

    //验证是否为非私有IP
    if (filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE)) {
        return $_SERVER['REMOTE_ADDR'];
    }

    //验证HTTP头中是否有HTTP_X_FORWARDED_FOR
    if (!isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['REMOTE_ADDR'];
    }

    //定义客户端IP
    $client_ip = '';

    //获取", "的位置
    $position = strrpos($_SERVER['HTTP_X_FORWARDED_FOR'], ', ');

    //验证$position
    if (false === $position) {
        $client_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $client_ip = substr($_SERVER['HTTP_X_FORWARDED_FOR'], $position + 2);
    }

    //验证$client_ip是否为合法IP
    if (filter_var($client_ip, FILTER_VALIDATE_IP)) {
        return $client_ip;
    } else {
        return false;
    }
}

/**
 * Returns the values from a single column of the input array, identified by
 * the $columnKey.
 * Optionally, you may provide an $indexKey to index the values in the returned
 * array by the values from the $indexKey column in the input array.
 *
 * @param array $input     A multi-dimensional array (record set) from which to pull
 *                         a column of values.
 * @param mixed $columnKey The column of values to return. This value may be the
 *                         integer key of the column you wish to retrieve, or it
 *                         may be the string key name for an associative array.
 * @param mixed $indexKey  (Optional.) The column to use as the index/keys for
 *                         the returned array. This value may be the integer key
 *                         of the column, or it may be the string key name.
 *
 * @return array
 * @link http://www.php.net/manual/en/function.array-column.php  since php 5.5.0
 * @link https://github.com/ramsey/array_column/blob/master/src/array_column.php
 */
function array_column($input = null, $columnKey = null, $indexKey = null) {
    // Using func_get_args() in order to check for proper number of
    // parameters and trigger errors exactly as the built-in array_column()
    // does in PHP 5.5.
    $argc   = func_num_args();
    $params = func_get_args();

    if ($argc < 2) {
        trigger_error("array_column() expects at least 2 parameters, {$argc} given", E_USER_WARNING);

        return null;
    }

    //add by wenyue1
    if (empty($params[0]) || empty($params[1])) {
        return array();
    }
    //added

    if (!is_array($params[0])) {
        trigger_error('array_column() expects parameter 1 to be array, ' . gettype($params[0]) . ' given', E_USER_WARNING);

        return null;
    }

    if (!is_int($params[1]) && !is_float($params[1]) && !is_string($params[1]) && $params[1] !== null && !(is_object($params[1]) && method_exists($params[1], '__toString'))) {
        trigger_error('array_column(): The column key should be either a string or an integer', E_USER_WARNING);

        return false;
    }

    if (isset($params[2]) && !is_int($params[2]) && !is_float($params[2]) && !is_string($params[2]) && !(is_object($params[2]) && method_exists($params[2], '__toString'))) {
        trigger_error('array_column(): The index key should be either a string or an integer', E_USER_WARNING);

        return false;
    }

    $paramsInput     = $params[0];
    $paramsColumnKey = ($params[1] !== null) ? (string)$params[1] : null;

    $paramsIndexKey = null;
    if (isset($params[2])) {
        if (is_float($params[2]) || is_int($params[2])) {
            $paramsIndexKey = (int)$params[2];
        } else {
            $paramsIndexKey = (string)$params[2];
        }
    }

    $resultArray = array();

    foreach ($paramsInput as $row) {

        $key    = $value = null;
        $keySet = $valueSet = false;

        if ($paramsIndexKey !== null && array_key_exists($paramsIndexKey, $row)) {
            $keySet = true;
            $key    = (string)$row[$paramsIndexKey];
        }

        if ($paramsColumnKey === null) {
            $valueSet = true;
            $value    = $row;
        } elseif (is_array($row) && array_key_exists($paramsColumnKey, $row)) {
            $valueSet = true;
            $value    = $row[$paramsColumnKey];
        }

        if ($valueSet) {
            if ($keySet) {
                $resultArray[$key] = $value;
            } else {
                $resultArray[] = $value;
            }
        }

    }

    return $resultArray;
}

/**
 * Method  array_rebuild
 * 通过新的Key重建数组索引
 *
 * @author yangyang3
 *
 * @param array  $array
 * @param string $key
 * @param array  $keep_key_list
 *
 * @return array
 */
function array_rebuild(array $array, $key, array $keep_key_list = array()) {
    $data = array();

    if (empty($array) || empty($key)) {
        return $data;
    }

    if (!empty($keep_key_list)) {
        $keep_key_list = array_flip($keep_key_list);
    }

    $keep_key_list_count = count($keep_key_list);

    foreach ($array as $info) {
        if (isset($info[$key])) {
            if ($keep_key_list_count === 0) {
                $data[$info[$key]] = $info;
            } elseif ($keep_key_list_count > 1) {
                $data[$info[$key]] = array_intersect_key($info, $keep_key_list);
            } else {
                $data[$info[$key]] = $info[key($keep_key_list)];
            }
        }
    }

    return $data;
}

/**
 * Method  array_group
 * 通过新的Key分组, 并支持保留指定参数
 *
 * @author wenjun5 yangyang3
 *
 * @param array  $array
 * @param string $key
 * @param array  $keep_key_list
 *
 * @return array
 */
function array_group(array $array, $key, array $keep_key_list = array()) {
    $data = array();

    if (empty($array) || empty($key)) {
        return $data;
    }

    if (!empty($keep_key_list)) {
        $keep_key_list = array_flip($keep_key_list);
    }

    $keep_key_list_count = count($keep_key_list);

    foreach ($array as $info) {
        if (isset($info[$key])) {
            if ($keep_key_list_count === 0) {
                $data[$info[$key]][] = $info;
            } elseif ($keep_key_list_count > 1) {
                $data[$info[$key]][] = array_intersect_key($info, $keep_key_list);
            } else {
                $data[$info[$key]][] = $info[key($keep_key_list)];
            }
        }
    }

    return $data;
}

/**
 * Method  get_current_page_url
 * 获取当前页面的URL
 *
 * @author yangyang3
 * @return bool|string
 */
function get_current_page_url() {
    if (!isset($_SERVER['SERVER_NAME'], $_SERVER['SERVER_PORT'], $_SERVER['REQUEST_URI'])) {
        return false;
    }

    $url = 'http';

    if (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) === 'on') {
        $url .= 's';
    }
    $url .= '://';

    if ((int)$_SERVER['SERVER_PORT'] !== 80) {
        $url .= $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . $_SERVER['REQUEST_URI'];
    } else {
        $url .= $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    }

    return $url;
}

/**
 * Method  get_server_ip
 * 获取服务器IP地址
 *
 * @author yangyang3
 * @return string
 */
function get_server_ip() {
    $ip = '';

    for ($index = 1; $index >= 0; --$index) {
        $output = array();

        exec("/sbin/ifconfig | grep eth{$index}", $output);

        if (!empty($output)) {
            $output = array();

            exec("/sbin/ifconfig eth{$index} | grep 'inet addr' | sed -e 's/\\(^ *\\)//' | awk -F '[ :]' '{print $3}'", $output);

            if (isset($output[0])) {
                $ip = $output[0];
            }

            return $ip;
        }
    }

    return '0.0.0.0';
}

/**
 * Method  get_chinese_string_length
 * 获取中文字符串长度
 *
 * @author yangyang3
 *
 * @param string $string
 *
 * @return int
 */
function get_chinese_string_length($string) {
    $string = trim($string);

    if ('' === $string) {
        return 0;
    }

    $string_length = mb_strlen($string, 'UTF-8');

    $chinese_string_length = mb_strlen(preg_replace('/[0-9a-z\s]+/is', '', $string), 'UTF-8');

    if ($string_length === $chinese_string_length) {
        return $string_length;
    }

    return $chinese_string_length + ceil(($string_length - $chinese_string_length) / 2);
}

/**
 * Method  mb_str_split
 * 根据字符编码将字符串转换为数组
 *
 * @author yangyang3
 *
 * @param string $string
 * @param string $charset
 *
 * @return array
 */
function mb_str_split($string, $charset = 'UTF-8') {
    if (empty($string)) {
        return '';
    }

    if (strtoupper($charset) === 'UTF-8') {
        return preg_split('/(?<!^)(?!$)/u', $string);
    } else {
        return preg_split('/(?<!^)(?!$)/', $string);
    }
}

/**
 * Method  get_sub_chinese_string_length
 * 获取截取中文字符串的长度
 *
 * @author yangyang3
 *
 * @param string $string
 * @param string $max_length
 *
 * @return int|string
 */
function get_sub_chinese_string_length($string, $max_length) {
    $string_length = 0;

    $sub_string_length = 0;

    $character_list = mb_str_split(strtolower($string));

    foreach ($character_list as $key => $character) {
        if (is_numeric($character) || ($character >= 'a' && $character <= 'z')) {
            if ($string_length + 0.5 >= $max_length) {
                break;
            }
            $string_length += 0.5;
        } else {
            if ($string_length + 1 >= $max_length) {
                break;
            }
            $string_length += 1;
        }

        $sub_string_length = $key + 1;
    }

    return $sub_string_length;
}

/**
 * Method  get_last_sql
 * 获取最后一条执行的SQL
 *
 * @author yangyang3
 * @return bool|string
 */
function get_last_sql() {
    $last_sql_string = Yaf_Registry::get('last_sql_string');
    $last_sql_data   = Yaf_Registry::get('last_sql_data');

    if (empty($last_sql_string)) {
        return false;
    }

    $sql    = '';
    $count  = 0;
    $length = strlen($last_sql_string);

    for ($i = 0; $i < $length; $i++) {
        if ($last_sql_string[$i] !== '?') {
            $sql .= $last_sql_string[$i];
        } else {
            if (isset($last_sql_data[$count])) {
                $sql .= "'" . $last_sql_data[$count++] . "'";
            } else {
                $sql .= $last_sql_string[$i];
            }
        }
    }

    return $sql;
}

/**
 * Method  sub_chinese_string
 * 截取中文字符串
 *
 * @author yangyang3
 *
 * @param string $string
 * @param int    $max_length
 * @param int    $sub_string_length
 * @param string $suffix
 * @param bool   $htmlspecialchars
 * @param string $encoding
 *
 * @return string
 */
function sub_chinese_string($string, $max_length, $sub_string_length, $suffix = '...', $htmlspecialchars = false, $encoding = 'UTF-8') {
    if (mb_strlen($string, $encoding) > $max_length) {
        $string = mb_substr($string, 0, $sub_string_length, $encoding) . $suffix;
    }

    return $htmlspecialchars ? htmlspecialchars($string, ENT_QUOTES) : $string;
}

/**
 * Method  get_topic_summary_length_by_display_name
 * 根据话题标题获取话题描述长度
 *
 * @author yangyang3
 *
 * @param string $display_name
 * @param string $category_name
 * @param string $province_name
 *
 * @return int
 */
function get_topic_summary_length_by_display_name($display_name, $category_name, $province_name = '') {
    //(326 - mb_strlen('显示的话题词', 'UTF-8') * 16 - mb_strlen('标签名', 'UTF-8') * 12 - mb_strlen('省份名', 'UTF-8') * 12) / 12
    return intval((326 - mb_strlen($display_name, 'UTF-8') * 16 - mb_strlen($category_name, 'UTF-8') * 12 - mb_strlen($province_name, 'UTF-8') * 12) / 12);
}

/**
 * Method  get_short_urls_by_text
 * 通过文本获取短链列表
 *
 * @author yangyang3
 *
 * @param $text
 *
 * @return array|bool
 */
function get_short_urls_by_text($text) {
    if (empty($text)) {
        return false;
    }

    if (preg_match_all('/http:\/\/t\.cn\/[a-z0-9]+/i', $text, $matches)) {
        return array_unique($matches[0]);
    }

    return false;
}

/**
 * Method  filter_html
 * 过滤HTML
 *
 * @author luoliang1
 *
 * @param $value
 *
 * @return string
 */
function filter_html($value) {
    if (null === $value) {
        return null;
    }

    if (is_array($value)) {
        foreach ($value as $k => $v) {
            $value[$k] = htmlspecialchars($v, ENT_QUOTES);
        }
    } else {
        $value = htmlspecialchars($value, ENT_QUOTES);
    }

    return $value;
}