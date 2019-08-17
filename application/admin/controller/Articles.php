<?php
namespace app\admin\controller;

use app\admin\model\ArticlesModel;
use app\admin\model\CatesModel;
use think\Db;
use think\Loader;

class Articles extends Base
{
    public function lists()
    {
        /*
         * 有关联关系表的数据查询解决：
         *  1. 模型的关联模型
         *  2. 多表连接查询
         *  3. 分开查询，结果转换
         */

        /**
        $cates = CatesModel::all(null, 'articles');
        halt(collection($cates)->toArray()['3']);
        array (size=3)
            'id' => int 4
            'cate_name' => string '感悟' (length=6)
            'articles' =>
            array (size=1)
                 0 =>
                array (size=11)
                    'id' => int 1
                    'title' => string '成功人懂得熬，失败人懂得逃' (length=39)
                    'author' => string '网络整理' (length=12)
                    'desc' => string '励志文章' (length=12)
                    'keywords' => string '励志' (length=6)
                    'content' => string '<p style="padding: 0px; margin-top: 20px; margin-bottom: 20px; color: rgb(51, 51, 51); font-family: Verdana, Arial, Tahoma; font-size: 14px; text-indent: 28px; white-space: normal; background-color: rgb(255, 255, 255);">为什么一个老板再难，也不会轻言<a href="http://www.lzrsh.com/huati/fangqi" target="_blank" class="infotextkey" style="padding: 0px; margin: 0px; color: rgb(51, 51, 51); text-decoration-line: none; font-family: arial;">放弃</a>？而一个员工做得不顺就想逃走？</p><'... (length=7564)
                    'pic' => string '/upload/article/8a7e7ea05b51fea8fb784244e1b32057.jpg' (length=52)
                    'click' => int 0
                    'state' => int 0
                    'time' => int 1565919449
                    'cate_id' => int 4

        $articles = ArticlesModel::all(null, 'cates');
        halt(collection($articles)->toArray());
        array (size=1)
            0 =>
                array (size=12)
                    'id' => int 1
                    'title' => string '成功人懂得熬，失败人懂得逃' (length=39)
                    'author' => string '网络整理' (length=12)
                    'desc' => string '励志文章' (length=12)
                    'keywords' => string '励志' (length=6)
                    'content' => string '<p style="padding: 0px; margin-top: 20px; margin-bottom: 20px; color: rgb(51, 51, 51); font-family: Verdana, Arial, Tahoma; font-size: 14px; text-indent: 28px; white-space: normal; background-color: rgb(255, 255, 255);">为什么一个老板再难，也不会轻言<a href="http://www.lzrsh.com/huati/fangqi" target="_blank" class="infotextkey" style="padding: 0px; margin: 0px; color: rgb(51, 51, 51); text-decoration-line: none; font-family: arial;">放弃</a>？而一个员工做得不顺就想逃走？</p><'... (length=7564)
                    'pic' => string '/upload/article/8a7e7ea05b51fea8fb784244e1b32057.jpg' (length=52)
                    'click' => int 0
                    'state' => int 0
                    'time' => int 1565919449
                    'cate_id' => int 4
                    'cates' =>
                        array (size=2)
                            'id' => int 4
                            'cate_name' => string '感悟' (length=6)
        **/

        // 所有的栏目分类
//        $allCateInfo = collection($this->getAllCate())->toArray();
//        $this->assign('cate_info', $this->convertKeyVlaues($allCateInfo, 'id'));
        $articlesInfo = ArticlesModel::paginate(10);
        $page = $articlesInfo->render();
        $this->assign('lists', $articlesInfo);
        $this->assign('page', $page);
        $this->assign('title', '文章列表');
        return $this->fetch();
    }

