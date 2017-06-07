<?php
namespace app\index\controller;
use think\Controller;
class Base extends Controller
{
    public $city='';
    public $account='';
    public function _initialize(){

        //城市数据
        $citys = model('City')->allcity();

        //用户数据
        // 获取首页分类的数据
        $cat = $this->getRecommendCats();
        $this->getCity($citys);
        $this->assign('citys',$citys);
        $this->assign('city',$this->city);
        $this->assign('user',$this->getLoginUser());
        $this->assign('cat',$cat);
        $this->assign('title','o2o团购网');


    }
    public function getCity($citys){
        foreach($citys as $city){
            $city=$city->toArray();
            //print_r($city);exit;
            if($city['is_default']==1){
                $defaultuname=$city['uname'];
                break;//终止其他操作
            }
        }
        $defaultuname=empty($defaultuname)?'chengdu':$defaultuname;
        if(session('cityuname','','o2o')&& !input('get.city')){
            $cityuname=session('cityuname','','o2o');
        }else{
            $cityuname=input('get.city',$defaultuname,'trim');
            session('cityname',$cityuname,'o2o');
        }
        $this->city=model('City')->where(['uname'=>$cityuname])->find();
    }
    public function getLoginUser() {
        if(!$this->account) {
            $this->account = session('o2o_user', '', 'o2o');
        }
        return $this->account;
    }

    /*
     * 获取首页的推荐位的数据
     * */
    public function getRecommendCats(){

        $cats=model('Category')->getNormalRecommendCategoryByParentId(0,10);
        //print_r($cats);
        foreach($cats as $cat){
            $parentIds[]=$cat->id;
        }
        //获取二级分类数据
        $sedCats=model('Category')->getNormalCategoryIdParentId($parentIds);
       // print_r($sedCats);
        foreach ($sedCats as $sedcat){
            $sedcatArr[$sedcat->parent_id][]=[
                'id' => $sedcat->id,
                'name' => $sedcat->name,
            ];
        }
        foreach ($cats as $cat){
            // recomCats 代表是一级 和 二级数据，  []第一个参数是 一级分类的name, 第二个参数 是 此一级分类下面的所有二级分类数据
            $recomCats[$cat->id] = [$cat->name, empty($sedcatArr[$cat->id]) ? [] : $sedcatArr[$cat->id]];
        }
        //print_r($recomCats);exit;
        return $recomCats;

    }

    /**
     * 获取首页推荐当中中的商品分类数据
     */
    /*public function getRecommendCat() {
        $parentIds = $sedcatArr = $recomCats = [];
        $cats = model('Category')->getNormalRecommendCategoryByParentId(0,5);
        foreach($cats as $cat) {
            $parentIds[] = $cat->id;
        }
        // 获取二级分类的数据
        $sedCats = model('Category')->getNormalCategoryIdParentId($parentIds);

        foreach($sedCats as $sedcat) {
            $sedcatArr[$sedcat->parent_id][] = [
                'id' => $sedcat->id,
                'name' => $sedcat->name,
            ];
        }

        foreach($cats as $cat) {
            // recomCats 代表是一级 和 二级数据，  []第一个参数是 一级分类的name, 第二个参数 是 此一级分类下面的所有二级分类数据
            $recomCats[$cat->id] = [$cat->name, empty($sedcatArr[$cat->id]) ? [] : $sedcatArr[$cat->id]];
        }
        return $recomCats;
    }*/
}
