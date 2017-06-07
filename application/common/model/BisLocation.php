<?php
namespace app\common\model;
use think\Model;
class BisLocation extends BaseModel
{
    public function getLocation($parentId,$status){
        $data=[
            'bis_id'=>$parentId,
            'status'=>$status
        ];
        $order=[
            'listorder'=>'desc',
            'id'=>'desc',
        ];

        $result= $this->where($data)
            ->order($order)
            ->paginate();
        //echo $this->getLastSql();

        return $result;
    }

    public function getNormalLocation(){

    }
}

