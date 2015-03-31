<?php
class UserController extends Base_Controllers {

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
        $user = new UserModel();

        $count = $user->count();
        //var_dump($count);die;
        $content = "";
        if($count){
            $page_row = 5; //each page rows
            $local_page = new Local_Page ($count,$page_row);
            $begin = $local_page->getBegin();
            $content = $user->getPageMsg($begin,$page_row);    
           
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
                'password'=>md5(strtolower(htmlspecialchars($this->getRequest()->getPost('password')))),
                'register_time' => time()
            );
            $user = new UserModel();
            $result = $user->add($bind);
            if ($result){
                $this->redirect("/admin/user/index");

            }else{
                $this->redirect("/admin/user/add/msg/add failed");
            }
        }
    }

     /**
     * edit view
     */
    public function editAction(){
        
        $id = $this->getRequest()->getParam('id');
        $user = new UserModel();
        if($content = $user->getMsgByid($id))
        {
               //var_dump($content);die;
            $this->_view->content = $content;
        }else{
            $this->redirect("/admin/user/index/msg/edit failed");
        }
    }

         /**
     * edit handler
     */
    public function edithandleAction(){
        
        $id = $this->getRequest()->getParam('id');
        $bind = array(
                 'name'=>htmlspecialchars($this->getRequest()->getPost('name')),
                'password'=>md5(strtolower(htmlspecialchars($this->getRequest()->getPost('password')))),
         );
        $user = new UserModel();
        if($user->edit($bind,$id))
        {
               $this->redirect("/admin/user/index");

        }else{
            $this->redirect("/admin/user/index/msg/edit failed");
        }
    }


     /**
     * del handler
     */
    public function delAction(){
        
        $id = $this->getRequest()->getParam('id');
        $user = new UserModel();
        if($user->delByid($id))
        {
            $this->redirect("/admin/user/index");

        }else{
            $this->redirect("/admin/user/index/msg/del failed");
        }
    }

     /**
     * add user to role view
     */
    public function addroleAction(){
        
        $this->_view->id = $this->getRequest()->getParam('id');
        $this->_view->name = $this->getRequest()->getParam('name');
        $role = new RoleModel();
        if($content = $role->getSomeMsg())
        {
            //dump($content);
            $this->_view->content = $content;

        }else{
            $this->redirect("/admin/user/index/msg/del failed");
        }

    }

     /**
     * addrole handler
     */
    public function addroleHAction(){
        
       if ($this->getRequest()->isPost()){
               //dump($_POST);die;
            $bind = array(
                'user_id'=>htmlspecialchars($this->getRequest()->getPost('user_id')),
                'role_id'=>htmlspecialchars($this->getRequest()->getPost('role_id')),
                
            );
            $user = new UserModel();
            $result = $user->insertRoleUser($bind);
            if ($result){
                $this->redirect("/admin/user/index");

            }else{
                $this->redirect("/admin/user/add/msg/add failed");
            }
        }
    }


}

?>