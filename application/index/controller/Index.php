<?php
namespace app\index\controller;

use think\Controller;

class Index extends Controller
{
    public function index()
    {
        $this->assign('title', '首页');
        return $this->fetch();
    }
}
