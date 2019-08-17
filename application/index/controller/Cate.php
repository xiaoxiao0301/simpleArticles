<?php
namespace app\index\controller;

use app\admin\model\ArticlesModel;
use app\admin\model\CatesModel;

class Cate extends Base
{
    public function index()
    {
        $id = input('id');
        $cate_name = input('cate_name');
        $this->assign('cate_name', $cate_name);
        $articsInfo = ArticlesModel::where(['cate_id' => $id])->paginate('10');
        foreach ($articsInfo as $k => &$v) {
            $v->keywords = explode(',', $v->keywords);
        }
        $page = $articsInfo->render();
        $this->assign('page', $page);
        $this->assign('articles', $articsInfo);
        $this->assign('title', '列表页');
        return $this->fetch();
    }
}
