<?php

namespace app\admin\controller;

use think\Controller;

class Login extends Controller
{
    public function login()
    {

    }

    public function handleLogin()
    {

    }

    public function logout()
    {
        session(null);
        $this->redirect('login/login');
    }
}