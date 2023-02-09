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

    public function createRev (Request $request) {

        //get budget and items from the same
        //obs: makehidden function get data with exceptions
        $id = $request->all()['id'];

        $budget = Budgets::where('id', $id)->get()->makeHidden(['created_at','updated_at', 'id'])->first()->toArray();
        $searchParent = isset($budget['parent_id']) ? $budget['parent_id'] : $id;
        $budget['parent_id'] = $id;

        $budgetItems = BudgetsItems::where('budget_id', $id)->get()->makeHidden(['created_at','updated_at', 'id'])->toArray();

        $revNumber = Budgets::where('parent_id', $searchParent)->count();

        if($revNumber == 0) {
            $budget['number'] = $budget['number'] . '_REV_1';
        } else {
            $numberBudget = Budgets::where('id', $searchParent)->get('number')->first()->toArray();
            $budget['number'] = $numberBudget['number'] . '_REV_' . ($revNumber + 1);
        }

        //clone
        $budgetId = Budgets::create($budget)->id;

        BudgetsItems::insert($this->addNewItems($budgetItems, $budgetId, false, true));

        //create historic
        $historic = [];
        $historic['budget_id'] = $searchParent;
        $historic['action'] = 'Revisão criada';
        $historic['before_info'] = 'N/A';
        $historic['current_info'] = 'N/A';
        $historic['made_by'] = Auth::user()->name;

        BudgetHistories::create($historic);

        return redirect()->route('budgets.view', ['id' => $budgetId, 'message' => 'Revisão criada com sucesso!']);
    }

    public function addBudgetItem (Request $request) {

        $items = json_decode($request->all()['data'], true);

        BudgetsItems::insert($this->addNewItems($items, $request->all()['budget_id'], true));

        return ['id' => $request->all()['budget_id']];
    }

    public function addNewItems ($items, $budgetId, $doHistoric = false, $isRev = false) {
        $newItems = array();
        foreach ($items as $key => $item) {
            $product_id = false;
            $product_name = false;
            $quantity = false;
            $total_price = false;
            if($isRev == false) {
                $product_id = $item['id'];
                $product_name = $item['name'];
                $quantity = $item['qnt'];
                $quantity = $item['priceTotal'];
            } else {
                $product_id = $item['product_id'];
                $product_name = $item['product_name'];
                $quantity = $item['quantity'];
                $total_price = $item['total_price'];
            }
            $newItems[$key]['budget_id'] = $budgetId;
            $newItems[$key]['product_id'] =  $product_id;
            $newItems[$key]['product_name'] = $product_name;
            $newItems[$key]['quantity'] = $quantity;
            $newItems[$key]['price'] = $item['price'];
            $newItems[$key]['um'] = $item['um'];
            $newItems[$key]['total_price'] = $total_price;
            if($doHistoric == true) {
                $historic = [];
                $historic['budget_id'] = $budgetId;
                $historic['action'] = 'Item adicionado';
                $historic['before_info'] = 'N/A';
                $historic['current_info'] = $item['name'] . ' - Qnt: ' . $quantity . ' - Preço U: ' . $item['price'] . ' - Um: ' . $item['um'] . ' - Total: ' . $total_price;
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

        $isDifferent = array_diff($data, $budget);

        if($isDifferent) {
            foreach($isDifferent as $k => $info) {
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

        $fileName = $budget->number;

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
