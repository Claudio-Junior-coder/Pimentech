<?php

namespace App\Http\Controllers;

use App\Models\Budgets;
use App\Models\Products;
use App\Models\Settings;
use App\Models\Customers;
use App\Models\BudgetsItems;
use Illuminate\Http\Request;
use App\Models\BudgetHistories;
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
        $settings = Settings::get(['budget_number', 'id'])->first();
        $numberBudgetYear = substr($settings->budget_number, -4);
        $budgetNumber = str_replace($numberBudgetYear, '', $settings->budget_number);
        $numberBudgetFinal =  str_pad(intval($budgetNumber + 1), 2, '0', STR_PAD_LEFT) . $numberBudgetYear;
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
            'number' => $numberBudgetFinal,
            'user_name' => Auth::user()->name
        ];

        $budgetId = Budgets::create($budget)->id;

        $items = json_decode($request->all()['data'], true);

        Settings::where('id', $settings->id)->update(['budget_number' => $numberBudgetFinal]);

        BudgetsItems::insert($this->addNewItems($items, $budgetId));

        return ['id' => $budgetId];

    }

    public function addBudgetItem (Request $request) {

        $items = json_decode($request->all()['data'], true);

        BudgetsItems::insert($this->addNewItems($items, $request->all()['budget_id'], true));

        return ['id' => $request->all()['budget_id']];
    }

    public function addNewItems ($items, $budgetId, $doHistoric = false) {
        $newItems = array();
        foreach ($items as $key => $item) {
            $newItems[$key]['budget_id'] = $budgetId;
            $newItems[$key]['product_id'] = $item['id'];
            $newItems[$key]['product_name'] = $item['name'];
            $newItems[$key]['quantity'] = $item['qnt'];
            $newItems[$key]['price'] = $item['price'];
            $newItems[$key]['um'] = $item['um'];
            $newItems[$key]['total_price'] = $item['priceTotal'];
            if($doHistoric == true) {
                $historic = [];
                $historic['budget_id'] = $budgetId;
                $historic['action'] = 'Item adicionado';
                $historic['before_info'] = 'N/A';
                $historic['current_info'] = $item['name'] . ' - Qnt: ' . $item['qnt'] . ' - Preço U: ' . $item['price'] . ' - Um: ' . $item['um'] . ' - Total: ' . $item['priceTotal'];
                $historic['made_by'] = Auth::user()->name;
                BudgetHistories::create($historic);
            }
        }

        return $newItems;
    }

    public function edit (Request $request) {

        $data = $request->all();
        unset($data['_token']);
        unset($data['id']);

        //create historic
        $this->createHistoric ($data, $request->all()['id'], 'Edições gerais');

        //update
        Budgets::where('id', $request->all()['id'])->update($data);

        return redirect()->route('budgets.view', ['id' => $request->all()['id'], 'message' => 'Orçamento salvo com sucesso!']);

    }

    public function createHistoric ($data, $budgetId, $action) {

        //get budget
        $budget = Budgets::where('id', $budgetId)->get()->first()->toArray();

        foreach($data as $k => $info) {

            if(!in_array($info, $budget)) {
                $historic = [];
                $historic['budget_id'] = $budgetId;
                $historic['action'] = $action;
                $historic['before_info'] = $budget[$k];
                $historic['current_info'] = $info;
                $historic['made_by'] = Auth::user()->name;
                BudgetHistories::create($historic);
            }

        }

    }

    public function historic ($id) {
        if(auth()->user()->type == 1) {

            $budgets = BudgetHistories::where('budget_id', $id)->get();

            return view('budgets.historic.index', compact('budgets', 'id'));

        }

        return abort(404);

    }

    public function view ($id) {

        $budget = Budgets::where('id', $id)->get()->first();

        $budgetItems = BudgetsItems::where('budget_id', $id)->get();

        (float) $newTotal = 0;
        foreach($budgetItems as $budgetItem) {
            $result = $this->removerFormatacaoNumero( $budgetItem->total_price );
            $newTotal += $result;
        }

        $budget->total = 'R$ ' . number_format($newTotal, 2, ',', '.');

        $priceInString = strtoupper($this->valorPorExtenso($budget->total, true, false));

        $budget->price_in_string = $priceInString;
        $budget->totalWithoutCharacters = $priceInString;

        return view('budgets.page', compact('budgetItems', 'budget'));

    }

    public function createPdf (Request $request) {

        $data = $request->all();
        unset($data['_token']);

        $data['pdf_was_generated'] = 1;

        //create historic
        $this->createHistoric ($data, $data['id'], 'Editou info que gera o pdf');

        //update
        $budget = Budgets::where('id', $data['id'])->update($data);

        return redirect()->route('budgets.view', ['id' => $data['id'], 'message' => 'PDF Gerado com sucesso!']);

    }

    public function pdf ($id) {

        $budget = Budgets::where('id', $id)->get()->first();

        $budgetItems = BudgetsItems::where('budget_id', $id)->get();

        $fileName = 'Orçamento-' . $budget->customer_name . '-' . $budget->number;

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


    public function deleteBudgetItem (Request $request) {

        if(!isset($request->all()['id'])) {
            return redirect()->back()->with('message', 'Ops! o id informado não existe.');
        }

        $item = BudgetsItems::where('id', $request->all()['id'])->get()->first()->toArray();

        BudgetsItems::where('id', $request->all()['id'])->delete();

        $historic = [];
        $historic['budget_id'] = $item['budget_id'];
        $historic['action'] = 'Item removido';
        $historic['before_info'] = 'N/A';
        $historic['current_info'] = $item['product_name'] . ' - Qnt: ' . $item['quantity'] . ' - Preço U: ' . $item['price'] . ' - Um: ' . $item['um'] . ' - Total: ' . $item['total_price'];
        $historic['made_by'] = Auth::user()->name;

        BudgetHistories::create($historic);

        return ['success' => true];

    }

    public function search () {

        if(isset($_GET['search'])) {
            $budgets = Budgets::where('number', 'LIKE', '%'. $_GET['search'] .'%')->get();

            return $budgets;
        }
    }

}
