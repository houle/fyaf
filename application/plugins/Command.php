<?php

/**
 * Class     CommandPlugin
 * 命令行插件
 *
 * @author   yangyang3
 */
class CommandPlugin extends Yaf_Plugin_Abstract {

    public function routerStartup(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
    }

    public function routerShutdown(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
        /* 验证是否为命令行方式 */
        if ($request->isCli()) {
            $action = $request->getActionName();

            $locate = strpos($action, '?');

            /* 验证action是否有传参 */
            if ($locate !== false) {
                $query_list = array();

                //重新设置action
                $request->setActionName(substr($action, 0, $locate));

                //截取query_string
                $query_string = substr($action, $locate + 1);

                //解析query_string
                parse_str($query_string, $query_list);

                //循环set到param
                foreach ($query_list as $key => $value) {
                    $request->setParam($key, $value);
                }
            }
        }

        $request->setRequestUri(strtolower($request->getModuleName() . '/' . $request->getControllerName() . '/' . $request->getActionName()));
        $request->setModuleName(ucfirst($request->getModuleName()));
        $request->setControllerName(underline_to_camel(ucfirst($request->getControllerName())));
        $request->setActionName(underline_to_camel($request->getActionName()));

        /* 保存请求地址 */
        Yaf_Registry::set('request_uri', $request->getRequestUri());
    }

    public function dispatchLoopStartup(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
        /* 导入对应Module的Service */
        if ('Command' !== $request->getModuleName()) {
            $module_name = $request->getModuleName();
        } else {
            $controller_name = camel_to_underline($request->getControllerName());

            $module_name = ucfirst(substr($controller_name, 0, strrpos($controller_name, '_')));
        }

        import_service_by_module_name($module_name);

        Yaf_Registry::set('module_name', $module_name);
    }

    public function preDispatch(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
    }

    public function postDispatch(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
    }

    public function dispatchLoopShutdown(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
    }

}