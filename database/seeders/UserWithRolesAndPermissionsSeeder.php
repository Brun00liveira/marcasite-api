<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserWithRolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Criar a permissão
        $permission = Permission::firstOrCreate([
            'name' => 'create courses',
            'guard_name' => 'api'
        ]);

        // Criar os papéis (roles)
        $roles = [
            ['name' => 'admin', 'guard_name' => 'api'],
            ['name' => 'user', 'guard_name' => 'api']
        ];

        // Criar os papéis e associar a permissão ao papel de admin
        foreach ($roles as $roleData) {
            $role = Role::firstOrCreate($roleData);

            // Associar permissão ao papel 'admin'
            if ($role->name === 'admin') {
                $role->givePermissionTo($permission);
            }
        }

        // Criar o usuário admin e associar o papel e a permissão
        $user = User::firstOrCreate(
            ['email' => 'admin@marcacurso.com'],
            [
                'name' => 'John Doe',
                'phone' => '419911445756',
                'password' => Hash::make('SenhaForte123'),
            ]
        );

        // Associar o papel de admin ao usuário
        $adminRole = Role::where('name', 'admin')->first();
        $user->assignRole($adminRole);

        // Associar a permissão ao usuário
        $user->givePermissionTo($permission);

        $this->command->info('Usuário, Permissão e Role criados com sucesso!');
    }
}
