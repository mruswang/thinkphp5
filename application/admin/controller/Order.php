<?php
namespace app\admin\controller;
use think\Controller;

class Order extends Controller
{
    public function o_list(){
        return  $this->fetch('admin-role');
    }
    public function o_list_add(){
        return  $this->fetch('admin-role-add');
    }

}
