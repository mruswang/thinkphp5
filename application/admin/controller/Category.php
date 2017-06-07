<?php
namespace app\admin\controller;
use think\Controller;

class Category extends Base
{
    private $obj;
    public function _initialize(){
        $this->obj=model('Category');
    }
    public function index(){
        $parentId= input('get.parent_id',0,'intval');
        $categorys= $this->obj->getFirstCategory($parentId);
        return  $this->fetch('index',[
            'categorys'=>$categorys
        ]);
    }
    public function del(){
        $parentId= input('get.parent_id',0,'intval');
        $categorys= $this->obj->getFirstCategoryDel($parentId);
        return  $this->fetch('del',[
            'categorys'=>$categorys
        ]);
    }
    public function add(){
        $categorys= $this->obj->getNormalFirstCategory();
        return  $this->fetch('add',[
            'categorys'=>$categorys
        ]);
    }

    public function save() {
        //return "ok";
       // print_r($_POST); //原始获取数据的方法
       //print_r(input('post.'));  //tp5提供的两种方法 更安全
       //print_r(request()->post());
        /*做下判断*/
        if(!request()->isPost()){
            $this->error('请求失败');
        }
       $data=input('post.');
       //$data['status']=10;
       $validate=validate('Category');
       if(!$validate->scene('add')->check($data)){
            $this->error($validate->getError());
       }
       if(!empty($data['id'])){
            return $this->update($data);
       }
       //print_r($data);
       /*把数据提交给model*/
       $res= $this->obj->add($data);
       if($res){
            $this->success('新增成功');
       }else{
            $this->error('新增失败');
       }
    }


//    编辑
    public function edit($id=0){
        //echo input('get.id');
        //return  $this->fetch('edit');
        if(intval($id)<1){
            $this->error('参数不合法');
        }
        $category=$this->obj->get($id);//print_r($category);exit;
        $categorys= $this->obj->getNormalFirstCategory();
        return  $this->fetch('edit',[
            'categorys'=>$categorys,
            'category'=>$category
        ]);
    }


    public function update($data){
        $res= $this->obj->save($data,['id'=>intval($data['id'])]);
        if($res){
            $this->success('更新成功');
        }else{
            $this->error('更新失败');
        }
    }

    //排序逻辑
    public function listorder($id,$listorder){
        //echo $listorder;
        //echo $id;
        $validate=validate('Category');
        if(!$validate->scene('listorder')->check($listorder)){
            $this->error($validate->getError());

        }
        $res= $this->obj->save(['listorder'=>$listorder],['id'=>$id]);
        if($res){
            $this->result($_SERVER['HTTP_REFERER'],1,'success');
        }else{
            $this->result($_SERVER['HTTP_REFERER'],0,'error');
        }
    }

    public function del_data($id){

        $res= $this->obj->destroy(['id'=>$id]);
        if($res){
            $this->success('删除成功');
        }else{
            $this->success('删除失败');
        }
    }
}
