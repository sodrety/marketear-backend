<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(ChannelSeeder::class);
        $this->call(PermissionRoleTableSeeder::class);
        $this->call(SubscriptionPlanSeeder::class);
        
        $user = \App\Models\User::create([
            'name' => 'superadmin',
            'email' => 'admin@mail.com', 
            'password' => bcrypt('password'),
            'email_verified_at' => \Carbon\Carbon::now(),
            'role_id' => 1,
            'status' => 1
        ]);
            
        \App\Models\Workspace::create([
            'name' => 'Main Space',
            'user_id' => $user->id
        ]);
    }
}
