<?php
namespace app\common\model;
use think\Model;
class User extends BaseModel
{
    public function add($data = []) {
        // 如果提交的数据不是数组
        if(!is_array($data)) {
            exception('传递的数据不是数组');
        }

        $data['status'] = 1;
        return $this->data($data)->allowField(true)
            ->save();
    }
}

