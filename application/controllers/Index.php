<?php
class IndexController extends Base_Controllers {



    public function init(){

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
                $this->redirect("/");

            }else{
                $this->redirect("/index/index/add/msg/failed");
            }
        }else{
            $this->redirect("/");
        }
    }



}
