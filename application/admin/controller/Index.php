<?php
namespace app\admin\controller;
use think\Controller;

class Index extends Controller
{
    public function index(){
        return  $this->fetch('index');
    }
    public function welcome(){
         return  $this->fetch('welcome');
    }
    public function test(){
        return \Map::getLngLat('北京昌平沙河地铁');
        //\phpmailer\Email::send('875484737@qq.com','侧睡','success-测试');  //126邮箱
        //\phpmailer\qqEmail::send('704001667@qq.com','QQ邮箱的使用方法','success使用了QQ邮箱');  //qq邮箱
        return '发送邮件成功';
        //return '1';
    }
    public function map(){

        return \Map::staticimage('成都广都地铁');

    }
}
