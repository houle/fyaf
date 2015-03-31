<?php
/**
 * Class     Local_Page
 * bootstrap 3.0 + yaf + DefaultAccessPlugin
 *
 * @author   hunhun
 */

class Local_Page{
    private $total;        //总条目
    private $pageRow;     //每页显示条数
    private $uri;       //当前url
    private $page;   //当前页
    private $pageNum;  //总页数
    private $listNum=6;  //列表数字个数
    private $config = array(
     "header" => "记录",  
     "pre" => "<",  
     "next" => ">",  
     "first" => "F",  
     "last" => "L",  
     "pre_" => "<<",  
     "next_" => ">>", 
     );
    
    function __construct($total,$pageRow=10){
      
      $this->total = $total;
      $this->pageRow = $pageRow;
      $this->uri = $this->getUri();
      $this->pageNum=ceil($this->total/$this->pageRow);
      $current_page=!empty($this->page)?$this->page:1;
      if($current_page>$this->pageNum){
        $this->page=$this->pageNum;
      }else if($current_page<1){
        $this->page=1;
      }else{
        $this->page=$current_page;
      }
      //var_dump($this);
    }
    //select * from xxx order by xxx.xxx limit $this->begin,$this->pageRow;
    public function getBegin(){
      return ($this->page-1)*$this->pageRow;
    }
    private function getUri(){
     //var_dump($_SERVER)

     if(isset($_POST['p']))
     {
      $url = $_SERVER['PHP_SELF'];
    }else
    {
      // echo "<pre>";
      // var_dump($_SERVER);
      // echo "</pre>";
     
      $str = $_SERVER['REQUEST_URI'];
      $req_uri = explode("/", $str);
      $req_uri[1] =  Yaf_Registry::get("__MODULE__");
      $req_uri[2] =  Yaf_Registry::get("__CONTROLLER__");
      $req_uri[3] =  Yaf_Registry::get("__ACTION__");
      $_SERVER['REQUEST_URI'] = "";
      foreach ($req_uri as $k => $v) {
        if($v){
          $_SERVER['REQUEST_URI'].='/'.$v;
        }
        
      }
      $tmp = "";
      if($tmp = strpos($str,'/p/')){
        $_SERVER['REQUEST_URI'] = substr($str, 0,$tmp);
        $this->page = substr($str, $tmp+3,1);
      }


      $url = $_SERVER['REQUEST_URI'];
    }
      //print_r($parse);
      //echo $url;
      //echo  $_SERVER['QUERY_STRING'];
    return $url;
    
  }
  public function __get($str){
   
    if($str == 'limit'){
     
      return $this->limit;
    }
    return null;
    
  }
  private function start(){
    
    if($this->total==0)
      return 0;
    else
      return ($this->page-1)*$this->pageRow+1;
    
  }
  
  private function end(){
    return min($this->page*$this->pageRow,$this->total);
    
  }
  
  private function first(){
    $html="";
    if($this->page<=1)
      $html.='';
    else 
      $html.="<li><a href='{$this->uri}/p/1'>{$this->config['first']}</a></li>";
    return $html;
    
  }
  private function pre(){
    $html="";
    if($this->page<=1)
      $html.='';
    else 
      $html.="<li><a href='{$this->uri}/p/".($this->page-1)."'>{$this->config['pre']}</a></li>";
    return $html;
    
  }
  private function next(){
    $html="";
    if($this->page>=$this->pageNum)
      $html.='';
    else 
     $html.="<li><a href='{$this->uri}/p/".($this->page+1)."'>{$this->config['next']}</a></li>";
   return $html;
   
 }
 private function pre_(){
  $html="";
  if($this->page<=1)
    $html.='';
  else 
    $html.="<li><a href='{$this->uri}/p/".(($this->page-$this->listNum)<=1?1:($this->page-$this->listNum))."'>{$this->config['pre_']}</a></li>";
  return $html;
  
}
private function next_(){
  $html="";
  if($this->page>=$this->pageNum)
    $html.='';
  else 
   $html.="<li><a href='{$this->uri}/p/".(($this->page+$this->listNum)>$this->pageNum?$this->pageNum:($this->page+$this->listNum))."'>{$this->config['next_']}</a></li>";
 return $html;
 
}
private function last(){
  $html="";
  if($this->page>=$this->pageNum)
    $html.='';
  else 
    $html.="<li><a href='{$this->uri}/p/{$this->pageNum}'>{$this->config['last']}</a></li>";
  return $html;
  
}
private function pageList(){
  
  
  $link = "";
  $pre = floor($this->listNum/2);
  for($i=$pre;$i>=1;$i--){
    $page = $this->page-$i;
    if($page<1)
      continue;
    $link.="<li><a href='{$this->uri}/p/{$page}'>{$page}</a></li>";
  }
  $link.="<li class='active'><a  href='javascript:void(0)'>{$this->page}<span class='sr-only'>(current)</span></a></li>";
  for($i=1;$i<$pre;$i++){
    $page = $this->page+$i;
    if($page<=$this->pageNum)
      $link.="<li><a href='{$this->uri}/p/{$page}'>{$page}</a></li>";
    else
      break;
  }
  return $link;
  
}
private function goUrl(){
  $html="";
  $html.= '跳转到<input type="text" onkeydown="javascript:if(event.keyCode==13){var page=(this.value>';
    $html.=$this->pageNum.')?'.$this->pageNum.':(this.value>1?this.value:1);location=\''.$this->uri.'/p/\'+page+\'\'}" value="';
$html.=$this->page.'" size="4"><input type="button" onclick="javascript:var p=(this.previousSibling.value>';
  $html.=$this->pageNum.')?'.$this->pageNum.':(this.previousSibling.value>1?this.previousSibling.value:1);location=\''.$this->uri.'/p/\'+p+\'\'" value="GO">';
          //echo $html;die;

return $html;
}

public function show($arr=array(0,1,2,3,4,5,6,7,8,9,10)){
  $html=array();
  $html[]="共有<b>{$this->total}</b>{$this->config['header']}";
  
  $html[]="本页显示<b>".($this->end()-$this->start()+1)."</b>条，为<b>{$this->start()}</b>-<b>{$this->end()}</b>条";
  $html[]="当前为<b>{$this->page}</b>/<b>{$this->pageNum}</b>页";
  $html[]=$this->first();
  $html[]=$this->pre_();
  $html[]=$this->pre();
  $html[]=$this->pageList();
  $html[]=$this->next();
  $html[]=$this->next_();
  $html[]=$this->last();
  $html[]=$this->goUrl();
  $fenye="";
  foreach($arr as $k){
   $fenye.=$html[$k];
 }
 return $fenye;
 
}




}

?>