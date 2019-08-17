<?php
namespace app\index\controller;

use app\admin\model\ArticlesModel;
use think\Db;

class Article extends Base
{
    public function index()
    {
        $id = input('id');
        // 点击计数
        ArticlesModel::where('id', '=', $id)->setInc('click',1);
        $cate_name = input('cate_name');
        $articleInfo = ArticlesModel::get(['id' => $id]);
        $articleInfo['keywords'] = explode(',', $articleInfo['keywords']);
        // 推荐文章
        $resAr = Db::name('articles')->where(['cate_id' => $articleInfo['cate_id'], 'state' => 1])->limit(3)->select();
        $this->assign('resAr', $resAr);
        $this->assign('cate_name', $cate_name);
        $this->assign('articles', $articleInfo);
        $this->assign('releationArticles', $this->getRelationArticles($articleInfo['keywords'], $id));
        $this->assign('title', '文章页');
        return $this->fetch();
    }

    private function getRelationArticles($keywords, $id)
    {
        static $res = [];
        foreach ($keywords as $k => $v) {
            $map ['keywords'] = ['like', '%'.$v.'%'];
            $map['id'] = ['<>', $id];
            $searchs = Db::name('articles')->where($map)->limit(3)->select();
            $res = array_merge($res, $searchs);
        }
        if ($res) {
            $res = arrs_unique($res);
        }
        return $res;
    }


}
