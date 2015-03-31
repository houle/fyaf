<?php
class IndexController extends Base_Controllers {


    public function init(){
        
    	$this->session = Yaf_Session::getInstance()->start();
    }
    public function indexAction() {
        if($this->session->get('user_id')&&$this->session->get('name'))
            $this->view;
        else
            $this->redirect("/Admin/login");
    }
     



}

?>