<?php

namespace App\Http\Controllers;

use App\Models\Sbr;
use App\Models\Products;
use App\Http\Controllers\mailController;
use Symfony\Component\HttpFoundation\Request;

class productsController extends Controller
{
    private $token;
    public function __construct() {
        $this->token = "POLIIYSAJ16541651QWERTU";
    }

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

    public function checkMinStock (Request $request) {

        $data = $request->all();

        if($data['token'] == $this->token) {
            $products = Products::where('draft', 0)->where('quantity', '<=', 'min_stock')->where('min_stock', '!=', 9999)->get();

            if($products != null) {
                mailController::sendMail(compact('products'), 'mail-layouts/min-stock', env('MAIL_CLIENT'), env('MAIL_CLIENT_USERNAME'), 'Alerta de stock');
                return json_encode(["success" => true, "message" => "E-mail sended with success!"]);
            }

            return json_encode(["success" => false, "message" => "Something went wrong."]);
        }

        return json_encode(["success" => false, "message" => "Token code is wrong."]);
    }

}
