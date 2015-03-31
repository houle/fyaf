<?php

class Local_Category{
	//组合一维数组
	static public function unlimitedForLevel($cate,$html ='--',$pid=0,$level=0,$id_name='id',$pid_name='pid'){
   
    $arr=array();
    foreach ($cate as $v) {
     if($v[$pid_name]==$pid){
      $v['level']=$level+1;
      $v['html']=str_repeat($html,$level);
      $arr[]=$v;
      $arr=array_merge($arr,self::unlimitedForLevel($cate,$html,$v[$id_name],$level+1,$id_name,$pid_name));
    }
  }

  return $arr;
}
  //组合多维数组
static public function unlimitedForLayer($cate,$name='child',$pid=0,$id_name='id',$pid_name='pid'){
  $arr=array();
  foreach ($cate as $v) {
   if($v[$pid_name]==$pid){
    $v[$name]=self::unlimitedForLayer($cate,$name,$v[$id_name],$id_name,$pid_name);
    $arr[]=$v;
  }
}
return $arr;
}
  //传递一个子分类ID返回其父级分类
static public function getParents($cate,$id,$id_name='id',$pid_name='pid'){
  $arr=array();
  foreach ($cate as $v) {
   if($v[$id_name]==$id){
    $arr[]=$v;
    $arr=array_merge(self::getParents($cate,$v[$pid_name]),$arr,$id_name,$pid_name);
  }
}
return $arr;
}
  //传递一个父级分类ID返回所有子分类ID
static public function getChildsID($cate,$pid,$id_name='id',$pid_name='pid'){
  $arr=array();
  foreach ($cate as $v) {
   if($v[$pid_name]==$pid){
    
    $arr[]=$v[$id_name];
    $arr=array_merge(self::getChildsID($cate,$v[$id_name],$id_name,$pid_name),$arr);
  }
}
return $arr;
}
}
?>