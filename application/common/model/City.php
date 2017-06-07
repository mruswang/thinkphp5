<?php
/**
 * Created by PhpStorm.
 * User: wangsir
 * Date: 2017/5/24
 * Time: 21:39
 */
namespace app\common\model;
use think\Model;
class City extends Model
{
    public function add($data){
        $data['status']=1;
        //$data['create_time'] = time();
        return $this->save($data);

    }
    //获取所有城市
    public function allcity(){
        $data=[
            'status'=>1,
        ];
        $order=[
            'id'=>'desc',
        ];
        return $this->where($data)
            ->order($order)
            ->select();
    }
    //获取一级城市
    public function getNormalFirstCategory(){
        $data=[
            'status'=>1,
            'parent_id'=>0
        ];
        $order=[
            'id'=>'desc',
        ];
        return $this->where($data)
            ->order($order)
            ->select();
    }
    //获取主次级城市
    public function getFirstCategory($parentId=0){
        $data=[
            'parent_id'=>$parentId,
            'status'=>['neq',-1]
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
    //获取相应的通过的次级城市
    public function getNormalCityByParentId($parentid=0){

        $data=[
            'status'=>1,
            'parent_id'=>$parentid
        ];
        $order=[
            'id'=>'desc',
        ];
        return $this->where($data)
            ->order($order)
            ->select();

    }

}