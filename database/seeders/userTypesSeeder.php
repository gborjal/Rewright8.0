<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class userTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = 'user_types';
        DB::table($table)->delete();
        user_types::create([
    		'type'=>0,
    		'description'=>'Admin'
		]);
    	user_types::create([
    		'type'=>1,
    		'description'=>'User'
		]);
    }
}
