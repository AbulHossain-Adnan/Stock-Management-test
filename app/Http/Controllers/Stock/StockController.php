<?php

namespace App\Http\Controllers\Stock;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Product;
use App\Services\StockService;
use Auth;
use DB;
use DataTables;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class StockController extends Controller
{
    protected $stockservice;

    public function __construct(StockService $stockservice){
         $this->stockservice=$stockservice;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Stock::select('*');
           
            return DataTables::of($data)
         
            ->addIndexColumn()
            ->addColumn('action', function ($data) {

                $btn = '
                        <a  href="'.route('stock.edit',$data->id).'"  class="btn btn-primary btn-sm""><i class="fa fa-edit"></i></a> <a  type="button" onclick="deleteStock('.$data->id.')"  class="btn btn-danger btn-sm""><i class="fa fa-trash"></i></a>';
                return $btn;
            })
            ->addColumn('checkbox', function($row){
                return '<input type = "checkbox" name="domain_checkbox" data-id="'.$row->id.'"><lavel></label>';
            })
            ->rawColumns(['action','checkbox'])
            ->make(true);
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
        $this->stockservice->createOrUpdate($request);
        return redirect()->route('stock.index')->with('success','data stored succefully');       
    }
            
    public function update(Request $request,Stock $stock)
    {


        $this->stockservice->createOrUpdate($request,$stock);
        return redirect()->route('stock.index')->with('success','data updated succefully');  
    }
    public function edit($id){
        return view('stock/edit',['stock'=>Stock::findOrFail($id),'products'=>Product::all()]);

    }


    public function bulkdelete(Request $request){
       
        $this->stockservice->stockBulkDelete($request);
        return response()->json(['success' => true]);
    }




    public function destroy($id){
        $this->stockservice->stockDelete($id);
        return response()->json(['success' => true]);
    }

 

}