    public function add()
    {
        if ($this->request->isPost()) {

            // 文件缩略图不能为空
            $files = $this->request->file('pic');
            if (!$files) {
                $this->error('文章缩略图不能为空');
            }

            $savePath = UPLOAD_PATH.'article/';
            if (!($_exists = file_exists($savePath))) {
                mkdir($savePath,0777,true);
            }
            $file = $files->rule(function ($files) {
                return md5(mt_rand());
            })->move($savePath);
            if ($file) {
                $filename = $file->getFilename();
                $new_name = '/'.$savePath.$filename;
            } else {
                $this->error($file->getError());//上传错误提示错误信息
            }


            $data = [
                'title' => input('post.title'),
                'author' => input('post.author'),
                'desc' => input('post.desc'),
                'keywords' => str_replace('，',',',input('post.keywords')),
                'content' => input('post.content'),
                'cate_id' => input('post.cate_id'),
                'pic' => $new_name
            ];

            $validates = Loader::validate('ArticlesValidate');
            if (!$validates->scene('add')->check($data)) {
                $this->error($validates->getError());
            }
            if (input('post.state') == 'on') {
                $data['state'] = 1;
            } else {
                $data['state'] = 0;
            }
            $data['time'] = time();

            if (Db::name('articles')->insert($data)) {
                $this->success('添加成功', 'lists');
            } else {
                $this->error('添加失败');
            }
        }
        $allCateInfo = collection($this->getAllCate())->toArray();
        $this->assign('cate_info', $allCateInfo);
        $this->assign('title', '添加');
        return $this->fetch();
    }

    public function edit()
    {
        if ($this->request->isPost()) {

            $pic = input('post.pic');
            // 文件缩略图不能为空
            $files = $this->request->file('pic');

            if ($pic && $files) {
                $savePath = UPLOAD_PATH.'article/';
                if (!($_exists = file_exists($savePath))) {
                    mkdir($savePath,0777,true);
                }
                $file = $files->rule(function ($files) {
                    return md5(mt_rand());
                })->move($savePath);
                if ($file) {
                    $filename = $file->getFilename();
                    $new_name = '/'.$savePath.$filename;
                } else {
                    $this->error($file->getError());//上传错误提示错误信息
                }
            } else {
                $new_name = $pic;
            }

            $data = [
                'title' => input('post.title'),
                'author' => input('post.author'),
                'desc' => input('post.desc'),
                'keywords' => str_replace('，',',',input('post.keywords')),
                'content' => input('post.content'),
                'cate_id' => input('post.cate_id'),
                'id' => input('id'),
                'pic' => $new_name
            ];
            $validates = Loader::validate('ArticlesValidate');
            if (!$validates->scene('edit')->check($data)) {
                $this->error($validates->getError());
            }
            if (input('post.state') == 'on') {
                $data['state'] = 1;
            } else {
                $data['state'] = 0;
            }
            if (Db::name('articles')->where('id', '=', $data['id'])->update($data)) {
                $this->success('编辑成功', 'lists');
            } else {
                $this->error('编辑失败');
            }
        }
        $id = input('id');
        $listsInfo = Db::name('articles')->where('id', '=', $id)->find();
        $this->assign('lists', $listsInfo);
        $allCateInfo = collection($this->getAllCate())->toArray();
        $this->assign('cate_info', $allCateInfo);
        $this->assign('title', '编辑');
        return $this->fetch();
    }

    public function delete()
    {
        $id = input('id');
        $res = ArticlesModel::where('id', '=', $id)->delete();
        if ($res) {
            $this->success('删除成功', 'lists');
        } else {
            $this->error('稍后再试!');
        }
    }

    public function recommend()
    {
        $id = input('id');
        $res = ArticlesModel::where('id', '=', $id)->update(['state' => 1]);
        if ($res) {
            $this->success('推荐成功', 'lists');
        } else {
            $this->error('稍后再试!');
        }
    }


    private function getAllCate()
    {
        $catsInfo = CatesModel::all();
        return $catsInfo;
    }

    /**
     * 将数据库中查出的列表以指定的 id 作为数组的键名
     * @param $data
     * @param $keyName
     */
    private function convertKeyVlaues($data, $keyName)
    {
        $result = [];

        foreach ($data as $key => $value) {

           $result[$value[$keyName]] = $value;
        }
        return $result;

    }
}