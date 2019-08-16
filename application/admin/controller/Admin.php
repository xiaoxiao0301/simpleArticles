<?php
namespace app\admin\controller;
use app\admin\model\AdminModel;
use think\Db;
use think\Loader;

class Admin extends BaseController
{
    public function lists()
    {
        $lists = AdminModel::paginate(2);
        $page = $lists->render();
        $this->assign('lists', $lists);
        $this->assign('page', $page);
        $this->assign('title', '管理员列表');
        return $this->fetch();
    }

    public function add()
    {
        if (request()->isPost()) {
            $data = [
                'username' => input('post.username'),
                'password' => input('post.password')
            ];

            $validates = Loader::validate('AdminValidate');
            if ($validates->scene('add')->check($data)) {
                $data['password'] = md5($data['password']);
            } else {
                $this->error($validates->getError());
            }

            if (Db::name('admins')->insert($data)) {
                $this->success('添加成功', 'lists');
            } else {
                $this->error('添加失败');
            }
        } else {
            $this->assign('title', '添加');
            return $this->fetch();
        }

    }

    public function edit()
    {
        if (request()->isPost()) {
            $data = [
                'username' => input('post.username'),
                'password' => input('post.password'),
                'id' => input('post.id')
            ];

            $validates = Loader::validate('AdminValidate');
            if ($validates->scene('edit')->check($data)) {
                $data['password'] = md5($data['password']);
            } else {
                $this->error($validates->getError());
            }

            if (Db::name('admins')->where('id', '=', $data['id'])->update($data)) {
                $this->success('编辑成功', 'lists');
            } else {
                $this->error('编辑失败');
            }
        } else {
            $id = input('id');
            $listsInfo = Db::name('admins')->where('id', '=', $id)->find();
            $this->assign('lists', $listsInfo);
            $this->assign('title', '编辑');
            return $this->fetch();
        }

    }

    public function delete()
    {
        $id = input('id');

        if ($id == 1) {
            $this->error('不能删除初始管理员信息');
        }

        $res = Db::name('admins')->where('id', '=', $id)->delete();

        if ($res) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }

    public function change()
    {
        $this->assign('id', session('adminId'));
        $this->assign('title', '修改密码');
        return $this->fetch();
    }

    public function updatePassword()
    {
        $id = input('post.id');
        $passWord = input('post.password');
        $res = AdminModel::where('id', '=', $id)->update(['password' => md5($passWord)]);
        if ($res) {
            session(null);
            $this->success('更新成功，请使用新密码重新登录', 'admin/login/login');
        } else {
            $this->error('更新失败，稍后再试');
        }
    }
}