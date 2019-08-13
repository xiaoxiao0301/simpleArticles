<?php

use think\migration\Migrator;
use think\migration\db\Column;

class CreateArticleTable extends Migrator
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function up()
    {
        $table = $this->table('articles');
        $table->addColumn('title', 'string', ['limit' => 60, 'null' => false, 'comment' => '文章标题'])
            ->addColumn('author', 'string', ['limit' => 30, 'null' => false, 'comment' => '文章作者'])
            ->addColumn('desc', 'string', ['limit' => 255, 'null' => false, 'comment' => '文章简介'])
            ->addColumn('keywords', 'string', ['limit' => 255, 'null' => false, 'comment' => '文章关键词'])
            ->addColumn('content', 'text', ['null' => false, 'comment' => '文章内容'])
            ->addColumn('pic', 'string', ['limit' => '255', 'null' => false, 'comment' => '缩略图'])
            ->addColumn('click', 'integer', ['limit' => 10, 'null' => false, 'default' => 0, 'comment' => '点击数'])
            ->addColumn('state', 'integer', ['limit' => 1, 'null' => false, 'default' => 0, 'comment' => '0:不推荐 1：推荐'])
            ->addColumn('time', 'integer', ['limit' => 11, 'null' => false, 'comment' => '发布时间'])
            ->addColumn('cate_id', 'integer', ['limit' => 11, 'null' => false, 'comment' => '所属栏目'])
            ->create();
    }

    public function down()
    {
        $this->dropTable('articles');
    }
}
