<?php
namespace app\admin\controller;

use app\admin\model\CatesModel;
use think\Db;
use think\Loader;

class Cates extends Base
{
    public function lists()
    {
        $lists = CatesModel::paginate(10);
        $page = $lists->render();
        $this->assign('page', $page);
        $this->assign('lists', $lists);
        $this->assign('title', '栏目列表');
        return $this->fetch();
    }

    public function add()
    {
        if ($this->request->isPost()) {
            $data = [
                'cate_name' => input('post.cate_name'),
            ];
            $validates = Loader::validate('CatesValidate');
            if ($validates->scene('add')->check($data)) {
                if (Db::name('cates')->insert($data)) {
                    $this->success('添加成功', 'lists');
                } else {
                    $this->error('添加失败');
                }
            } else {
                $this->error($validates->getError());
            }

        } else {
            $this->assign('title', '添加');
            return $this->fetch();
        }
    }

    public function edit()
    {
        if ($this->request->isPost()) {
            $data = [
                'cate_name' => input('post.cate_name'),
                'id' => input('post.id')
            ];

            $validates = Loader::validate('CatesValidate');
            if ($validates->scene('edit')->check($data)) {
                if (Db::name('cates')->where('id', '=', $data['id'])->update($data)) {
                    $this->success('编辑成功', 'lists');
                } else {
                    $this->error('编辑失败');
                }
            } else {
                $this->error($validates->getError());
            }


        } else {
            $id = input('id');
            $listsInfo = Db::name('cates')->where('id', '=', $id)->find();
            $this->assign('lists', $listsInfo);
            $this->assign('title', '编辑');
            return $this->fetch();
        }
    }

    public function delete()
    {
        $id = input('id');

        $res = Db::name('cates')->where('id', '=', $id)->delete();

        if ($res) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }
}