<?php

namespace App\Http\Controllers\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Product;
use App\Services\ProductService;
use App\Http\Requests\ProductRequest;
use Auth;
use DB;
use DataTables;
use Illuminate\Contracts\Validation\Rule;

class ProductController extends Controller
{
    protected $productservice;

    public function __construct(ProductService $productservice){
         $this->productservice=$productservice;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Product::select('*');
            return DataTables::of($data)
         
            ->addIndexColumn()
            ->addColumn('action', function ($data) {

                $btn = '
                        <a  href="'.route('product.edit',$data->id).'"  class="btn btn-primary btn-sm""><i class="fa fa-edit"></i></a> <a  type="button" onclick="deleteproduct('.$data->id.')"  class="btn btn-danger btn-sm""><i class="fa fa-trash"></i></a>';
                return $btn;
            })
            ->addColumn('checkbox', function($row){
                return '<input type = "checkbox" name="domain_checkbox" data-id="'.$row->id.'"><lavel></label>';
            })
            ->addColumn('image',function($data){
                $url= $data->getFirstMediaUrl('image');
                return '<img src="'.$url.'" border="0" width="45" class="img-rounded" align="center" />';
            })
            ->rawColumns(['image','action','checkbox'])
            ->make(true);
        }
        return view('product/index');
    }

    public function create()
    {
        return view('product/create');
    }


    public function store(ProductRequest $request)
    { 
        $this->productservice->createOrUpdate($request);
            return redirect()->route('product.index')->with('success','Product Stored Succesfully');
        }
    
    public function edit(Product $product)
    {
      return view('product/edit',['product'=>$product, ]);
    }

    public function update(ProductRequest $request, Product $product)
    {
       $product = $this->productservice->createOrUpdate($request,$product);

       if($product->getChanges()){
           $message=[
            'success'=>'Product Updated Succefully'
           ];
        }else{
            $message=[
                'info'=>'Nothing to Update'
            ];
        }
        return redirect()->route('product.index')->with($message);
    }


    public function destroy($id)
    {
        $this->productservice->productDelete($id);
        return response()->json('success',200);
    }


    public function bulkdelete(Request $request){
        $this->productservice->productBulkDelete($request);
        return response()->json(['success' => true]);
    }
}
