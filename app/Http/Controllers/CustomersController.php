<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
    //

    public function index () {
        $data = Customers::where('draft', 0)->get();
        return view('customers.index', compact('data'));
    }

    public function create (Request $request) {

        $provider = Customers::where('draft', 1)->first();

        if($provider == null || empty($provider)) {
            $id = Customers::create(['name' => 'Nome não informado.', 'draft' => 1])->id;

            return redirect()->route('customers.update', ['id' => $id]);
        }

        return redirect()->route('customers.update', ['id' => $provider->id]);


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
        $data = Customers::where('draft', 0)->get();
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
                ['draft', '=', '0'],
                ['name', 'LIKE', '%'. $_GET['search'] .'%']
            ]
        )->orWhere([
            ['draft', '=', '0'],
            ['cod', 'LIKE', '%'. $_GET['search'] .'%']
        ])->get();

        return $customers;
    }
}
