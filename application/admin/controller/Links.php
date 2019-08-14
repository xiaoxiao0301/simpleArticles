<?php
namespace app\admin\controller;

use app\admin\model\LinksModel;
use think\Controller;
use think\Db;
use think\Loader;

class Links extends Controller
{
    public function lists()
    {
        $lists = LinksModel::paginate(10);
        $page = $lists->render();
        $this->assign('lists', $lists);
        $this->assign('page', $page);
        $this->assign('title', '友情链接列表');
        return $this->fetch();
    }

    public function add()
    {
        if (request()->isPost()) {
            $data = [
                'title' => input('post.title'),
                'url' => input('post.url'),
                'desc' => input('post.desc'),
            ];
            $validates = Loader::validate('LinksValidate');
            if ($validates->scene('add')->check($data)) {
                if (Db::name('links')->insert($data)) {
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
        if (request()->isPost()) {
            $data = [
                'title' => input('post.title'),
                'url' => input('post.url'),
                'desc' => input('post.desc'),
                'id' => input('post.id')
            ];

            $validates = Loader::validate('LinksValidate');
            if (!$validates->scene('edit')->check($data)) {
                $this->error($validates->getError());
            }

            if (Db::name('links')->where('id', '=', $data['id'])->update($data)) {
                $this->success('编辑成功', 'lists');
            } else {
                $this->error('编辑失败');
            }
        } else {
            $id = input('id');
            $listsInfo = Db::name('links')->where('id', '=', $id)->find();
            $this->assign('lists', $listsInfo);
            $this->assign('title', '编辑');
            return $this->fetch();
        }

    }

    public function delete()
    {
        $id = input('id');

        $res = Db::name('links')->where('id', '=', $id)->delete();

        if ($res) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }
}