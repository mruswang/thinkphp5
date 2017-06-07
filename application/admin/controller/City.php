<?php
namespace app\admin\controller;
use think\Controller;

class City extends Controller
{
    private $obj;
    public function _initialize(){
        $this->obj=model('City');
    }
    public function index(){
        $parentId= input('get.parent_id',0,'intval');
        $citys= $this->obj->getFirstCategory($parentId);
        return  $this->fetch('index',[
            'citys'=>$citys
        ]);
    }
    public function add(){
        //$citys= $this->obj->getNormalFirstCategory();
        $citys= $this->obj->allcity();

        return  $this->fetch('add',[
            'citys'=>$citys
        ]);
    }
    public function save(){
        if(!request()->isPost()){
            $this->error('请求失败');
        }
        $data=input('post.');
        $validate=validate('Category');
        if(!$validate->scene('add')->check($data)){
            $this->error($validate->getError());
        }
        if(!empty($data['id'])){
            return $this->update($data);
        }
        /*把数据提交给model*/
        $res=$this->obj->add($data);
        if($res){
            $this->success('新增成功');
        }else{
            $this->error('新增失败');
        }
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
        $validate=validate('City');
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
    public function edit($id=0){
        //echo input('get.id');
        //return  $this->fetch('edit');
        if(intval($id)<1){
            $this->error('参数不合法');
        }
        $city=$this->obj->get($id);//print_r($category);exit;
        //$citys= $this->obj->getNormalFirstCategory();
        $citys= $this->obj->allcity();
        return  $this->fetch('edit',[
            'citys'=>$citys,
            'city'=>$city
        ]);
    }
    public function status(){
        //print_r(input('get.'));
        $data=input('get.');
        /* //$data['status']=10;
         $validate=validate('City');
         if(!$validate->scene('status')->check($data)){
             $this->error($validate->getError());
         }*/
        $res= $this->obj->save(['status'=>$data['status']],['id'=>$data['id']]);
        if($res){
            $this->success('状态更新成功');
        }else{
            $this->success('状态更新失败');
        }
    }
}
