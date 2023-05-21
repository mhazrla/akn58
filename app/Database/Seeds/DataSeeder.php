<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DataSeeder extends Seeder
{
    public function run()
    {
        $this->call('AdminSeeder');
        $this->call('GroupSeeder');
        $this->call('PermissionSeeder');
        $this->call('UsersPermissionSeeder');
        $this->call('GroupUserSeeder');
        $this->call('GroupPermissionSeeder');
    }
}
