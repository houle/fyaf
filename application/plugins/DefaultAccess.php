<?php

/**
 * Class     DefaultAccessPlugin
 * 
 *
 * @author   hunhun
 */
class DefaultAccessPlugin extends Yaf_Plugin_Abstract {

    public function routerStartup(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
    }

    public function routerShutdown(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
         /* 获取base_uri */
        $base_uri = $request->getBaseUri();

        /* 获取request_uri */
        $request_uri = $request->getRequestUri();
        $modules = Yaf_Registry::get('config')->application->modules;
        $default_module = strtolower(Yaf_Registry::get('config')->application->dispatcher->defaultModule);
        //$default_action = Yaf_Registry::get('config')->application->dispatcher->defaultAction;
        //$default_controller = Yaf_Registry::get('config')->application->dispatcher->defaultController;
        $modules_array = explode(",",strtolower($modules));
        $now_controller = strtolower($request->getControllerName());
        $now_action = strtolower($request->getActionName());
        
        if(in_array($now_controller, $modules_array) && $now_controller != $default_module){
             $request->setModuleName(ucfirst($now_controller));
             $request->setControllerName(ucfirst($now_action));
             $request->setActionName("index");
        } 
        /** 存入 */
        Yaf_Registry::set('__MODULE__', $request->getModuleName());
        Yaf_Registry::set('__CONTROLLER__', $request->getControllerName());
        Yaf_Registry::set('__ACTION__', $request->getActionName());
       // $_SERVER['REQUEST_URI'] = '/'.$request->getModuleName().'/'.$request->getControllerName().'/'.$request->getActionName();


    }

    public function dispatchLoopStartup(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
        
    }

    public function preDispatch(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {

    }

    public function postDispatch(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
    }

    public function dispatchLoopShutdown(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
    }

}