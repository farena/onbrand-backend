<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->delete();
        DB::table('roles')->insert([
            [ 'name' => 'Submitter' ],
            [ 'name' => 'Approver' ],
            [ 'name' => 'Client' ],
        ]);
    }
}
