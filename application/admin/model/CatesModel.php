<?php
namespace app\admin\model;

use think\Model;

class CatesModel extends Model
{
    public $table = 'xiaoxiao_cates';

    public function articles()
    {
        // 第一个参数是关联模型的类名, 第二个参数是关联模型类所属表的外键,第三个参数是关联表的外键关联到当前模型所属表的哪个字段
        return $this->hasMany('ArticlesModel','cate_id', 'id');
    }
}