<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class userRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = 'user_roles';
        \DB::table($table)->delete();
        App\Models\user_roles::create([
    		'type'=>0,
    		'description'=>'Admin'
		]);
		App\Models\user_roles::create([
    		'type'=>1,
    		'description'=>'Physician'
		]);
		App\Models\user_roles::create([
    		'type'=>2,
    		'description'=>'Patient'
		]);
    }
}
