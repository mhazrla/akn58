<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GroupPermissionSeeder extends Seeder
{
    public function run()
    {
        $factories = [
            [
                'group_id'    => 1,
                'permission_id'     => 1,
            ],
            [
                'group_id'    => 1,
                'permission_id'     => 2,
            ],
            [
                'group_id'    => 2,
                'permission_id'     => 2,
            ],
        ];

        $builder = $this->db->table('auth_groups_permissions');

        foreach ($factories as $factory) {
            $builder->insert($factory);
        }
    }
}
