<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
function status($status){
    if($status==1){
        $str="<span class='label label-success radius'>正常</span>";
    }elseif($status==0){
        $str="<span class='label label-danger radius'>待审</span>";
    }elseif($status==2){
        $str="<span class='label label-danger radius'>不通过</span>";
    }else{
        $str="<span class='label label-warning radius'>软删除</span>";
    }
    return $str;
}


/*$type 0 get 1 post*/
function doCurl($url,$type=0,$data=[]){
    $ch=curl_init(); //初始化
    //设置选项
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch,CURLOPT_HEADER,0);

    if($type==1){
        //post
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$data);

    }

    //执行并获取内容
    $output=curl_exec($ch);
    //释放curl句柄
    curl_close($ch);
    return $output;
}

//商户入驻申请文案
function bisRegister($status){

    if($status==1){
        $str="入驻申请成功";
    }elseif($status==0){
        $str="待审核，审核后平台方会发送邮件，请关注";
    }elseif($status==2){
        $str="非常抱歉，你提交的材料不符合条件，请重新提交";
    }else{
        $str="该申请已被删除";
    }
    return $str;
}


//公用的分页样式
function paginate($obj){
    if(!$obj){
        return '';
    }
    return '<div class="cl pd-5 bg-1 bk-gray mt-20 tp5-o2o ">'.$obj->render().'</div>';
}

//获取城市的二级分类
function getSeName($path,$model){
    if(!$path){
        return '';
    }
    if(preg_match('/,/',$path)){
        $Path=explode(',',$path);
        $Id=$Path[1];
    }else{
        $Id=$path;
    }
    $name=model($model)->get($Id);
    if ($name) {
        return $name->name;
    }


}
//获取支持门店
function getLocation($ibs,$model){
    if(!$ibs){
        return '';
    }
    if(preg_match('/,/',$ibs)){
        $ibss=explode(',',$ibs);
        foreach ($ibss as $value) {
         echo '<input type="checkbox" checked>'.model($model)->get($value)->name."&nbsp;&nbsp;";
        }
    }

}
//营业时间的处理
/*function gettime($data){
    if(!$data   ){
        return '';
    }
    $time=explode(',',$data);
    $str=date("H:i",$time[0]).'-'.date("H:i",$time[1]);
    return $str;
}*/


function subtext($text, $length)
{
    if(mb_strlen($text, 'utf8') > $length)
        return mb_substr($text, 0, $length, 'utf8').'...';
    return $text;
}
