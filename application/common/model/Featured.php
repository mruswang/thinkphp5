<?php
namespace app\common\model;
use think\Model;
class Featured extends BaseModel
{
    public function getType($type){
        $data=[
            'status'=>['neq',-1],
            'type'=>$type
        ];
        $order=[
            'listorder'=>'desc',
            'id'=>'desc'
        ];
        $result=$this->where($data)
            ->order($order)
            ->paginate();
        return $result;
    }
    public function getfeatured(){

    }
}

