<?php
namespace app\admin\validate;

use think\Validate;

class ArticlesValidate extends Validate
{
    protected $rule = [
        'title' => 'require',
        'author' => 'require',
        'desc' => 'require',
        'keywords' => 'require',
        'content' => 'require',
        'pic' => 'require',
        'cate_id' => 'require',
        'id'=> 'require',
    ];

    protected $message = [
        'title.require' => '文章标题必须',
        'author.require' => '文章作者必须',
        'desc.require' => '文章简介必须',
        'keywords.require' => '文章关键字必须',
        'content.require' => '文章内容必须',
        'pic.require' => '文章缩略图必须',
        'cate_id.require' => '文章所属栏目必须',
    ];

    protected $scene = [
        // 添加
        'add' => ['title', 'author', 'desc', 'keywords', 'content', 'pic', 'cate_id'],
        // 编辑
        'edit' => ['id', 'title', 'author', 'desc', 'keywords', 'content', 'pic', 'cate_id'],
        // 删除
        'delete' => ['id', 'title', 'author', 'desc', 'keywords', 'content', 'pic', 'cate_id']
    ];
}