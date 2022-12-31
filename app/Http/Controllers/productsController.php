<?php

namespace App\Http\Controllers;

use App\Models\Sbr;
use App\Models\Products;
use Symfony\Component\HttpFoundation\Request;

class productsController extends Controller
{
    public function index () {
        $data = Products::where('draft', 0)->get();
        return view('products.index', compact('data'));
    }

    public function create (Request $request) {

        $product = Products::where('draft', 1)->first();

        if($product == null || empty($product)) {
            $id = Products::create(['name' => 'Descritivo não informado.', 'draft' => 1])->id;

            return redirect()->route('products.update', ['id' => $id]);
        }

        return redirect()->route('products.update', ['id' => $product->id]);

    }

    public function update ($id) {

        if(!isset($id)) {
            return redirect()->back()->with('message', 'Ops! o id informado não existe.');
        }

        $data = Products::where('id', $id)->get()->first();

        $sbr = Sbr::where('product_id', $id)->get();

        if(!empty($sbr)) {
            foreach ($sbr as $sb) {
                $sb->budget_date = explode(' ', $sb->budget_date)[0];
            }
        }

        $data->sbr = $sbr;
        return view('products.page', compact('data'));

    }

    public function edit (Request $request) {

        $data = $request->all();
        unset($data['_token']);
        unset($data['id']);

        Products::where('id', $request->all()['id'])->update($data);

        return redirect()->route('products.update', ['id' => $request->all()['id'], 'message' => 'Produto salvo com sucesso!']);

    }


    public function delete (Request $request) {

        if(!isset($request->all()['id'])) {
            return redirect()->back()->with('message', 'Ops! o id informado não existe.');
        }
        Products::where('id', $request->all()['id'])->delete();

        Sbr::where('product_id', $request->all()['id'])->delete();

        return redirect()->route('products.index', ['message' => 'Produto deletado com sucesso!']);

    }

}
