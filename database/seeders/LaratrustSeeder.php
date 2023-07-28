<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class LaratrustSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->truncateLaratrustTables();

        $config = Config::get('rolepermission_seeder.roles_structure');

        if ($config === null) {
            $this->command->error('The configuration has not been published. Did you run `php artisan vendor:publish --tag="laratrust-seeder"`');
            $this->command->line('');

            return false;
        }

        foreach ($config as $user_role => $modules) {
            // Create a new role
            $role = \App\Models\Role::firstOrCreate([
                'name' => $user_role,
                'display_name' => ucwords(str_replace('_', ' ', $user_role)),
                'description' => ucwords(str_replace('_', ' ', $user_role)),
                'user_group' => 'System Administration',
            ]);

            $this->command->info('Creating Role '.strtoupper($user_role));
            $role_permissions = [];
            // Reading role permission modules
            foreach ($modules as $module => $permission_operations) {

                foreach ($permission_operations as $operation => $permissions) {
                    foreach ($permissions as $permission) {
                        $role_permissions[] = \App\Models\Permission::firstOrCreate([
                            'name' => $permission,
                            'display_name' => ucfirst(str_replace('_', ' ', $permission)),
                            'description' => ucfirst(str_replace('_', ' ', $permission)),
                            'target_module' => $module,
                            'operation' => $operation,
                        ])->id;
    
                        $this->command->info('Creating Permission -->'.$permission);
                    }
                }
              
            }

            // Attach all permissions to the role
            $role->permissions()->sync($role_permissions);

            if (Config::get('rolepermission_seeder.create_users')) {
                $this->command->info("Creating '{$user_role}' user");
                // Create default user for each role
                $user = \App\Models\User::create([
                    'category' => 'System-Admin',
                    'name' => ucwords(str_replace('_', ' ', $user_role)),
                    'password_updated_at' => now(),
                    'email' => Str::lower($user_role).'@merp.com',
                    'email_verified_at' => now(),
                    'password' => bcrypt('admin@merp'),
                    'is_admin' => true,
                    'remember_token' => Str::random(10),
                ]);
                $user->attachRole($role);
            }
        }

        if (Config::get('rolepermission_seeder.seed_default_roles')) {
            $default_roles = Config::get('rolepermission_seeder.default_roles');

            if ($default_roles === null) {
                $this->command->error('The configuration for default roles and permissions not found');
                $this->command->line('');

                return false;
            }

            foreach ($default_roles as $user_group => $user_group_roles) {
                // Create a new role
                foreach ($user_group_roles as $user_group_role => $perms) {

                $role = \App\Models\Role::firstOrCreate([
                    'name' => $user_group_role,
                    'display_name' => ucwords(str_replace('_', ' ', $user_group_role)),
                    'description' => ucwords(str_replace('_', ' ', $user_group_role)),
                    'user_group' => $user_group,
                ]);

                $this->command->info('Creating Default Role '.strtoupper($user_group_role));
                $default_role_permissions = \App\Models\Permission::whereIn('name', $perms)->get()->pluck('id')->toArray();

                $role->permissions()->sync($default_role_permissions);
                $this->command->info('Assigned defaulted permissions to '.strtoupper($user_group_role));
            }
   
            }
        }
    }

    /**
     * Truncates all the laratrust tables and the users table
     *
     * @return  void
     */
    public function truncateLaratrustTables()
    {
        $this->command->info('Truncating User, Role and Permission tables');
        Schema::disableForeignKeyConstraints();

        if (Config::get('rolepermission_seeder.truncate_pivot_tables')) {
            DB::table('permission_role')->truncate();
            DB::table('permission_user')->truncate();
            DB::table('role_user')->truncate();
        }

        if (Config::get('rolepermission_seeder.truncate_tables')) {
            DB::table('roles')->truncate();
            DB::table('permissions')->truncate();

            if (Config::get('rolepermission_seeder.create_users')) {
                $usersTable = (new \App\Models\User)->getTable();
                DB::table($usersTable)->truncate();
            }
        }

        Schema::enableForeignKeyConstraints();
    }
}
