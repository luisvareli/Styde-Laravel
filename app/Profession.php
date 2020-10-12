<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Commands\SendEmail;
class Profession extends Model
{
    //protected $table = 'my_professions';

   // public $timestamps = false;

    protected $fillable = ['title'];

    public function users(){
        return $this->hasMany(User::class);
    }
}
