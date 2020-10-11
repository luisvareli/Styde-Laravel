<?php

use App\User;
use App\Profession;
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

        $professionId = Profession::where('title', 'Desarrollador back-end')->value('id');


        User::Create([
            'name'=>'Luis Vargas',
            'email'=>'luis@styde.net',
            'password'=>bcrypt('123'),
            'profession_id'=>$professionId
        ]);
    }
}
