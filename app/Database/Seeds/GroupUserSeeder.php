<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GroupUserSeeder extends Seeder
{
    public function run()
    {
        $factories = [
            [
                'group_id'    => 1,
                'user_id'     => 1,
            ],
        ];

        $builder = $this->db->table('auth_groups_users');

        foreach ($factories as $factory) {
            $builder->insert($factory);
        }
    }
}
