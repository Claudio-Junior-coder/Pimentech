<?php

namespace App\Http\Controllers;

use App\Models\Companies;
use Illuminate\Http\Request;

class companiesController extends Controller
{
    //
    public function index () {
        $data = Companies::where('draft', 0)->get();
        return view('companies.index', compact('data'));
    }

    public function create (Request $request) {

        $provider = Companies::where('draft', 1)->first();

        if($provider == null || empty($provider)) {
            $id = Companies::create(['name' => 'Nome não informado.', 'draft' => 1])->id;

            return redirect()->route('companies.update', ['id' => $id]);
        }

        return redirect()->route('companies.update', ['id' => $provider->id]);

    }

    public function update ($id) {

        if(!isset($id)) {
            return redirect()->back()->with('message', 'Ops! o id informado não existe.');
        }

        $data = Companies::where('id', $id)->get()->first();

        return view('companies.page', compact('data'));

    }

    public function edit (Request $request) {

        $data = $request->all();
        unset($data['_token']);
        unset($data['id']);

        Companies::where('id', $request->all()['id'])->update($data);


        return redirect()->route('companies.update', ['id' => $request->all()['id'], 'message' => 'Empresa salva com sucesso!']);

    }

    public function listing () {
        $data = Companies::where('draft', 0)->get();
        return $data;
    }

    public function delete (Request $request) {

        if(!isset($request->all()['id'])) {
            return redirect()->back()->with('message', 'Ops! o id informado não existe.');
        }

        Companies::where('id', $request->all()['id'])->delete();

        return redirect()->route('companies.index', ['message' => 'Empresa deletada com sucesso!']);

    }
}

