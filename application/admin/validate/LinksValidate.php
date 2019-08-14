<?php


namespace app\admin\validate;


use think\Validate;

class LinksValidate extends Validate
{
    protected $rule = [
        'title' => 'require|min:6',
        'url' => 'require|min:6|url',
        'desc' => 'require|min:6',
        'id'=> 'require',
    ];

    protected $message = [
        'title.require' => '链接标题必须',
        'url.require' => '链接地址必须',
        'desc.require' => '链接说明必须',
        'title.min' => '链接标题不能少于6个字符',
        'url.min' => '链接地址不能少于6个字符',
        'desc.min' => '链接说明不能为空',
        'url.url' => '链接地址非法',
    ];

    protected $scene = [
        // 添加
        'add' => ['title', 'url', 'desc'],
        // 编辑
        'edit' => ['id','title', 'url', 'desc'],
        // 删除
        'delete' => ['id',]
    ];
}