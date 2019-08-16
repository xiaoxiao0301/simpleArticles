<?php

namespace app\admin\controller;

use app\admin\model\AdminModel;
use think\captcha\Captcha;
use think\Controller;

class Login extends Controller
{
    public function login()
    {
        return $this->fetch();
    }

    public function handleLogin()
    {
        $codes = input('post.code');
        $username = input('post.username');
        $password = input('post.password');

        // 验证码校验
        $captcha = new Captcha();
        $check = $captcha->check($codes);
        if (!$check) {
            $this->error('验证码输入错误');
        }

        $adminInfo = AdminModel::get(['username' => $username, 'password' => md5($password)]);
        if (!$adminInfo) {
            $this->error('用户名或密码错误');
        }

        session('adminName', $adminInfo->username);
        session('adminId', $adminInfo->id);
        $this->redirect('admin/index/index');
    }

    public function logout()
    {
        session(null);
        $this->success('退出成功','login');
    }
}