<?php
namespace app\admin\controller;
use app\admin\model\AdminModel;
use think\Controller;
use think\Db;
use think\Loader;
use think\Validate;

class Admin extends Controller
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
        return $this->fetch();
    }
}