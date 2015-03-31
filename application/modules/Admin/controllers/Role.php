<?php
class RoleController extends Base_Controllers {

    public function init(){
       //permission controll  
        $this->session = Yaf_Session::getInstance();
        $rabc = new Local_Rbac();
        if($this->session->name != "admin"){
            if(!$rabc->hasPermission($this->session->user_id)){
                 echo "permission deny!";exit;
                 
                }
        }
    }
    /**
     * 留言主页面
     */
    public function indexAction() {
        $role = new RoleModel();

        $count = $role->count();
        //var_dump($count);die;
        $content = "";
        if($count){
            $page_row = 5; //each page rows
            $local_page = new Local_Page ($count,$page_row);
            $begin = $local_page->getBegin();
            $content = $role->getPageMsg($begin,$page_row);    
           
            //dump($content);
            $this->_view->page = $local_page->show(array(4,5,6,7,8));
        }
         $this->_view->content = $content;
 
    }
     
        /**
     *  add view
     */
    public function addAction() {
        
    }
    /**
     * add handler
     */
    public function addhandleAction(){
        

        if ($this->getRequest()->isPost()){
               //dump($_POST);die;
            $bind = array(
                'name'=>htmlspecialchars($this->getRequest()->getPost('name')),
                'remark'=>htmlspecialchars($this->getRequest()->getPost('remark')),
                'pid' => htmlspecialchars($this->getRequest()->getPost('pid')),
                'status' => htmlspecialchars($this->getRequest()->getPost('status')),

            );
            $Role = new RoleModel();
            $result = $Role->add($bind);
            if ($result){
                $this->redirect("/admin/Role/index");

            }else{
                $this->redirect("/admin/Role/add/msg/add failed");
            }
        }
    }

     /**
     * edit view
     */
    public function editAction(){
        
        $id = $this->getRequest()->getParam('id');
        $Role = new RoleModel();
        if($content = $Role->getMsgByid($id))
        {
               //var_dump($content);die;
            $this->_view->content = $content;
        }else{
            $this->redirect("/admin/Role/index/msg/edit failed");
        }
    }

         /**
     * edit handler
     */
    public function edithandleAction(){
        
        $id = $this->getRequest()->getParam('id');
        $bind = array(
               'name'=>htmlspecialchars($this->getRequest()->getPost('name')),
                'remark'=>htmlspecialchars($this->getRequest()->getPost('remark')),
                'pid' => htmlspecialchars($this->getRequest()->getPost('pid')),
                'status' => htmlspecialchars($this->getRequest()->getPost('status')),
         );
        $Role = new RoleModel();
        if($Role->edit($bind,$id))
        {

               $this->redirect("/admin/Role/index");

        }else{
            $this->redirect("/admin/Role/index/msg/edit failed");
        }
    }


     /**
     * del handler
     */
    public function delAction(){
        
        $id = $this->getRequest()->getParam('id');
        $Role = new RoleModel();
        if($Role->delByid($id))
        {
            $this->redirect("/admin/Role/index");

        }else{
            $this->redirect("/admin/Role/index/msg/del failed");
        }
    }

     /**
     * access handler
     */
    public function accessAction(){
        
        $this->_view->id = $this->getRequest()->getParam('id');
        $this->_view->name = $this->getRequest()->getParam('name');
        $node = new NodeModel();
        if($content = $node->getSomeMsg())
        {
            $cate = new Local_Category();
            $content = $cate::unlimitedForLayer($content);
            $Role = new RoleModel();
            $this->_view->nodes = $Role->getRoleNode($this->getRequest()->getParam('id'));
            //dump($nodes);die;
            $this->_view->content = $content;

        }else{
            $this->redirect("/admin/Role/index/msg/del failed");
        }
    }

         /**
     * access handler
     */
    public function accesshandleAction(){
        $role_id = $this->getRequest()->getPost('id');
        $access = $this->getRequest()->getPost('access');
        $arr = array();
        $role = new RoleModel();
        $role->beginTransaction();
        if(!empty($access)){
           $role->delete("`role_id` = '$role_id'",'access');
           foreach ($access as $k => $v) {
            $arr[$k]['role_id'] = $role_id;
            $arr[$k]['node_id']=$v;
            $role->add($arr[$k],'access');
         } 
        }
       
       
       if($role->commit()){
          $this->redirect("/admin/Role/index");
       }else{
          $role->rollBack();
          $this->redirect("/admin/Role/index/msg/insert failed");
       }

    }



}

?>