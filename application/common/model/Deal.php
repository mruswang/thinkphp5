<?php
namespace app\common\model;
use think\Model;
class Deal extends BaseModel
{
    //获取指定的团购项目
    public function getDeal($bisIid,$status){
        $data=[
            'bis_id'=>$bisIid,
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
    //获取所有的团购列表
    public function getallDeal($status){
        $data=[
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
    //获取搜索状态下的数据，当$data为空时，相当于获取所有的团购列表
    public function getNormalDeals($data = []) {
        $data['status'] = ['neq',-1];
        $order = ['id'=>'desc'];

        $result = $this->where($data)
            ->order($order)
            ->paginate();

        //echo $this->getLastSql();
        return  $result;
    }
    /**
     * 根据分类 以及 城市来获取 商品数据
     * @param $id 分类
     * @param $cityId 城市
     * @param int $limit 条数
     */
    public function getNormalDealByCategoryCityId($cityId,$limit=10){

        $data  = [
            'end_time' => ['gt', time()],
           // 'category_id' => $id,
            'city_id' => $cityId,
            'status' => 1,
        ];

        $order = [
            'listorder'=>'desc',
            'id'=>'desc',
        ];

        $result = $this->where($data)
            ->order($order);
        if($limit) {
            $result = $result->limit($limit);
        }
        return $result->select();

    }
}

