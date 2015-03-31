<?php

/**
 * Class     Curl
 * CURL类
 *
 * @author   yangyang3
 */
class Curl {

    /**
     * Variable  _user_agent
     *
     * @author   yangyang3
     * @static
     * @var      string
     */
    private static $_user_agent = 'Weibo Ad Pangu Curl/1.0';

    /**
     * Variable  _connect_timeout
     *
     * @author   yangyang3
     * @static
     * @var      int
     */
    private static $_connect_timeout = 3;

    /**
     * Variable  _timeout
     *
     * @author   yangyang3
     * @static
     * @var      int
     */
    private static $_timeout = 5;

    /**
     * Variable  _http_code
     *
     * @author   yangyang3
     * @static
     * @var
     */
    private static $_http_code;

    /**
     * Variable  _http_info
     *
     * @author   yangyang3
     * @static
     * @var
     */
    private static $_http_info;

    /**
     * Variable  _error_code
     *
     * @author   yangyang3
     * @static
     * @var
     */
    private static $_error_code;

    /**
     * Variable  _error_info
     *
     * @author   yangyang3
     * @static
     * @var
     */
    private static $_error_info;

    /**
     * Variable  _request_url
     *
     * @author   yangyang3
     * @static
     * @var
     */
    private static $_request_url;

    /**
     * Variable  _request_data
     *
     * @author   yangyang3
     * @static
     * @var      null
     */
    private static $_request_data = null;

    /**
     * Method  get
     * 发送get请求
     *
     * @author yangyang3
     * @static
     *
     * @param      $url
     * @param null $data
     * @param null $header
     * @param null $userpwd
     *
     * @return string
     */
    public static function get($url, $data = null, $header = null, $userpwd = null) {
        return self::_sendHttpRequest('GET', $url, $data, $header, $userpwd);
    }

    /**
     * Method  post
     * 发送post请求
     *
     * @author yangyang3
     * @static
     *
     * @param      $url
     * @param null $data
     * @param null $header
     * @param null $userpwd
     *
     * @return string
     */
    public static function post($url, $data = null, $header = null, $userpwd = null) {
        return self::_sendHttpRequest('POST', $url, $data, $header, $userpwd);
    }

    /**
     * Method  _sendHttpRequest
     * 发送http请求
     *
     * @author yangyang3
     * @static
     *
     * @param       $method
     * @param       $url
     * @param null  $data
     * @param array $header
     * @param null  $userpwd
     *
     * @return mixed
     */
    private static function _sendHttpRequest($method, $url, $data = null, $header = array(), $userpwd = null) {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        curl_setopt($curl, CURLOPT_USERAGENT, self::$_user_agent);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, self::$_connect_timeout);
        curl_setopt($curl, CURLOPT_TIMEOUT, self::$_timeout);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_ENCODING, '');
        curl_setopt($curl, CURLOPT_HEADER, false);

        $method = strtoupper($method);
        if ('GET' === $method) {
            if ($data !== null) {
                if (strpos($url, '?')) {
                    $url .= '&';
                } else {
                    $url .= '?';
                }
                $url .= http_build_query($data);
            }
        } elseif ('POST' === $method) {
            curl_setopt($curl, CURLOPT_POST, true);
            if (!empty($data)) {
                if (is_string($data)) {
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                } else {
                    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
                }
            }
        }

        if (null !== $userpwd) {
            curl_setopt($curl, CURLOPT_USERPWD, $userpwd);
        }

        if (null !== $header) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        }

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLINFO_HEADER_OUT, true);

        $response = curl_exec($curl);

        self::$_http_code    = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        self::$_http_info    = curl_getinfo($curl);
        self::$_error_code   = curl_errno($curl);
        self::$_error_info   = curl_error($curl);
        self::$_request_url  = $url;
        self::$_request_data = $data;

        curl_close($curl);

        return $response;
    }

    /**
     * Method  getHttpCode
     * 获取http状态码
     *
     * @author yangyang3
     * @static
     * @return int
     */
    public static function getHttpCode() {
        return self::$_http_code;
    }

    /**
     * Method  getHttpInfo
     * 获取http信息
     *
     * @author yangyang3
     * @static
     * @return string
     */
    public static function getHttpInfo() {
        return self::$_http_info;
    }

    /**
     * Method  getErrorCode
     * 获取错误码
     *
     * @author yangyang3
     * @static
     * @return int
     */
    public static function getErrorCode() {
        return self::$_error_code;
    }

    /**
     * Method  getErrorInfo
     * 获取错误信息
     *
     * @author yangyang3
     * @static
     * @return string
     */
    public static function getErrorInfo() {
        return self::$_error_info;
    }

    /**
     * Method  getRequestUrl
     * 获取请求URL
     *
     * @author yangyang3
     * @static
     * @return string
     */
    public static function getRequestUrl() {
        return self::$_request_url;
    }

    /**
     * Method  getRequestData
     * 获取请求数据
     *
     * @author yangyang3
     * @static
     * @return null
     */
    public static function getRequestData() {
        return self::$_request_data;
    }

}