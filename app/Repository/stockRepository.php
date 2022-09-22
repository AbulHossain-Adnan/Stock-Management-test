<?php
namespace App\Repository;

use App\Models\Stock;
use App\Repository\stockInterface;
use Illuminate\Support\Facades\Hash;
use DataTables;
use Illuminate\Http\Request;


class stockRepository implements stockInterface
{   
  
    public function getAllStock($make_true = null)
    {
          

            $data = Stock::all();

             $datatable = DataTables::of($data)
         
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
            return $datatable;

}

public function createOrUpdate($request, $stock=null){

        if(is_null($stock)){
            $i = 0;
            foreach($request->product_id as $id){
                $product = Stock::where('product_id',$id)->first();

                    if($product){
                        DB::table('stocks')->where('product_id',$id)->update(['quantity'=>$product->quantity+$request->quantity[$i]]);
                    }
                    else{
                        $datasave=[ 
                            'date'=>$request->date[$i],
                            'product_id'=>$request->product_id[$i],
                            'quantity'=>$request->quantity[$i],
                        ];
                        DB::table('stocks')->insert($datasave);
                    }
            $i++;

            }
        }else{
            $stock->update(['date'=>$request->date,'product_id'=>$request->product_id,'quantity'=>$request->quantity]);
        }

    }
}