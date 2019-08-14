<?php
namespace app\admin\validate;

use think\Validate;

class AdminValidate extends Validate
{
    protected $rule = [
        'username' => 'require|min:6',
        'password' => 'require|min:6',
        'id'=> 'require',
    ];

    protected $message = [
        'username.require' => '管理员名称必须',
        'username.min' => '名称不能少于6个字符',
        'password.min' => '密码不能少于6个字符',
        'password.require' => '密码不能为空',
    ];

    protected $scene = [
        // 添加
        'add' => ['username', 'password'],
        // 编辑
        'edit' => ['id','username', 'password'],
        // 删除
        'delete' => ['id',]
    ];
}