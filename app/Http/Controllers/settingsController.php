<?php

namespace App\Http\Controllers;

use App\Models\Sbr;
use App\Models\Products;
use App\Models\Settings;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class settingsController extends Controller
{
    //
    public function index () {
        if(auth()->user()->type == 1) {
            $data = Settings::get()->first();
            return view('settings.index', compact('data'));
        } else {
            return abort(404);
        }
    }

    public function edit (Request $request) {

        $data = $request->all();
        unset($data['_token']);

        if(isset($data['id'])) {

            unset($data['id']);

            Settings::where('id', $request->all()['id'])->update($data);

        } else {

            Settings::create($data);

        }

        return redirect()->route('settings', ['message' => 'Configurações salvas com sucesso!']);

    }

    public function report (Request $request) {
        if(auth()->user()->type == 1) {
            $data = $request->all();
            $items = ['title' => 'Houve um erro ao gerar o relatório'];
            $items['totalPrice'] = 0;
            $items['totalItems'] = 0;
            if(isset($data['report'])) {
                switch ($data['report']) {
                    case "stock_cost":
                        $products = Products::where('draft', 0)->get(['id', 'name', 'quantity']);
                        if($products != null) {
                            foreach($products as $k => $product) {
                                $items['title'] = 'Custo do stock';
                                $sbr = Sbr::where('product_id', $product->id)->orderBy('updated_at', 'desc')->first('provider_price');
                                if($sbr != null) {
                                    $items['products'][$k]['name'] = $product->name;
                                    $items['products'][$k]['unit'] = $this->removerFormatacaoNumero($sbr->provider_price);
                                    $items['products'][$k]['qntd'] = intval($product->quantity);
                                    $items['products'][$k]['total'] = $items['products'][$k]['unit'] * $items['products'][$k]['qntd'];
                                    $items['totalPrice'] += $items['products'][$k]['total'];
                                    $items['totalItems'] += $items['products'][$k]['qntd'];
                                }
                            }
                        }
                        break;
                    default:
                        $items['title'] = 'Tipo de relatorio nao identificado.';
                        break;
                }

            }

            $fileName = 'Relatorio-' . $items['title'] . '-' . date('d/m/Y');

            $pdf = Pdf::loadView('settings.reports.stock-cost-pdf', compact('items', 'fileName'));

            // (Optional) Setup the paper size and orientation
            return $pdf->setPaper('A4')->stream($fileName);

        } else {
            return abort(404);
        }
    }
}
