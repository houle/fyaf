<?php
  /*
  CREATE TABLE IF NOT EXISTS `access` (
    `role_id` smallint(6) unsigned NOT NULL,
    `node_id` smallint(6) unsigned NOT NULL,
    `level` tinyint(1) NOT NULL,
    `module` varchar(50) DEFAULT NULL,
    KEY `groupId` (`role_id`),
    KEY `nodeId` (`node_id`)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8;

  CREATE TABLE IF NOT EXISTS `node` (
    `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(20) NOT NULL,
    `title` varchar(50) DEFAULT NULL,
    `status` tinyint(1) DEFAULT '0',
    `remark` varchar(255) DEFAULT NULL,
    `sort` smallint(6) unsigned DEFAULT NULL,
    `pid` smallint(6) unsigned NOT NULL,
    `level` tinyint(1) unsigned NOT NULL,
    PRIMARY KEY (`id`),
    KEY `level` (`level`),
    KEY `pid` (`pid`),
    KEY `status` (`status`),
    KEY `name` (`name`)
  ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

  CREATE TABLE IF NOT EXISTS `role` (
    `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(20) NOT NULL,
    `pid` smallint(6) DEFAULT NULL,
    `status` tinyint(1) unsigned DEFAULT NULL,
    `remark` varchar(255) DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `pid` (`pid`),
    KEY `status` (`status`)
  ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

  CREATE TABLE IF NOT EXISTS `role_user` (
    `role_id` mediumint(9) unsigned DEFAULT NULL,
    `user_id` char(32) DEFAULT NULL,
    KEY `group_id` (`role_id`),
    KEY `user_id` (`user_id`)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
  */
class Local_Rbac{
  private $permissions = array();
  private $connect = null;

  function __construct(){
     $this->connect = new Base_Models();
  }
  
 private function getUserRole($user_id){
       if(!empty($user_id)){
            
          $sql = "SELECT t2.role_id FROM user as t1
                 JOIN role_user as t2 ON t1.id = t2.user_id   
                 WHERE t1.id = ".$user_id; 


          $content = $this->connect->fetchAll($sql);
          //dump($content);die;
          return $content;

       }


  } 
  private function getPermission($user_id){

       if($roleids = $this->getUserRole($user_id)){
            
          $sql = "SELECT t3.id,t3.name,t3.remark,t3.pid FROM role as t1
                 left JOIN access as t2 ON t1.id = t2.role_id   
                 left join node as t3 on t2.node_id = t3.id WHERE t1.id = ".$roleids[0]['role_id']; 


          $nodes = $this->connect->fetchAll($sql);
          $cate = new Local_Category();
          $nodes = $cate->unlimitedForLayer($nodes);
          foreach ($nodes as $k => $v) {
            if(!empty($v['child'])){
              foreach ($v['child'] as $key => $value) {
                   if(!empty($value['child'])){
                      foreach ($value['child'] as $kk => $vv) {
                        $this->permisssions[strtolower($v['name'])][strtolower($value['name'])][strtolower($vv['name'])]=true;
                      }
                    }
              }
            }
          }

       }


  }

  public function hasPermission($user_id){
       $module = strtolower(Yaf_Registry::get('__MODULE__'));
       $controller = strtolower(Yaf_Registry::get('__CONTROLLER__'));
       $action = strtolower(Yaf_Registry::get('__ACTION__'));
       $this->getPermission($user_id);
       //dump($this->permisssions);
       if(isset($this->permisssions[$module][$controller][$action])){
         return true;
       }

       return false;

  } 

}