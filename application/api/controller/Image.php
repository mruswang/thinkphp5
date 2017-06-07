<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/26 0026
 * Time: 下午 3:16
 */
namespace app\api\controller;
use think\Controller;
use think\Request;
use think\File;

class Image extends Controller{
    public function upload(){

        $file=Request::instance()->file('file');
        //给定一个文件存放目录
        $info=$file->move('upload');
       //print_r($info);
       if($info&&$info->getPathname()){
            return show(1,'success','/'.$info->getPathname());
       }
        return show(0,'upload error');
    }

}