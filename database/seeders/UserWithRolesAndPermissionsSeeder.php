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
        $permission = Permission::firstOrCreate(['name' => 'create courses']);

        // Criar a Role e associar a permissão
        $role = Role::firstOrCreate(['name' => 'admin']);
        $role->givePermissionTo($permission);

        // Criar o Usuário e associar a Role
        $user = User::firstOrCreate(
            ['email' => 'brunobromo321@gmail.com'],
            [
                'name' => 'talia',
                'phone' => '129911445756',
                'password' => Hash::make('SenhaForte123')
            ]
        );

        // Atribuir a Role ao Usuário
        $user->assignRole($role);

        $user->givePermissionTo($permission);

        $this->command->info('Usuário, Permissão e Role criados com sucesso!');
    }
}
