<?php

use Illuminate\Database\Seeder;
USE \Illuminate\Support\Facades\DB;

class ProfessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        DB::table('professions')->insert([
            'title'=> 'Desarrollador back-end',
        ]);

        DB::table('professions')->insert([
            'title'=> 'Desarrollador front-end',
        ]);

        DB::table('professions')->insert([
            'title'=> 'Disenador Web',
        ]);
    }
}
