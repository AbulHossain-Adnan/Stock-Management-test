<?php
namespace App\Services;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

Class productservice{
    
	public function createOrUpdate($request, $product=null){

        if(is_null($product)){
            $product= new Product();
            $this->imageStoreOrUpdate($request);
        }
        $product->name=$request['name'];
        $product->price=$request['price'];
        $product->slug = Str::slug($request['name']);
        $product->save();
        $this->imageStoreOrUpdate($request,$product);
        return $product;
	}

    public function imageStoreOrUpdate($request,$product=null){
        if(is_null($product)){
            $product = new Product();
            if($request->file('image')){
                $product->addMediaFromRequest('image')->toMediaCollection('image');   
            }
        }
        else{
            if($request->file('image')){
                $product->clearMediaCollection('image');
                $product->addMediaFromRequest('image')->toMediaCollection('image');
            }
        }
    }

    public function productDelete($product_id){
        $product = Product::findOrFail($product_id);
        $product->clearMediaCollection('image');
        $product->delete();

    }
    public function productBulkDelete($request){
      foreach($request->selectedColumn as $id){
            $this->ProductDelete($id);
        }
    }
}


