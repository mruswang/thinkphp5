<?php
/**
 * Created by PhpStorm.
 * User: wangsir
 * Date: 2017/5/30
 * Time: 21:23
 */

namespace app\common\validate;
use think\Validate;
class Bis extends Validate{
    protected $rule=[
        'name'=>'require|max:25',
        'email'=>'email',
        'logo'=>'require',
        'city_id'=>'require',
        'bank_info'=>'require',
        'bank_name'=>'require',
        'bank_user'=>'require',
        'faren'=>'require',
        'faren_tel'=>'require',
        'licence_logo'=>'require',
        'tel'=>'require',
        'contact'=>'require',
        'category_id'=>'require',
        'se_category_id'=>'require',
        'address'=>'require',
        'open_time'=>'require',
        'username'=>'require',
        'password'=>'require',
        'description'=>'require',
        'content'=>'require',
    ];

    /*场景设置*/
    protected $scene=[
        'basic'=>['name','email','logo','city_id','bank_info','bank_name','bank_user','faren','faren_tel'],//基本信息
        'headquarters'=>['tel','contact','category_id','se_category_id','address','open_time'],//总店信息
        'account'=>['username','password'],//用户信息
    ];

}