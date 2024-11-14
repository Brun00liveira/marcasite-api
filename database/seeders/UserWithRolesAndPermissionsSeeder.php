<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        // Criar a Permissão
        $permission = Permission::firstOrCreate([
            'name' => 'create courses',
            'guard_name' => 'api'
        ]);

        // Criar a Role com o guard 'api' e associar a permissão
        $role = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'api'
        ]);
        $role->givePermissionTo($permission);

        // Criar o Usuário e associar a Role
        $user = User::firstOrCreate(
            ['email' => 'admin@marcacurso.com'],
            [
                'name' => 'John Doe',
                'phone' => '419911445756',
                'password' => Hash::make('SenhaForte123')
            ]
        );

        $user->assignRole($role);

        $user->givePermissionTo($permission);

        $this->command->info('Usuário, Permissão e Role criados com sucesso!');
    }
}
