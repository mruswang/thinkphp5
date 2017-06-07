<?php
namespace app\bis\controller;
use think\Controller;
class Login extends  Controller
{
	public function index()
    {
        if(request()->isPost()){
            //获取数据
            $data=input('post.');
            //print_r($data);
            //从数据库中获取值
            $ret=model('BisAccount')->get(['username'=>$data['username']]);
            //判断用户名
            if(!$ret ||$ret->status!=1){
               return $this->error('用户名不存在，或者审核未通过');
            }
            //判断密码
            if($ret->password!=md5($data['password'].$ret->code)){
                return  $this->error('密码输入错误');
            }
            model('BisAccount')->update(['id' => $ret->id,'last_login_time'=>time()]);
            // 保存用户信息  bis是作用域
            session('bisAccount', $ret, 'bis');
            return $this->success('登录成功', url('index/index'));
        }else{
            // 获取session
            $account = session('bisAccount', '', 'bis');
            if($account && $account->id) {
                return $this->redirect(url('index/index'));
            }
            return $this->fetch();
        }


    }
    public function logout(){
        session(null, 'bis');
        return $this->redirect(url('login/index'));
    }


}