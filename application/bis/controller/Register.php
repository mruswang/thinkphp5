<?php
namespace app\bis\controller;
use think\Controller;
class Register extends  Controller
{
	public function index()
    {
        //获取一集城市分类
        $citys=model('City')->getNormalCityByParentId();
        //获取一集栏目分类
        $categorys=model('Category')->getNormalCategoryByParentId();
        return $this->fetch('index',[
            'citys'=>$citys,
            'categorys'=>$categorys,
        ]);
    }

    public function add(){
        if(!request()->isPost()){
            $this->error("请求错误");
        }
        //获取表单的值
        $data=input('post.');
      // print_r($data['open_time']);

        //检验数据
        $validate=validate('Bis');
        if(!$validate->scene('basic')->check($data)){
            $this->error($validate->getError());
        }
        //获取经纬度
        $lnglat=\Map::getLngLat($data['address']);
        if(empty($lnglat) || $lnglat['status']!=0 ||$lnglat['result']['precise']!=1){
            $this->error('无法获取数据，或者匹配的地址不精确');
        }
        //商户基本信息入库
        $bisDate=[
            'name'=>$data['name'],
            'city_id'=>$data['city_id'],
            'city_path'=>empty($data['se_city_id'])?$data['city_id']:$data['city_id'].','.$data['se_city_id'],
            'logo'=>$data['logo'],
            'licence_logo'=>$data['licence_logo'],
            'description'=>empty($data['description'])? '' :$data['description'],
            'bank_info'=>$data['bank_info'],
            'bank_name'=>$data['bank_name'],
            'bank_user'=>$data['bank_user'],
            'faren'=>$data['faren'],
            'faren_tel'=>$data['faren_tel'],
            'email'=>$data['email'],
        ];
        $bisId=model('Bis')->add($bisDate);//echo $bisId;
        //总店相关信息校验
        //检验数据
        if(!$validate->scene('headquarters')->check($data)){
            $this->error($validate->getError());
        }
        //总店信息入库
        $data['cat']='';
        if(!empty($data['se_category_id'])){
            $data['cat']=implode('|',$data['se_category_id']);//implode把数组元素组合为字符串：
        }
        //时间处理
        //$data['time']= explode('-',$data['open_time']);
       // $data_time=strtotime($data['time'][0]).','.strtotime($data['time'][1]);
        $locationData=[
            'bis_id'=>$bisId,
            'name'=>$data['name'],
            'tel'=>$data['tel'],
            'logo'=>$data['logo'],
            'contact'=>$data['contact'],
            'category_id'=>$data['category_id'],
            'category_path'=>$data['category_id'].','. $data['cat'],
            'city_id'=>$data['city_id'],
            'city_path'=>empty($data['se_city_id'])?$data['city_id']:$data['city_id'].','.$data['se_city_id'],
            'api_address'=>$data['address'],
            'open_time'=>$data['open_time'],
            'content'=>empty($data['content'])? '' :$data['content'],
            'is_main'=>1, //代表总店信息
            'xpoint'=>empty($lnglat['result']['location']['lng'])?'':$lnglat['result']['location']['lng'],
            'ypoint'=>empty($lnglat['result']['location']['lat'])?'':$lnglat['result']['location']['lat'],
        ];

        $locationId=model('BisLocation')->add($locationData);//echo $bisId;
        if(!$locationId){
            $this->error('总店信息入库失败');
        }
        //账户相关信息校验
        //检验数据
        if(!$validate->scene('account')->check($data)){
            $this->error($validate->getError());
        }
        //自动生成密码的加盐字符串
        $data['code']=mt_rand(100,10000);//mt_rand() 使用 Mersenne Twister 算法返回随机整数。
        $accountData=[
            'bis_id'=>$bisId,
            'username'=>$data['username'],
            'code'=>$data['code'],
            'password'=>md5($data['password']. $data['code']),
            'is_main'=>1, //代表总管理员
        ];

        $accountId=model('BisAccount')->add($accountData);
        if(!$accountId){
            $this->error('申请失败');
        }

        //发送邮件
        $url=request()->domain().url('bis/register/waiting',['id'=>$bisId]);
        $title="入驻申请通知";
        $content="你提交的入驻申请需等待审核，你可以通过点击链接<a href='".$url."' target='_blank'>查看链接</a>查看";

        \phpmailer\qqEmail::send($data['email'],$title,$content);


        $this->success('申请成功',url('register/waiting',['id'=>$bisId]));


    }
    public function find(){
        $data=input('post.');
        $username=model('BisAccount')->get(['username'=>$data['username']]);//查询数据的方式
        if($username){
            $this->result($_SERVER['HTTP_REFERER'],1,'用户名已存在');
        }else{
            $this->result($_SERVER['HTTP_REFERER'],0,'可以使用');
        }
    }

    public function waiting($id){
        if(empty($id)){
            $this->error('error');
        }
        $detail=model('Bis')->get($id);
        return $this->fetch('waiting',[
            'detail'=>$detail
            ]);
    }
}

