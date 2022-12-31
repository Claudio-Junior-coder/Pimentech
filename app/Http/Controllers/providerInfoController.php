<?php

namespace App\Http\Controllers;

use App\Models\ProviderInfo;
use Illuminate\Http\Request;

class providerInfoController extends Controller
{
    //
    public function index () {
        $data = ProviderInfo::where('draft', 0)->get();
        return view('providers.index', compact('data'));
    }

    public function create (Request $request) {

        $provider = ProviderInfo::where('draft', 1)->first();

        if($provider == null || empty($provider)) {
            $id = ProviderInfo::create(['name' => 'Nome não informado.', 'draft' => 1])->id;

            return redirect()->route('provider.info.update', ['id' => $id]);
        }

        return redirect()->route('provider.info.update', ['id' => $provider->id]);

    }

    public function update ($id) {

        if(!isset($id)) {
            return redirect()->back()->with('message', 'Ops! o id informado não existe.');
        }

        $data = ProviderInfo::where('id', $id)->get()->first();

        return view('providers.page', compact('data'));

    }

    public function edit (Request $request) {

        $data = $request->all();
        unset($data['_token']);
        unset($data['id']);

        ProviderInfo::where('id', $request->all()['id'])->update($data);


        return redirect()->route('provider.info.update', ['id' => $request->all()['id'], 'message' => 'Fornecedor salvo com sucesso!']);

    }

    public function listing () {
        $data = ProviderInfo::where('draft', 0)->get();
        return $data;
    }

    public function delete (Request $request) {

        if(!isset($request->all()['id'])) {
            return redirect()->back()->with('message', 'Ops! o id informado não existe.');
        }

        ProviderInfo::where('id', $request->all()['id'])->delete();

        return redirect()->route('provider.info.index', ['message' => 'Fornecedor deletado com sucesso!']);

    }
}
