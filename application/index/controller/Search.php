<?php
namespace app\index\controller;

use think\Db;

class Search extends Base
{
    public function index()
    {
        $search = input('keywords');
        if ($search) {
            $map ['keywords'] = ['like', '%'.$search.'%'];
        } else {
            $map ['keywords'] = ['like', '%%'];
        }
        $searchs = Db::name('articles')->where($map)->paginate(10, false, $config=['query' => ['keywords' => $search]])->each(function ($item, $key) {
            $name = Db::name('cates')->where('id', '=', $item['cate_id'])->value('cate_name');
            $item['cate_name'] = $name;
            $item['keywords'] = explode(',', $item['keywords']);
            return $item;
        });
        $page = $searchs->render();
        $this->assign('keywords', $search);
        $this->assign('searchInfo', $searchs);
        $this->assign('page', $page);
        $this->assign('cate_name', '');
        $this->assign('title', '搜索');
        return $this->fetch();
    }

}