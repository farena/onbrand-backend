<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        DB::table('users')->insert([
            [ 
                'name' => 'Submitter',
                'email' => 'submitter@onbrand.test',
                'password' => Hash::make('password'),
                'role_id' => 1,
            ],
            [ 
                'name' => 'Approver',
                'email' => 'approver@onbrand.test',
                'password' => Hash::make('password'),
                'role_id' => 2,
            ],
            [ 
                'name' => 'Client',
                'email' => 'client@onbrand.test',
                'password' => Hash::make('password'),
                'role_id' => 3,
            ],
        ]);
    }
}
