<?php
namespace app\index\controller;
use think\Controller;
class Index extends Base
{
    public function index(){

        //获取首页图片banner
        $banner=model('Featured')->getType(0);
        $banner_right=model('Featured')->getType(1);
        //print_r($banner);
        //获取商品的数据
        $datas = model('Deal')->getNormalDealByCategoryCityId( $this->city->id);
        //print_r($datas);
        // 获取4个子分类
        //$meishicates = model('Category')->getNormalRecommendCategoryByParentId(1, 4);
        return  $this->fetch('',[
            'banner'=>$banner,
            'banner_right'=>$banner_right,
            'datas'=>$datas,
           // 'meishicates'=>$meishicates,
        ]);

    }
}
