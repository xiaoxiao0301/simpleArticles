<?php
namespace app\index\controller;

use think\Controller;

class Cate extends Controller
{
    public function index()
    {
        $this->assign('title', '列表页');
        return $this->fetch();
    }
}
