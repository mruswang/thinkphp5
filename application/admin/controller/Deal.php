<?php
namespace app\admin\controller;
use think\Controller;

class Deal extends Controller
{
    public function index(){
        //获取数据
        $data=input('get.');
        $alldata=[];
        if(!empty($data['start_time']) && !empty($data['end_time']) && strtotime($data['end_time']) > strtotime($data['start_time'])) {
            $alldata['create_time'] = [
                ['gt', strtotime($data['start_time'])],
                ['lt', strtotime($data['end_time'])],
            ];
        }
        if(!empty($data['category_id'])){
            $alldata['category_id']=$data['category_id'];
        }
        if(!empty($data['city_id'])){
            $alldata['city_id']=$data['city_id'];
        }
        if(!empty($data['name'])){
            $alldata['name']=['like', '%'.$data['name'].'%'];
        }
        //获取所有城市分类
        $citys=model('City')->allcity();
        //获取所有分类
        $categorys=model('Category')->allCategory();
        //获取搜索的信息
        $deal=model('Deal')->getNormalDeals($alldata);
        //print_r($deal);
        foreach($categorys as $category) {
            $categoryArrs[$category->id] = $category->name;
        }foreach($citys as $city) {
            $cityArrs[$city->id] = $city->name;
        }
        return $this->fetch('',[
            'deal'=>$deal,
            'citys'=>$citys,
            'categorys'=>$categorys,
            'categoryArrs'=>$categoryArrs,
            'cityArrs'=>$cityArrs,
            'category_id' => empty($data['category_id']) ? '' : $data['category_id'],
            'city_id' => empty($data['city_id']) ? '' : $data['city_id'],
            'start_time' => empty($data['start_time']) ? '' : $data['start_time'],
            'end_time' => empty($data['end_time']) ? '' : $data['end_time'],
            'name' => empty($data['name']) ? '' : $data['name'],
        ]);
    }
    public function apply(){
        //获取数据
        $data=input('get.');
        $alldata=[];
        if(!empty($data['start_time']) && !empty($data['end_time']) && strtotime($data['end_time']) > strtotime($data['start_time'])) {
            $alldata['create_time'] = [
                ['gt', strtotime($data['start_time'])],
                ['lt', strtotime($data['end_time'])],
            ];
        }
        if(!empty($data['category_id'])){
            $alldata['category_id']=$data['category_id'];
        }
        if(!empty($data['city_id'])){
            $alldata['city_id']=$data['city_id'];
        }
        if(!empty($data['name'])){
            $alldata['name']=['like', '%'.$data['name'].'%'];
        }
        //获取所有城市分类
        $citys=model('City')->allcity();
        //获取所有分类
        $categorys=model('Category')->allCategory();
        //获取搜索的信息
        $deal=model('Deal')->getNormalDeals($alldata);
        //print_r($deal);
        foreach($categorys as $category) {
            $categoryArrs[$category->id] = $category->name;
        }
        foreach($citys as $city) {
            $cityArrs[$city->id] = $city->name;
        }
        return $this->fetch('',[
            'deal'=>$deal,
            'citys'=>$citys,
            'categorys'=>$categorys,
            'categoryArrs'=>$categoryArrs,
            'cityArrs'=>$cityArrs,
            'category_id' => empty($data['category_id']) ? '' : $data['category_id'],
            'city_id' => empty($data['city_id']) ? '' : $data['city_id'],
            'start_time' => empty($data['start_time']) ? '' : $data['start_time'],
            'end_time' => empty($data['end_time']) ? '' : $data['end_time'],
            'name' => empty($data['name']) ? '' : $data['name'],
        ]);
    }
    public function detail(){
        $data=input('get.id');
        $citys=model('City')->allcity();
        //获取一集栏目分类
        $categorys=model('Category')->allCategory();
        $deal=model('Deal')->get($data);
        //print_r($deal);
        return $this->fetch('',[
            'deal'=>$deal,
            'citys'=>$citys,
            'categorys'=>$categorys,
        ]);
    }


    public function status(){
        //获取传递数据
        $data=input('get.');//print_r($data);
        $res=model('Deal')->save(['status'=>$data['status']],['id'=>$data['id']]);

        if($res){
            $this->success('状态更新成功');
        }else{
            $this->success('状态更新失败');
        }

    }

}
