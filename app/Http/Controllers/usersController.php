<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class usersController extends Controller
{
    //
    public function index () {
        $data = User::get();
        return view('users.index', compact('data'));
    }

    public function create (Request $request) {
        if(auth()->user()->type == 1) {
            $id = User::create(['name' => 'Nome não informado.',
                'email' => 'exemplo@claudiopimentel.com',
                'password' => Hash::make('NewJunior@2000???'),
                'type' => 0])->id;

            return redirect()->route('user.update', ['id' => $id]);
        } else {
            return abort(404);
        }

    }

    public function update ($id) {

        if(!isset($id)) {
            return redirect()->back()->with('message', 'Ops! o id informado não existe.');
        }

        $data = User::where('id', $id)->get()->first();

        return view('users.page', compact('data'));

    }

    public function edit (Request $request) {

        $data = $request->all();
        unset($data['_token']);
        unset($data['id']);

        if(isset($data['password']) && $data['password'] != '********') {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        User::where('id', $request->all()['id'])->update($data);


        return redirect()->route('user.update', ['id' => $request->all()['id'], 'message' => 'Usuário salvo com sucesso!']);

    }

    public function editPassword (Request $request) {

        $data = $request->all();
        unset($data['_token']);

        if(isset($data['password']) && $data['password'] != '********') {
            $data['password'] = Hash::make($data['password']);

            User::where('id', Auth::user()->id)->update($data);

            return redirect()->route('user.change.password', ['message' => 'Senha alterada com sucesso!']);

        }

        return redirect()->route('user.change.password', ['message' => 'Nenhuma alteração feita para salvar.']);

    }

    public function listing () {
        $data = User::get();
        return $data;
    }

    public function delete (Request $request) {

        if(auth()->user()->type == 1) {
            if(!isset($request->all()['id'])) {
                return redirect()->back()->with('message', 'Ops! o id informado não existe.');
            }

            User::where('id', $request->all()['id'])->delete();

            return redirect()->route('user.index', ['message' => 'Usuário deletado com sucesso!']);
        } else {
            return abort(404);
        }

    }

}
