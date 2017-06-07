<?php
namespace app\common\model;
use think\Model;

//BaseModel公共的model层

class BaseModel extends Model
{
    protected $autoWriteTimestamp=true;
    public function add($data){
        $data['status']=0;
         $this->save($data);
         //返回主键id
         return $this->id;

    }







}

