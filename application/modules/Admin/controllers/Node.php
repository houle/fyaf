<?php
class NodeController extends Base_Controllers {

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
        $node = new NodeModel();

        $count = $node->count();
        //var_dump($count);die;
        $content = "";
        if($count){
            $content = $node->getSomeMsg();
            $cate = new Local_Category();
            $content = $cate::unlimitedForLevel($content,$html ='--',0,0);
        }
         $this->_view->content = $content;
 
    }
     
     /**
     * 添加视图
     */
    public function addAction() {
        if($id = $this->getRequest()->getParam('id'))
        {
            $this->_view->id = $id;
        }

        $this->view;
    }
    /**
     *添加处理
     */
    public function addhandleAction(){
        

        if ($this->getRequest()->isPost()){
               //dump($_POST);die;
            $bind = array(
                'name'=>htmlspecialchars($this->getRequest()->getPost('name')),
                'title'=>htmlspecialchars($this->getRequest()->getPost('title')),
                'status'=>htmlspecialchars($this->getRequest()->getPost('status')),
                'remark'=>htmlspecialchars($this->getRequest()->getPost('remark')),
                'sort'=>htmlspecialchars($this->getRequest()->getPost('sort')),
                'pid'=>htmlspecialchars($this->getRequest()->getPost('pid')),
                'level'=>htmlspecialchars($this->getRequest()->getPost('level')),
                
            );
            $Node = new NodeModel();
            $result = $Node->add($bind);
            if ($result){
                $this->redirect("/admin/Node/index");

            }else{
                $this->redirect("/admin/Node/add/msg/add failed");
            }
        }
    }

     /**
     * 更新视图
     */
    public function editAction(){
        
        $id = $this->getRequest()->getParam('id');
        $Node = new NodeModel();
        if($content = $Node->getMsgByid($id))
        {
               //var_dump($content);die;
            $this->_view->content = $content;
        }else{
            $this->redirect("/admin/Node/index/msg/edit failed");
        }
    }

     /**
     *  更新处理
     */
    public function edithandleAction(){
        
        $id = $this->getRequest()->getParam('id');
        $bind = array(
               'name'=>htmlspecialchars($this->getRequest()->getPost('name')),
                'title'=>htmlspecialchars($this->getRequest()->getPost('title')),
                'status'=>htmlspecialchars($this->getRequest()->getPost('status')),
                'remark'=>htmlspecialchars($this->getRequest()->getPost('remark')),
                'sort'=>htmlspecialchars($this->getRequest()->getPost('sort')),
                'pid'=>htmlspecialchars($this->getRequest()->getPost('pid')),
                'level'=>htmlspecialchars($this->getRequest()->getPost('level')),
         );
        $Node = new NodeModel();
        if($Node->edit($bind,$id))
        {
               $this->redirect("/admin/Node/index");

        }else{
            $this->redirect("/admin/Node/index/msg/edit failed");
        }
    }


     /**
     *删除处理
     */
    public function delAction(){
        
        $id = $this->getRequest()->getParam('id');
        $Node = new NodeModel();
        if($Node->delByid($id))
        {
            $this->redirect("/admin/Node/index");

        }else{
            $this->redirect("/admin/Node/index/msg/del failed");
        }
    }
    


}

?>
