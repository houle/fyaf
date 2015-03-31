<?php

/**shixi_yanqing@staff.weibo.com  1234.com
 * 所有在Bootstrap类中, 以_init开头的方法, 都会被Yaf调用,
 * 这些方法, 都接受一个参数:Yaf_Dispatcher $dispatcher
 * 调用的次序, 和申明的次序相同
 */
class Bootstrap extends Yaf_Bootstrap_Abstract{


         private $_config;

	/**
	 * 初始化配置项
	 *
	 */
         public function _initConfig() {
                
                $this->_config = Yaf_Application::app()->getConfig();
                Yaf_Registry::set("config", $this->_config);
         }

        
	    	/**
		 * Use Zend Database
		 *
		 */
        	public function _initIncludePath(){
		  set_include_path(get_include_path().PATH_SEPARATOR.$this->_config->application->library);
	    }

		public function _initLocalNamespace(Yaf_Dispatcher $dispatcher) {
	        $namespace = array(
	            'AdUC',
	            'Base',
	            'Type',
	            'Zend',
	            'Db',
	            'Local',
	        );
	        Yaf_Loader::getInstance()->registerLocalNamespace($namespace);
	    }


	    	/**
		 * 注册常量
		 *
		 */
		public function _initConstant()
		{
			// 项目URL
			define('SYSTEMURL', $this->_config->application->baseUri);
			define('ADMINURL', SYSTEMURL."/admin");

		}
		/**
		 * import functions/Common.php
		 */
		public function _initFunctions(Yaf_Dispatcher $dispatcher) {
	        Yaf_Loader::import($this->_config->application->functions . '/Common.php');
	    }

	    	/**
		 * 自定义路由
		 *
		 */
       /*public function _initRoute(Yaf_Dispatcher $dispatcher)
		{
			$router = $dispatcher::getInstance()->getRouter();
			$routes = new Yaf_Config_Ini(ROOT_PATH . '/conf/routes.ini', 'routes');
			$router->addConfig($routes->routes);
			unset($routes);
		}*/


		/**
		 * 
		 *
		 */
		public function _initSession(Yaf_Dispatcher $dispatcher) {
        
	       
	            Yaf_Session::getInstance()->start();
	         
         }
         public function _initPlugin(Yaf_Dispatcher $dispatcher) {
        //根据请求方式加载插件
	       
	            $defaulta_plugin = new DefaultAccessPlugin();
	            $dispatcher->registerPlugin($defaulta_plugin);
	         
         }


         public function _initDispatcher(Yaf_Dispatcher $dispatcher) {
        //default dispacher
	       
	            $dispatcher->setDefaultAction($this->_config->application->dispatcher->setDefaultAction) ;    //— 设置路由的默认动作
			   $dispatcher->setDefaultController($this->_config->application->defaultController) ; //— 设置路由的默认控制器
			   //$dispatcher->setDefaultModule($this->_config->application->defaultModule) ;   // 设置路由的默认模块
	         
         }



}
?>