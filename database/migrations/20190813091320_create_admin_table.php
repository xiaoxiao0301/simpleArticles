<?php

use think\migration\Migrator;
use think\migration\db\Column;

class CreateAdminTable extends Migrator
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
        $table = $this->table('admins');
        // 自动创建id列为自增
        $table->addColumn('username', 'string', ['limit' => 30, 'null' => false, 'comment' => '管理员名称'])
            ->addColumn('password', 'string', ['limit' => 32, 'null' => false, 'comment' => '管理员密码'])
            ->create();
     }

     public function down()
     {
         $this->dropTable('admins');
     }
}
