<?php
namespace app\common\model;
use think\Model;
class Category extends Model
{
    protected $autoWriteTimestamp=true;
    public function add($data){
        $data['status']=1;
        //$data['create_time'] = time();
        return $this->save($data);

    }

    //获取所有分类
    public function allCategory(){
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
    //获取一级分类
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
    //获取相应的主次级分类
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
            ->paginate(5);
        //echo $this->getLastSql();

        return $result;
    }
    //获取软删除的分类
    public function getFirstCategoryDel($parentId=0){

        $data=[
            'parent_id'=>$parentId,
            'status'=>-1
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
    //获取相应的次级通过的分类
    public function getNormalCategoryByParentId($parentid=0){

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
    //获取一级分类，并返回5条
    public function getNormalRecommendCategoryByParentId($parentid=0,$limit=5){
        $data=[
            'status'=>1,
            'parent_id'=>$parentid
        ];
        $order=[
            'listorder'=>'desc',
            'id'=>'desc',
        ];

        $result = $this->where($data)->order($order);
        if($limit) {
            $result = $result->limit($limit);
        }
        return $result->select();
    }

    //通过一个分类，获取子分类
    public function getNormalCategoryIdParentId($ids) {
        $data = [
            'parent_id' => ['in', implode(',', $ids)],
            'status' => 1,
        ];

        $order = [
            'listorder' => 'desc',
            'id' => 'desc',
        ];

        $result = $this->where($data)
            ->order($order)
            ->select();

        return $result;
    }

}

