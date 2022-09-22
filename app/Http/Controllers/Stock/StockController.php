<?php

namespace App\Http\Controllers\Stock;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Product;
use App\Services\StockService;
use App\Repository\stockInterface;

use Auth;
use DB;
use DataTables;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class StockController extends Controller
{
    protected $stock;

    public function __construct(stockInterface $stock){
    
        $this->stock = $stock;
    }

    public function index(Request $request)
    {
        if (request()->ajax()) {
        return $this->stock->getAllStock();
 }

        return view('stock.index',[
        'products'=>Product::all()
        ]);
    }

    public function create()
    {
        return view('stock.create',[
            'products'=>Product::all()
        ]);
    }

    public function store(Request $request)
    {
      $validator =  Validator::make($request->all(), [
        'date.*' => 'required',
        'product_id.*' => 'required',
        'quantity.*' => 'required|numeric'
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $this->stock->createOrUpdate($request);
        return redirect()->route('stock.index')->with('success','data stored succefully');       
    }
            
    public function update(Request $request,Stock $stock)
    {


        // $this->stockservice->createOrUpdate($request,$stock);
        // return redirect()->route('stock.index')->with('success','data updated succefully');  
    }
    public function edit($id){
        // return view('stock/edit',['stock'=>Stock::findOrFail($id),'products'=>Product::all()]);

    }


    public function bulkdelete(Request $request){
       
        // $this->stockservice->stockBulkDelete($request);
        // return response()->json(['success' => true]);
    }




    public function destroy($id){
        // $this->stockservice->stockDelete($id);
        // return response()->json(['success' => true]);
    }

 

}
