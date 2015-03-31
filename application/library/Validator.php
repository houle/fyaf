<?php

/**
 * Class     Validator
 * 验证类
 *
 * @author   yangyang3
 */
class Validator {

    /**
     * Method  regex
     * 正则验证方法
     *
     * @author yangyang3
     * @static
     *
     * @param string $variable
     * @param string $pattern
     *
     * @return bool
     */
    public static function is_match_regex($variable = '', $pattern = '') {
        if (empty($pattern)) {
            return true;
        }

        if (preg_match($pattern, $variable)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Method  is_null
     * 空验证方法
     *
     * @author yangyang3
     * @static
     *
     * @param string $variable
     *
     * @return bool
     */
    public static function is_null($variable = '') {
        $variable = trim($variable);

        if (empty($variable)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Method  is_not_null
     * 非空验证方法
     *
     * @author yangyang3
     * @static
     *
     * @param string $variable
     *
     * @return bool
     */
    public static function is_not_null($variable = '') {
        $variable = trim($variable);

        if (!empty($variable)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Method  is_email
     * EMAIL验证方法
     *
     * @author yangyang3
     * @static
     *
     * @param string $variable
     *
     * @return bool
     */
    public static function is_email($variable = '') {
        $pattern = '/^[a-z0-9]+[_\-\.]?[a-z0-9]+@(?:[a-z0-9]+\-?[a-z0-9]+\.)*(?:[a-z0-9]+(?:\-?[a-z0-9])*\.[a-z]{2,})$/is';

        if (preg_match($pattern, trim($variable))) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Method  is_url
     * URL验证方法
     *
     * @author yangyang3
     * @static
     *
     * @param string $variable
     *
     * @return bool
     */
    public static function is_url($variable = '') {
        $pattern = '/^(?:https?):\/\/(?:[a-z0-9]+\-?[a-z0-9]+\.)*([a-z0-9]+(?:\-?[a-z0-9])*\.[a-z]{2,})(?:\/?.*)$/is';

        if (preg_match($pattern, trim($variable))) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Method  is_sina_video
     * 新浪视频验证方法
     *
     * @author suchong
     * @static
     *
     * @param string $variable
     *
     * @return bool
     */
    public static function is_sina_video($variable = '') {
        $pattern = '@^http://video.sina.com.cn/@';

        if (preg_match($pattern, trim($variable))) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Method  is_numeric
     * 数字验证方法
     *
     * @author yangyang3
     * @static
     *
     * @param int|string $variable
     *
     * @return bool
     */
    public static function is_numeric($variable = '') {
        if (is_numeric(trim($variable))) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Method  is_equals_for_number
     * 数字相等验证方法
     *
     * @author yangyang3
     * @static
     *
     * @param int $variable1
     * @param int $variable2
     *
     * @return bool
     */
    public static function is_equals_for_number($variable1 = 0, $variable2 = 0) {
        return abs($variable1 - $variable2) < 0.0000000001;
    }

    /**
     * Method  is_equals
     * 相等验证方法
     *
     * @author yangyang3
     * @static
     *
     * @param string $variable1
     * @param string $variable2
     *
     * @return bool
     */
    public static function is_equals($variable1 = '', $variable2 = '') {
        if ((string)$variable1 === (string)$variable2) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Method  is_not_equals
     * 不相等验证方法
     *
     * @author yangyang3
     * @static
     *
     * @param string $variable1
     * @param string $variable2
     *
     * @return bool
     */
    public static function is_not_equals($variable1 = '', $variable2 = '') {
        if ((string)$variable1 !== (string)$variable2) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Method  is_match_length
     * 长度验证方法
     *
     * @author yangyang3
     * @static
     *
     * @param string $variable
     * @param int    $length
     *
     * @return bool
     */
    public static function is_match_length($variable = '', $length = 0) {
        if (strlen($variable) === (int)$length) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Method  is_in_string
     * IN验证方法
     *
     * @author yangyang3
     * @static
     *
     * @param string $variable
     * @param string $string
     * @param string $delimiter
     *
     * @return bool
     */
    public static function is_in_string($variable = '', $string = '', $delimiter = ',') {
        if (strpos($string, $delimiter) === false) {
            return false;
        }

        $string_list = explode($delimiter, $string);

        if (empty($string_list)) {
            return false;
        }

        if (in_array($variable, $string_list)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Method  is_in_range
     * 范围验证方法
     *
     * @author yangyang3
     * @static
     *
     * @param int    $variable
     * @param string $range
     * @param string $delimiter
     *
     * @return bool
     */
    public static function is_in_range($variable = 0, $range = '', $delimiter = '-') {
        if (strpos($range, $delimiter) === false) {
            return false;
        }

        $range_list = explode($delimiter, $range);

        if (count($range_list) !== 2) {
            return false;
        }

        $variable = trim($variable);

        if ($variable > $range_list[0] && $variable < $range_list[1]) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Method  is_date
     * 日期验证方法
     *
     * @author yangyang3
     * @static
     *
     * @param string $variable
     * @param string $date_delimiter
     *
     * @return bool
     */
    public static function is_date($variable = '', $date_delimiter = '-') {
        $timestamp = strtotime($variable);

        $date = date("Y{$date_delimiter}m{$date_delimiter}d", $timestamp);

        if ($variable === $date) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Method  is_datetime
     * 时间验证方法
     *
     * @author yangyang3
     * @static
     *
     * @param string $variable
     * @param string $date_delimiter
     * @param string $time_delimiter
     *
     * @return bool
     */
    public static function is_datetime($variable = '', $date_delimiter = '-', $time_delimiter = ':') {
        $timestamp = strtotime($variable);

        $datetime = date("Y{$date_delimiter}m{$date_delimiter}d H{$time_delimiter}i{$time_delimiter}s", $timestamp);

        if ($variable === $datetime) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Method  is_lt_today
     * 等于今天验证方法
     *
     * @author yangyang3
     * @static
     *
     * @param string $variable
     *
     * @return bool
     */
    public static function is_eq_today($variable) {
        $variable_date = date('Ymd', strtotime($variable));

        $today_date = date('Ymd', Yaf_Registry::get('request_time'));

        if ((int)$variable_date === (int)$today_date) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Method  is_lt_today
     * 小于今天验证方法
     *
     * @author yangyang3
     * @static
     *
     * @param string $variable
     *
     * @return bool
     */
    public static function is_lt_today($variable) {
        $variable_date = date('Ymd', strtotime($variable));

        $today_date = date('Ymd', Yaf_Registry::get('request_time'));

        if ((int)$variable_date < (int)$today_date) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Method  is_gt_today
     * 大于今天验证方法
     *
     * @author yangyang3
     * @static
     *
     * @param string $variable
     *
     * @return bool
     */
    public static function is_gt_today($variable) {
        $variable_date = date('Ymd', strtotime($variable));

        $today_date = date('Ymd', Yaf_Registry::get('request_time'));

        if ((int)$variable_date > (int)$today_date) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Method  is_le_today
     * 小于等于今天验证方法
     *
     * @author yangyang3
     * @static
     *
     * @param string $variable
     *
     * @return bool
     */
    public static function is_le_today($variable) {
        $variable_date = date('Ymd', strtotime($variable));

        $today_date = date('Ymd', Yaf_Registry::get('request_time'));

        if ((int)$variable_date <= (int)$today_date) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Method  is_ge_today
     * 大于等于今天验证方法
     *
     * @author yangyang3
     * @static
     *
     * @param string $variable
     *
     * @return bool
     */
    public static function is_ge_today($variable) {
        $variable_date = date('Ymd', strtotime($variable));

        $today_date = date('Ymd', Yaf_Registry::get('request_time'));

        if ((int)$variable_date >= (int)$today_date) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Method  is_eq_date
     * 日期相等验证方法
     *
     * @author yangyang3
     * @static
     *
     * @param string $variable1
     * @param string $variable2
     *
     * @return bool
     */
    public static function is_eq_date($variable1, $variable2) {
        $variable_date1 = date('Ymd', strtotime($variable1));

        $variable_date2 = date('Ymd', strtotime($variable2));

        if ((int)$variable_date1 === (int)$variable_date2) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Method  is_lt_date
     * 小于指定日期验证方法
     *
     * @author yangyang3
     * @static
     *
     * @param string $variable1
     * @param string $variable2
     *
     * @return bool
     */
    public static function is_lt_date($variable1, $variable2) {
        $variable_date1 = date('Ymd', strtotime($variable1));

        $variable_date2 = date('Ymd', strtotime($variable2));

        if ((int)$variable_date1 < (int)$variable_date2) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Method  is_gt_date
     * 大于指定日期验证方法
     *
     * @author yangyang3
     * @static
     *
     * @param string $variable1
     * @param string $variable2
     *
     * @return bool
     */
    public static function is_gt_date($variable1, $variable2) {
        $variable_date1 = date('Ymd', strtotime($variable1));

        $variable_date2 = date('Ymd', strtotime($variable2));

        if ((int)$variable_date1 > (int)$variable_date2) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Method  is_le_date
     * 小于等于指定日期验证方法
     *
     * @author yangyang3
     * @static
     *
     * @param string $variable1
     * @param string $variable2
     *
     * @return bool
     */
    public static function is_le_date($variable1, $variable2) {
        $variable_date1 = date('Ymd', strtotime($variable1));

        $variable_date2 = date('Ymd', strtotime($variable2));

        if ((int)$variable_date1 <= (int)$variable_date2) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Method  is_ge_date
     * 大于等于指定日期验证方法
     *
     * @author yangyang3
     * @static
     *
     * @param string $variable1
     * @param string $variable2
     *
     * @return bool
     */
    public static function is_ge_date($variable1, $variable2) {
        $variable_date1 = date('Ymd', strtotime($variable1));

        $variable_date2 = date('Ymd', strtotime($variable2));

        if ((int)$variable_date1 >= (int)$variable_date2) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Method  is_lt_time
     * 小于指定时间验证方法
     *
     * @author yangyang3
     * @static
     *
     * @param string $variable1
     * @param string $variable2
     *
     * @return bool
     */
    public static function is_lt_time($variable1, $variable2) {
        $variable_time1 = strtotime($variable1);

        $variable_time2 = strtotime($variable2);

        if ((int)$variable_time1 < (int)$variable_time2) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Method  is_gt_time
     * 大于指定时间验证方法
     *
     * @author yangyang3
     * @static
     *
     * @param string $variable1
     * @param string $variable2
     *
     * @return bool
     */
    public static function is_gt_time($variable1, $variable2) {
        $variable_time1 = strtotime($variable1);

        $variable_time2 = strtotime($variable2);

        if ((int)$variable_time1 > (int)$variable_time2) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Method  is_le_time
     * 小于等于指定时间验证方法
     *
     * @author yangyang3
     * @static
     *
     * @param string $variable1
     * @param string $variable2
     *
     * @return bool
     */
    public static function is_le_time($variable1, $variable2) {
        $variable_time1 = strtotime($variable1);

        $variable_time2 = strtotime($variable2);

        if ((int)$variable_time1 <= (int)$variable_time2) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Method  is_ge_time
     * 大于等于指定时间验证方法
     *
     * @author yangyang3
     * @static
     *
     * @param string $variable1
     * @param string $variable2
     *
     * @return bool
     */
    public static function is_ge_time($variable1, $variable2) {
        $variable_time1 = strtotime($variable1);

        $variable_time2 = strtotime($variable2);

        if ((int)$variable_time1 >= (int)$variable_time2) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Method  is_lt_time_now
     * 小于当前时间验证方法
     *
     * @author yangyang3
     * @static
     *
     * @param string $variable
     *
     * @return bool
     */
    public static function is_lt_time_now($variable) {
        return strtotime($variable) < Yaf_Registry::get('request_time');
    }

    /**
     * Method  is_gt_time_now
     * 大于当前时间验证方法
     *
     * @author yangyang3
     * @static
     *
     * @param string $variable
     *
     * @return bool
     */
    public static function is_gt_time_now($variable) {
        return strtotime($variable) > Yaf_Registry::get('request_time');
    }

    /**
     * Method  is_le_time_now
     * 小于等于当前时间验证方法
     *
     * @author yangyang3
     * @static
     *
     * @param string $variable
     *
     * @return bool
     */
    public static function is_le_time_now($variable) {
        return strtotime($variable) <= Yaf_Registry::get('request_time');
    }

    /**
     * Method  is_ge_time_now
     * 大于等于当前时间验证方法
     *
     * @author yangyang3
     * @static
     *
     * @param string $variable
     *
     * @return bool
     */
    public static function is_ge_time_now($variable) {
        return strtotime($variable) >= Yaf_Registry::get('request_time');
    }

    /**
     * Method  callback
     * 回调验证方法
     *
     * @author yangyang3
     * @static
     *
     * @param string $variable
     * @param string $function_name
     *
     * @return bool
     */
    public static function callback($variable = '', $function_name = '') {
        if (!function_exists($function_name)) {
            return false;
        }

        if ($function_name($variable)) {
            return true;
        } else {
            return false;
        }
    }

}