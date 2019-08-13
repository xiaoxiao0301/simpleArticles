<?php
namespace app\admin\controller;
use think\Controller;

class Admin extends Controller
{
    public function lists()
    {
        $this->assign('title', '列表');
        return $this->fetch();
    }

    public function add()
    {
        $this->assign('title', '添加');
        return $this->fetch();
    }
}