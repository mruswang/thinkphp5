<?php
namespace app\admin\controller;
use think\Controller;

class Bis extends Controller
{
    private $obj;
    public function _initialize(){
        $this->obj=model('Bis');
    }
    public function no(){
        $bis=$this->obj->getBisStatus(2);
        return $this->fetch('',[
            'bis'=>$bis
        ]);
    }
    public function del(){
        $bis=$this->obj->getBisStatus(-1);
        return $this->fetch('',[
            'bis'=>$bis
        ]);
    }
    public function del_data($id){

        $res= $this->obj->destroy(['id'=>$id]);
        $location=model('BisLocation')->destroy(['id'=>$id]);
        $account=model('BisAccount')->destroy(['id'=>$id]);
        if($res&&$location&&$account){
            $this->success('删除成功');
        }else{
            $this->success('删除失败');
        }
    }
    public function index(){
        $bis=$this->obj->getBisStatus(1);
        return $this->fetch('',[
            'bis'=>$bis
        ]);
    }
    public function apply(){
        $bis=$this->obj->getBisStatus();
        return $this->fetch('',[
            'bis'=>$bis
        ]);
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

        $bisData=model('Bis')->get($id);
        $locationData=model('BisLocation')->get(['is_main'=>1,'bis_id'=>$id]);
        $accountData=model('BisAccount')->get(['is_main'=>1,'bis_id'=>$id]);
        return $this->fetch('',[
            'citys'=>$citys,
            'categorys'=>$categorys,
            'bisData'=>$bisData,
            'locationData'=>$locationData,
            'accountData'=>$accountData,
        ]);
    }
    public function status(){
        //获取传递数据
        $data=input('get.');//print_r($data);
        $res=$this->obj->save(['status'=>$data['status']],['id'=>$data['id']]);
        $locationData=model('BisLocation')->save(['status'=>$data['status']],['id'=>$data['id']]);
        $accountData=model('BisAccount')->save(['status'=>$data['status']],['id'=>$data['id']]);
        if($res&&$locationData&&$accountData){
            $this->success('状态更新成功');
        }else{
            $this->success('状态更新失败');
        }

    }
}
