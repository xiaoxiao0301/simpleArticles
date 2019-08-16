<?php


namespace app\admin\validate;

use think\Validate;

class CatesValidate extends Validate
{
    protected $rule = [
        'cate_name' => 'require|unique:cates',
        'id'=> 'require',
    ];

    protected $message = [
        'cate_name.require' => '栏目名称必须',
        'cate_name.unique' => '栏目名称必须唯一',
        'id.require' => '编辑/删除的列不合法',
    ];

    protected $scene = [
        // 添加
        'add' => ['cate_name'],
        // 编辑
        'edit' => ['id','cate_name'],
        // 删除
        'delete' => ['id',]
    ];
}