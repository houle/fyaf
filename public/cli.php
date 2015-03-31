<?php
/* example: php cli.php "request_uri=/command/campaign/index" */

define('ROOT_PATH', dirname(dirname(__FILE__)));

define('APPLICATION_PATH', ROOT_PATH . '/application');

$application = new Yaf_Application(ROOT_PATH . '/conf/application.ini');

$response = $application->bootstrap()->getDispatcher()->dispatch(new Yaf_Request_Simple());