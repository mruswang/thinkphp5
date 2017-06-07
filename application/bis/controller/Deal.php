<?php
namespace app\bis\controller;
use think\Controller;
class Deal extends  Base
{
    /**
     * @return mixed 商户中心的 deal列表页面 小伙伴自行完成
     */
    public function index()
    {
        $bisId = $this->getLoginUser()->bis_id;
        //获取一集城市分类
        $citys=model('City')->getNormalCityByParentId();
        //获取一集栏目分类
        $categorys=model('Category')->getNormalCategoryByParentId();
        $deal=model('Deal')->getDeal($bisId,['neq',-1]);
        return $this->fetch('',[
            'deal'=>$deal,
            'citys'=>$citys,
            'categorys'=>$categorys,
        ]);
    }

    public function  add() {
        $bisId = $this->getLoginUser()->bis_id;
        if(request()->isPost()){
            $data=input('post.');
            //validaate的严格验证
            //print_r($data);
            //数据存储
            $location = model('BisLocation')->get($data['location_ids'][0]);
            $deals = [
                'bis_id' => $bisId,
                'name' => $data['name'],
                'image' => $data['image'],
                'category_id' => $data['category_id'],
                'se_category_id' => empty($data['se_category_id']) ? '' : implode(',', $data['se_category_id']),
                'city_id' => $data['city_id'],
                'location_ids' => empty($data['location_ids']) ? '' : implode(',', $data['location_ids']),
                'start_time' => strtotime($data['start_time']),
                'end_time' => strtotime($data['end_time']),
                'total_count' => $data['total_count'],
                'origin_price' => $data['origin_price'],
                'current_price' => $data['current_price'],
                'coupons_begin_time' => strtotime($data['coupons_begin_time']),
                'coupons_end_time' => strtotime($data['coupons_end_time']),
                'notes' => $data['notes'],
                'description' => $data['description'],
                'bis_account_id' => $this->getLoginUser()->id,
                'xpoint' => $location->xpoint,
                'ypoint' => $location->ypoint,


            ];

            $id = model('Deal')->add($deals);
            if($id) {
                $this->success('添加成功', url('deal/index'));
            }else {
                $this->error('添加失败');
            }

        }else{
            //获取一集城市分类
            $citys=model('City')->getNormalCityByParentId();
            //获取一集栏目分类
            $categorys=model('Category')->getNormalCategoryByParentId();
            //获取所有的门店
            $location=model('BisLocation')->getLocation($bisId,1);
            // print_r($location);exit;
            return $this->fetch('',[
                'citys'=>$citys,
                'categorys'=>$categorys,
                'location'=>$location
            ]);
        }
    }
}
