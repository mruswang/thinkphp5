<?php
namespace app\bis\controller;
use think\Controller;
class Location extends  Base
{
    /**
     * @return mixed列表页 小伙伴自行完成 列表开发
     */
    public function index()
    {
        $bisId = $this->getLoginUser()->bis_id;
        $location=model('BisLocation')->getLocation($bisId,['neq',-1]);
        return $this->fetch('',[
            'location'=>$location
        ]);
    }

    public function add() {
        if(request()->isPost()) {
            // 第一点 检验数据 tp5 validate机制， 小伙伴自行完成

            $data = input('post.');
            $bisId = $this->getLoginUser()->bis_id;
            $data['cat'] = '';
            if(!empty($data['se_category_id'])) {
                $data['cat'] = implode('|', $data['se_category_id']);
            }

            // 获取经纬度
            $lnglat = \Map::getLngLat($data['address']);
            if(empty($lnglat) || $lnglat['status'] !=0 || $lnglat['result']['precise'] !=1) {
                $this->error('无法获取数据，或者匹配的地址不精确');
            }

            // 门店入库操作
            // 总店相关信息入库
            $locationData = [
                'bis_id' => $bisId,
                'name' => $data['name'],
                'logo' => $data['logo'],
                'tel' => $data['tel'],
                'contact' => $data['contact'],
                'category_id' => $data['category_id'],
                'category_path' => $data['category_id'] . ',' . $data['cat'],
                'city_id' => $data['city_id'],
                'city_path' => empty($data['se_city_id']) ? $data['city_id'] : $data['city_id'].','.$data['se_city_id'],
                'api_address' => $data['address'],
                'open_time' => $data['open_time'],
                'content' => empty($data['content']) ? '' : $data['content'],
                'is_main' => 0,
                'xpoint' => empty($lnglat['result']['location']['lng']) ? '' : $lnglat['result']['location']['lng'],
                'ypoint' => empty($lnglat['result']['location']['lat']) ? '' : $lnglat['result']['location']['lat'],
            ];
            $locationId = model('BisLocation')->add($locationData);
            if($locationId) {
                return $this->success('门店申请成功');
            }else {
                return $this->error('门店申请失败');
            }
        }else {
            //获取一级城市的数据
            $citys = model('City')->getNormalCityByParentId();
            //获取一级栏目的数据
            $categorys = model('Category')->getNormalCategoryByParentId();
            return $this->fetch('', [
                'citys' => $citys,
                'categorys' => $categorys,
            ]);
        }
    }
    public function detail(){
        //获取传输id  记住这里有个坑

        $id=input('get.id');  //当用$id=input('get.')获取值时，会出现数组未定义脚标  因为获取的是很多的数据，不止一个
        // print_r($id);
        if(empty($id)){
            return $this->error('获取ID错误');
        }
        //获取一集城市分类
        $citys=model('City')->getNormalCityByParentId();
        //获取一集栏目分类
        $categorys=model('Category')->getNormalCategoryByParentId();
        //获取商户数据
        $bisId = $this->getLoginUser()->bis_id;

        $locationData=model('BisLocation')->get(['bis_id'=>$bisId,'id'=>$id]);

        return $this->fetch('',[
            'citys'=>$citys,
            'categorys'=>$categorys,
            'locationData'=>$locationData,

        ]);
    }
    public function status(){
        //获取传过来的值
        $data=input('get.');
        //print_r($data);
        $res=model('BisLocation')->save(['status'=>$data['status']],['id'=>$data['id']]);
        if($res){
            $this->success('状态更新成功');
        }else{
            $this->success('状态更新失败');
        }

    }

    public function del()
    {
        $bisId = $this->getLoginUser()->bis_id;
        $location=model('BisLocation')->getLocation($bisId,-1);
        return $this->fetch('',[
            'location'=>$location
        ]);
    }
}
