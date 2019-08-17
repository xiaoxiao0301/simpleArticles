<?php
namespace app\index\controller;


use app\admin\model\ArticlesModel;
use think\Db;

class Index extends Base
{
    public function index()
    {
        $articles = ArticlesModel::paginate('10');
        foreach ($articles as $k => &$v) {
            $v->keywords = explode(',', $v->keywords);
        }
        $page = $articles->render();
        $this->assign('articles', $articles);
        $this->assign('page', $page);
        $this->assign('cate_name', '首页');
        $this->assign('title', '首页');
        return $this->fetch();
    }
}
