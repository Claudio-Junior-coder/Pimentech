<?php

namespace App\Http\Controllers;

use App\Models\Budgets;
use App\Models\Products;
use App\Models\Customers;
use App\Models\BudgetsItems;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class budgetsController extends Controller
{
    //

    public function index () {
        $data = Budgets::get();
        return view('budgets.index', compact('data'));
    }

    public function create (Request $request) {

        $customer = Customers::where('id', $request->all()['customer_id'])->get()->first();

        $budget = [
            'total' => $request->all()['total'],
            'customer_name' => $customer->name,
            'second_customer_phone' => $customer->a_c,
            'customer_city' => $customer->city,
            'customer_address_to_shipping' => $customer->address_to_shipping,
            'customer_phone' => $customer->phone,
            'customer_cnpj' => $customer->cnpj,
            'customer_email' => $customer->email,
            'customer_state' => $customer->state,
            'number' => date('YmdHis'),
            'user_name' => Auth::user()->name
        ];

        $budgetId = Budgets::create($budget)->id;

        $items = json_decode($request->all()['data'], true);
        $newItems = array();
        foreach ($items as $key => $item) {
            $newItems[$key]['budget_id'] = $budgetId;
            $newItems[$key]['product_id'] = $item['id'];
            $newItems[$key]['product_name'] = $item['name'];
            $newItems[$key]['quantity'] = $item['qnt'];
            $newItems[$key]['price'] = $item['price'];
            $newItems[$key]['um'] = $item['um'];
            $newItems[$key]['total_price'] = $item['priceTotal'];
        }

        BudgetsItems::insert($newItems);

        return ['id' => $budgetId];

    }

    public function view ($id) {

        $budget = Budgets::where('id', $id)->get()->first();

        $budgetItems = BudgetsItems::where('budget_id', $id)->get();

        $budget->totalWithoutCharacters = strtoupper($this->valorPorExtenso($budget->total, true, false));

        return view('budgets.page', compact('budgetItems', 'budget'));

    }

    public function createPdf (Request $request) {

        $data = $request->all();
        unset($data['_token']);

        $data['pdf_was_generated'] = 1;

        $budget = Budgets::where('id', $data['id'])->update($data);

        return redirect()->route('budgets.view', ['id' => $data['id'], 'message' => 'PDF Gerado com sucesso!']);

    }

    public function pdf ($id) {

        $budget = Budgets::where('id', $id)->get()->first();

        $budgetItems = BudgetsItems::where('budget_id', $id)->get();

        $fileName = 'Orçamento-' . $budget->customer_name . '-' . date('d-m-Y');

        $pdf = Pdf::loadView('budgets.pdf', compact('budgetItems', 'budget', 'fileName'));

        // (Optional) Setup the paper size and orientation
        return $pdf->setPaper('A4')->stream($fileName);

    }

    public function lowStock (Request $request) {

        $data['id'] = $request->all()['id'];
        $data['low_stock'] = 1;

        $budgetItems = BudgetsItems::where('budget_id', $data['id'])->get();

        foreach($budgetItems as $budget){
            $product = Products::where('id', $budget['product_id'])->get()->first();

            if ($product !== null) {

                $finalQuantity = $product['quantity'] - $budget['quantity'];

                $newProduct = [];
                $newProduct['id'] = $product['id'];
                $newProduct['quantity'] = $finalQuantity;

                Products::where('id', $budget['product_id'])->update($newProduct);

            }
        }

        Budgets::where('id', $data['id'])->update($data);

        return redirect()->route('budgets.view', ['id' => $data['id'], 'message' => 'O processo de baixa no estoque foi concluído!']);
    }

}
