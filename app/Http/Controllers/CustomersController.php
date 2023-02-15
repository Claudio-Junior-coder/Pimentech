<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
    //

    public function index () {
        $data = Customers::get();
        return view('customers.index', compact('data'));
    }

    public function create (Request $request) {

        $id = Customers::create(['name' => 'Nome não informado.'])->id;

        return redirect()->route('customers.update', ['id' => $id]);

    }

    public function update ($id) {

        if(!isset($id)) {
            return redirect()->back()->with('message', 'Ops! o id informado não existe.');
        }

        $data = Customers::where('id', $id)->get()->first();

        return view('customers.page', compact('data'));

    }

    public function edit (Request $request) {

        $data = $request->all();
        unset($data['_token']);
        unset($data['id']);

        Customers::where('id', $request->all()['id'])->update($data);


        return redirect()->route('customers.update', ['id' => $request->all()['id'], 'message' => 'Cliente salvo com sucesso!']);

    }

    public function listing () {
        $data = Customers::get();
        return $data;
    }

    public function delete (Request $request) {

        if(!isset($request->all()['id'])) {
            return redirect()->back()->with('message', 'Ops! o id informado não existe.');
        }

        Customers::where('id', $request->all()['id'])->delete();

        return redirect()->route('customers.index', ['message' => 'Cliente deletado com sucesso!']);

    }

    public function search () {
        $customers = Customers::where(
            [
                ['name', 'LIKE', '%'. $_GET['search'] .'%']
            ]
        )->orWhere([
            ['cod', 'LIKE', '%'. $_GET['search'] .'%']
        ])->get();

        return $customers;
    }
}
