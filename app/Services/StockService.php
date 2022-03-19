<?php
namespace App\Services;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Stock;
use DB;

Class StockService{
    
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

    public function stockDelete($stock_id){
        $stock = Stock::findOrFail($stock_id);
        $stock->delete();

    }
    public function stockBulkDelete($request){
      foreach($request->selectedColumn as $id){
            $this->stockDelete($id);
        }
    }
}


