<?php

use think\migration\Migrator;
use think\migration\db\Column;

class CreateLinksTable extends Migrator
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
        $table = $this->table('links');
        $table->addColumn('title', 'string', ['limit' => 30, 'null' => false, 'comment' => '链接标题'])
            ->addColumn('url', 'string', ['limit' => 60, 'null' => false, 'comment' => '链接地址'])
            ->addColumn('desc', 'string', ['limit' => 255, 'null' => false, 'comment' => '链接说明'])
            ->create();
    }

    public function down()
    {
        $this->dropTable('links');
    }
}
