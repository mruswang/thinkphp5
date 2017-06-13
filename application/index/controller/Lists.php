<?php
namespace app\index\controller;
use think\Controller;
class Lists extends Base
{
    public function index(){

        $firstCatIds = [];
        // 思路 首先需要一级栏目
        $categorys = model("Category")->getNormalCategoryByParentId();
        foreach($categorys as $category) {
            $firstCatIds[] = $category->id;
        }
        $id = input('id', 0, 'intval');
        $data = [];
        print_r($id);
        print_r($firstCatIds);
        // id=0 一级分类 二级分类
        if(in_array($id, $firstCatIds)) { // 一级分类 表示在数组中存在$id这个值

            $categoryParentId = $id;
            $data['category_id'] = $id;
        }elseif($id) { // 二级分类
            // 获取二级分类的数据
            $category = model('Category')->get($id);
            if(!$category || $category->status !=1) {
                $this->error('数据不合法');
            }
            $categoryParentId = $category->parent_id;
            $data['se_category_id'] = $id;
        }else{ // 0
            $categoryParentId = 0;
        }
        $sedcategorys = [];
        //获取父类下的所有 子分类
        if($categoryParentId) {
            $sedcategorys = model('Category')->getNormalCategoryByParentId($categoryParentId);
        }
        return  $this->fetch('',[
            'categorys' => $categorys,
            'sedcategorys' => $sedcategorys,
            'id' => $id,
            'categoryParentId' => $categoryParentId,
        ]);

    }
}
