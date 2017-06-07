<?php
/**
 * Created by PhpStorm.
 * User: wangsir
 * Date: 2017/5/24
 * Time: 22:04
 */
 function show($status,$message='',$data=[]){
    return [

        'status'=>intval($status),
        'message'=>$message,
        'data'=>$data,
    ];

 }