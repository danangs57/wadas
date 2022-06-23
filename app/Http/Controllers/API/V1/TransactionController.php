<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends BaseController
{

    public function __construct(Transaction $transaction) {
        $this->transaction = $transaction;
        $this->middleware('auth:api');
    }

    public function index()
    {
        $transactions = $this->transaction->with(['company','products'])->paginate(10);

        return $this->sendResponse($transactions, 'Transaction list');
    }

    public function store(Request $request)
    {

        $transaction = $this->transaction->create([
            'company_id' => $request->get('company_id'),
        ]);

        $product_ids = [];
        foreach ($request->get('product_ids') as $prod) {
            $existingtag = Product::whereName($prod)->first();
                $product_ids[] = $existingtag->id;
          
        }
        $transaction->products()->sync($product_ids);

        return $this->sendResponse($transaction, 'Transaction Success');

    }

    public function destroy($id)
    {
        $product = $this->transaction->findOrFail($id);

        $product->delete();

        return $this->sendResponse($product, 'Product has been Deleted');
    }
}
