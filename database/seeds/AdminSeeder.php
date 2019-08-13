<?php

use think\migration\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $data = [
            'username' => 'admin',
            'password' => md5('secret')
        ];

        $this->table('admins')->insert($data)->save();
    }
}