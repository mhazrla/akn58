<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Myth\Auth\Password;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $factories = [
            [
                'email'    => 'admin@gmail.com',
                'username'    => 'admin',
                'active'     => 1,
                'password_hash'     => Password::hash('Admin123!', PASSWORD_DEFAULT),
            ],
        ];

        $builder = $this->db->table('users');

        foreach ($factories as $factory) {
            $builder->insert($factory);
        }
    }
}
