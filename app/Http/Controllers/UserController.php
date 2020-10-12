<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        $title = 'Listado de Usuarios';

//        return view('users.index')
//            ->with('users', User::all())
//            ->with('title','Listado de usuarios');

        return view('users.index', compact('title','users'));
    }

    public function show(User $user)
    {


//        $user = User::findOrFail($id);
//
//        //exit('Linea no alcanzada'); //test
////        if($user == null){
////            return response()->view('errors.404',[],404);
////        }

        return view('users.show',compact('user'));

    }
    public function create(){
        return view('users.create');

    }

    public function store()
    {


        $data = request()->validate([
            'name'=>'required',
    ],[
        'name.required'=>'El campo nombre es obligatorio'
        ]);


        User::create([
            'name'=>$data['name'],
            'email'=>$data['email'],
            'password'=>bcrypt($data['password'])
        ]);

        return redirect()->route('users.index');
    }

}
