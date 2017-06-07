<?php
namespace app\common\model;
use think\Model;
class Bis extends BaseModel
{

//    通过状态获取商家信息
        public function getBisStatus($status=0){
            $order=[
                'id'=>'desc'
            ];
            $data=[
                'status'=>$status
            ];
            $result= $this->where($data)
                ->order($order)
                ->paginate();
            return $result;
        }
}

