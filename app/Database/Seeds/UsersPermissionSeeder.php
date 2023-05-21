<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsersPermissionSeeder extends Seeder
{
    public function run()
    {
        $factories = [
            [
                'user_id'    => 1,
                'permission_id'     => 1,
            ],
        ];

        $builder = $this->db->table('auth_users_permissions');

        foreach ($factories as $factory) {
            $builder->insert($factory);
        }
    }
}
