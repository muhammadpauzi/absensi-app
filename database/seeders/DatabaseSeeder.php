<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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

        // $this->call(RoleSeeder::class);

        // \App\Models\User::factory()->create([
        //     'name' => 'Muhammad Pauzi (Admin)',
        //     'email' => 'admin@gmail.com',
        //     'role_id' => Role::where('name', 'admin')->first('id')
        // ]);
        \App\Models\User::factory(1)->create([
            'role_id' => Role::where('name', 'operator')->first('id')
        ]);
        \App\Models\User::factory(10)->create([
            'role_id' => Role::where('name', 'user')->first('id')
        ]);
    }
}
