<?php
class MsgController extends Base_Controllers {

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
        $msg = new MsgModel();

        $count = $msg->count();
        //var_dump($count);die;
        $content = "";
        if($count){
            $page_row = 5; //each page rows
            $local_page = new Local_Page ($count,$page_row);
            $begin = $local_page->getBegin();
            $content = $msg->getPageMsg($begin,$page_row);    
           
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
        	   //var_dump($_POST);die;
            $bind = array(
                'msg_name'=>htmlspecialchars($this->getRequest()->getPost('name')),
                'msg_content'=>htmlspecialchars($this->getRequest()->getPost('content')),
                'submit_time' => time()
            );
            $msg = new MsgModel();
            $result = $msg->add($bind);
            if ($result){
                $this->redirect("/admin/index/index");

            }else{
                $this->redirect("/admin/index/add/msg/'add failed'");
            }
        }
    }

     /**
     * edit view
     */
    public function editAction(){
        
        $id = $this->getRequest()->getParam('id');
        $msg = new MsgModel();
        if($content = $msg->getMsgByid($id))
        {
        	   //var_dump($content);die;
            $this->_view->content = $content;
        }else{
            $this->redirect("/admin/index/index/msg/edit failed");
        }
    }

         /**
     * edit handler
     */
    public function edithandleAction(){
        
        $id = $this->getRequest()->getParam('id');
        $bind = array(
                'msg_name'=>htmlspecialchars($this->getRequest()->getPost('name')),
                'msg_content'=>htmlspecialchars($this->getRequest()->getPost('content')),
                'submit_time' => time()
         );
        $msg = new MsgModel();
        if($msg->edit($bind,$id))
        {
        	   $this->redirect("/admin/index/index");

        }else{
            $this->redirect("/admin/index/index/msg/edit failed");
        }
    }


     /**
     * del handler
     */
    public function delAction(){
        
        $id = $this->getRequest()->getParam('id');
        $msg = new MsgModel();
        if($msg->delByid($id))
        {
            $this->redirect("/admin/index/index");

        }else{
            $this->redirect("/admin/index/index/msg/del failed");
        }
    }



}

?>