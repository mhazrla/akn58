<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $factories = [
            [
                'name'    => 'manage-system',
                'description'     => 'managed-system',
            ],
            [
                'name'    => 'managed-profile',
                'description'     => 'managed-profile',
            ],


        ];

        $builder = $this->db->table('auth_permissions');

        foreach ($factories as $factory) {
            $builder->insert($factory);
        }
    }
}
