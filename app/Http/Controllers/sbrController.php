<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\Sbr;
use App\Models\Products;
use App\Models\ProviderInfo;
use Illuminate\Http\Request;

class sbrController extends Controller
{
    //
    public function create (Request $request) {

        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
        ]);

        $data = Sbr::create($request->all());

        return $data;
    }


    public function delete (Request $request) {

        if(!isset($request->all()['id'])) {
            return redirect()->back()->with('message', 'Ops! o id informado não existe.');
        }

        Sbr::where('id', $request->all()['id'])->delete();

        return ['success' => true];

    }

    public function edit (Request $request) {

        $data = $request->all();

        unset($data['_token']);
        unset($data['id']);

        if(isset($data['budget_date'])) {
            $data['budget_date'] = $data['budget_date'] . ' ' . date('H:i:s');
        }

        Sbr::where('id', $request->all()['id'])->update($data);

        if(isset($data['budget_date']) || isset($data['budget_sale_price'])) {
            $sbr = Sbr::where('product_id', $data['product_id'])->orderBy('budget_date', 'desc')->get()->first();
            $dataProduct = ['id' => $sbr->product_id, 'price' => $sbr->budget_sale_price];
            Products::where('id', $sbr->product_id)->update($dataProduct);
        }

        return ['success' => true];

    }

    public function getByProduct ($id) {

        if(!isset($id)) {
            return false;
        }

        $data = Sbr::where('product_id', $id)->get();

        foreach($data as $dt) {
            if(isset($dt->provider_id)) {
                $dt->provider_name = ProviderInfo::where('id', $dt->provider_id)->get('name');
            }
        }
        return $data;

    }
}
