<?php
namespace app\index\controller;

use think\Controller;

class Article extends Controller
{
    public function index()
    {
        $this->assign('title', '文章页');
        return $this->fetch();
    }
}
