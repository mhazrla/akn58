<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GroupSeeder extends Seeder
{
    public function run()
    {
        $factories = [
            [
                'name'    => 'admin',
                'description'     => 'Admin',
            ],
            [
                'name'    => 'user',
                'description'     => 'User',
            ],


        ];

        $builder = $this->db->table('auth_groups');

        foreach ($factories as $factory) {
            $builder->insert($factory);
        }
    }
}
