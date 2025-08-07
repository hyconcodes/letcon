<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $roles = [
        //     'super-admin',
        //     'admin',
        //     'member',
        // ];

        // foreach ($roles as $role) {
        //     Role::create(['name' => $role]);
        // }

        $permissions = [
            // 'view dashboard',

            // 'create.member',
            // 'view.member',
            // 'update.member',
            // 'delete.member',

            // 'create.admin',
            // 'view.admin',
            // 'update.admin',
            // 'delete.admin',

            // 'create.roles',
            // 'view.roles',
            // 'update.roles',
            // 'delete.roles',

            'view.wallet',
            'fund.wallet',
            'withdraw.wallet',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
        // $admin = Role::findByName('super-admin');
        // $admin->givePermissionTo($permissions);

        // $user = Role::findByName('admin');
        // $user->givePermissionTo('view.member');
        // $user->givePermissionTo('create.member');
        // $user->givePermissionTo('update.member');
        // $user->givePermissionTo('delete.member');

        // $user = Role::findByName('member');
        // $user->givePermissionTo('view.member');

        // $member = User::where('email', 'aladeyeluadesola6@gmail.com')->first();
        // $member->assignRole('super-admin');
    }
}
