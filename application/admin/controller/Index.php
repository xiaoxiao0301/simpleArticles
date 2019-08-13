<?php

namespace app\admin\controller;

use think\Controller;

class Index extends Controller
{
    public function index()
    {
        $this->assign('title', '功能页');
        return $this->fetch();
    }
}