<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function create(Request $request){
        $validator = Validator::make($request->all() , [
            'name' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false ,'error' => 'check name']);
        }

        $category = Category::create([
            'name' => $request->name,
            'parent_id' => $request->parent
        ]);
        return response()->json(['status' => true , 'category' => $category]);
    }
}
