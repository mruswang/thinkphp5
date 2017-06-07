<?php
namespace app\index\controller;
use think\Controller;
class User extends Controller
{
    public function login(){

        if(request()->post()){
            $data=input('post.');
            //获取数据库中的值

            $result=model('User')->get(['username'=>$data['username']]);
            //验证码是否正确
            if(!captcha_check($data['code'])){
                $this->error('验证码不正确');
            }
            //判断用户是否存在
            if(!$result ||$result['status']!=1){
                $this->error('该用户不存在');
            }
            //验证密码的正确性
            if(md5($data['password'].$result->code)!=$result->password){
                $this->error('密码不正确');
            }
            // 登录成功 更新时间
            model('User')->save(['last_login_time'=>time(),'last_login_ip'=> $_SERVER['REMOTE_ADDR']], ['id'=>$result->id]);
            session('o2o_user',$result,'o2o' );
            $this->success('登录成功', url('index/index'));
        }else{
            $user = session('o2o_user','', 'o2o');
            if($user && $user['id']) {
                $this->redirect(url('index/index'));
            }
            return  $this->fetch('');
        }

    }
    public function register(){
        if(request()->isPost()){
            //获取数据
            $data=input('post.');
            //print_r($data);
            if(!captcha_check($data['code'])){
                $this->error('验证码不正确');
            }
            // 自动生成 密码的加盐字符串
            $data['code'] = mt_rand(100, 10000);
            $data['password'] = md5($data['password'].$data['code']);
            try{
                $reuslt=model('User')->add($data);
            }catch (\Exception $e){
                $this->error($e->getMessage());
            }

            if($reuslt){
                $this->success('注册成功',url('user/login'));
            }else{
                $this->error('注册失败，请从新注册');
            }


        }else{
            return  $this->fetch('');
        }
    }
    //退出登录
    public function logout() {
        session(null, 'o2o');
        $this->redirect(url('user/login'));
    }
}
