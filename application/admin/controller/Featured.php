<?php
namespace app\admin\controller;
use think\Controller;

class Featured extends Base
{
    public function index(){
        $type=input('get.type' ,3 ,'intval');
        if($type==3){
            $type=['neq',-1];
        }
        $result=model('Featured')->getType($type);
        $types=config('Featured');
        return  $this->fetch('',[
            'types'=>$types,
            'result'=>$result,
            'type'=>$type,
        ]);
    }
    public function add(){
        if(request()->isPost()){
            $data=input('post.');
            //print_r($data);exit;
            $id=model('Featured')->add($data);
            if($id){
                $this->success('成功',url('featured/index'));
            }else{
                $this->error('失败');
            }
        }else{
            $types=config('Featured');
            return  $this->fetch('',[
                'types'=>$types
            ]);
        }

    }


}
