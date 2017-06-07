<?php
namespace app\api\controller;
use think\Controller;

class Category extends Controller
{
    private $obj;
    public function _initialize(){
        $this->obj=model('Category');
    }
    public function getCategoryByParentId(){
       $id=input('post.id');
       if(!intval($id)){
        $this->error('ID不合法');
       }
       //通过id获取二级城市
       $category=  $this->obj->getNormalCategoryByParentId($id);

       //从新定义方法：
       if(!$category){
           return show(0,'error');
       }
       return show(1,'success',$category);
    }


}
