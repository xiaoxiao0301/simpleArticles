<?php
namespace app\index\controller;

use app\admin\model\CatesModel;
use think\Controller;
use think\Db;

class Base extends Controller
{
    public function _initialize()
    {
        $this->hotClick();
        $cates = CatesModel::all();
        $this->assign('cates', $cates);
    }

    public function hotClick()
    {
        $articles = Db::name('articles')->order('click', 'desc')->limit(4)->select();
        foreach ($articles as $k => &$v) {
            $name = Db::name('cates')->where('id', '=', $v['cate_id'])->value('cate_name');
            $v['cate_name'] = $name;
        }
        $this->assign('hotArticles', $articles);
    }
}