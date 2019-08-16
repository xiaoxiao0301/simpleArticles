<?php
namespace app\admin\model;

use think\Model;

class ArticlesModel extends Model
{
    public $table = 'xiaoxiao_articles';

    public function cates()
    {
        // 第一个参数是关联模型名称, 第二个参数是当前模型类所属表的外键, 第三个参数是关联模型类所属表的主键
        return $this->belongsTo('CatesModel', 'cate_id', 'id');
    }
}