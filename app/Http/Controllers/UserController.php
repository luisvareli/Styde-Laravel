<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
//        $users = User::all()

        $users = [
            'Marco',
            'Isaac',
            'Josue',
            'Gael',
            'Ellie',
            '<script>alert("Clicker")</script>'
        ];

        $title = 'Listado de Usuarios';


//        dd(compact('title','users'));// Comprobacion para pasarlos a la vista

        return view('users', compact('title','users'));
    }
    public function show($id){
        return "Mostrando detalle del usuario: {$id}";
    }
    public function create(){
        return 'Crear nuevo usuario';

    }

}
