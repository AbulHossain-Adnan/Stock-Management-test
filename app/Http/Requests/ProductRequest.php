<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'=>'required|max:30',
            'price'=>'required|numeric',
            'image'=>'image|mimes:jpeg,png,jpg,gif,svg|max:2000',
          
        ];
    }
}
