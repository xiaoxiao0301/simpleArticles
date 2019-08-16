<?php


namespace app\admin\controller;


use think\Controller;
use think\Request;

class BaseController extends Controller
{

    public function __construct(Request $request = null)
    {
        parent::__construct($request);

        if (!session('adminName')) {
            $this->error('请先登录!', 'admin/login/login');
        }

    }
}