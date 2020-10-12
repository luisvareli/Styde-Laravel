<?php

use App\Profession;
use Illuminate\Database\Seeder;
USE Illuminate\Support\Facades\DB;

class ProfessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        DB::insert('INSERT INTO professions (title) VALUES (:title)',[
//            'title'=>'Desarrollador back-end'
//        ]);

//        DB::table('professions')->insert([
//            'title'=> 'Desarrollador back-end',
//        ]);

        Profession::create([
            'title'=>'Desarrollador back-end',
        ]);

        Profession::create([
            'title'=> 'Desarrollador front-end',
        ]);

        Profession::create([
            'title'=> 'Disenador Web',
        ]);

        factory(App\Profession::class, 17)->create();
    }
}
