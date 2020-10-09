<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        $professions = DB::select('SELECT id FROM professions WHERE title = ?', ['Desarrollador back-end']);

        $professionId = DB::table('professions')
            ->where('title', 'Desarrollador back-end')
            ->value('id');


        DB::table('users')->insert([
            'name'=>'Luis Vargas',
            'email'=>'luis@styde.net',
            'password'=>bcrypt('123'),
            'profession_id'=>$professionId
        ]);
    }
}
