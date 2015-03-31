<?php
/**
 * @author hunhun F18uotwjv
 *
 */
class UserModel extends Base_Models {
    protected $_name = 'user';

        /**
     * Method  __construct
     * 构造方法
     *
     * @author luoliang1
     *
     * @param string $module_name
     * @param string $table_name
     */
    public function __construct($module_name = null, $table_name = null) {
        if (null === $module_name) {
            $module_name = Yaf_Registry::get('module_name');
        }
        if (null === $table_name) {
            $table_name = $this->_name;
        }

        parent::__construct($module_name, $table_name);
    }

    public function getSomeMsg(){
       $sql="select * from ".$this->_name;
       
       $content = $this->fetchAll($sql);

       return $content;
    }

    public function getPageMsg($pagenum,$page_row){
        

       $sql="select {$this->_name}.id, {$this->_name}.name,{$this->_name}.register_time,
            role.name as role
           from ".$this->_name.
           " left join role_user 
           on {$this->_name}.id=role_user.user_id
             left join role
           on role_user.role_id=role.id
            order by {$this->_name}.id desc 
           limit ".$pagenum.",".$page_row;


       $content = $this->fetchAll($sql);
       //dump($content);die;
       return $content;
    }

    public function count(){
        
       return $this->getCount();
    }

    /**
     * 增加一条留言
     * @param array $data
     */
    public function add($data){
        $result = $this->insert($data);
        return $result;
    }

    /**
     * 删除
     */
    public function delByid($id){

        
        if ($this->delete("`id` = '$id'")&&$this->delete("`user_id` = '$id'",'role_user')){
           return true;
        }else{
           return false;
        }
    }
    /**
     * 根据id获得一行数据
     * @param var $id
     */
    public function getMsgByid($id){
        $sql="select * from ".$this->_name." where id = '$id'";
        $result = $this->fetchRow($sql);
        return $result;
    }

    /**
     * 根据name获得一行数据
     * @param var $name
     */
    public function getMsgByVar($arr = array(),$type = "and"){
        $where = "";
        foreach ($arr as $k => $v) {
           $where .= "$k = '$v' ".$type." ";
        }
        $where = substr($where, 0,strlen($where)-4);
        $sql="select * from ".$this->_name." where ".$where;
        $result = $this->fetchRow($sql);
        return $result;
    }
    /**
     * 编辑一条留言
     * @param array $data
     * @param var $id
     */
    public function edit($data,$id){
        $result = $this->update($data,"id = '$id'");
        return $result;
    }


    public function insertRoleUser($arr){
       $this->delete("`user_id` = ".$arr['user_id'],'role_user');
       return $this->insert($arr,"role_user");
    }
}