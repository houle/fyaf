<?php
class LoginController extends Base_Controllers {

    public function init(){
         $this->session = Yaf_Session::getInstance();
    }
    /**
     * 
     */
    public function indexAction(){

        if($this->session->get('user_id')&&$this->session->get('name'))
            $this->redirect("/Admin/index");
        else
            $this->view;
    }


    public function loginHAction(){
        
            $user = new UserModel('User');
            $arr  = array(
                  'name' =>  htmlspecialchars($this->getRequest()->getPost('name'))
              );
            $password = $this->getRequest()->getPost('password');
            $list = $user->getMsgByVar($arr);
            //dump($list);die;
            if($list){
             //echo strtolower($list[0]['password'])."".strtolower(md5(I('password')));die;
                if(strtolower($list['password'])==strtolower(md5($password))){
                     

                     $this->session->name = $list['name'];
                     $this->session->user_id = $list['id'];   //设置session
                    $this->redirect('/Admin/index');

                }else{
                    $this->redirect("/Admin/login");
                }
            }else{
                    $this->redirect("/Admin/login");
        }

    }

    public function logoutAction(){
          
              //session(null); // 清空当前的session
          if($this->session->del('user_id')&&$this->session->del('name')); 
           $this->redirect("/Admin/Login");
    }



}

?>