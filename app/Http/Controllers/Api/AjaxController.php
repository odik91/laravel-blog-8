<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function dataSubcategory($data) {
        $subcategories = SubCategory::where('category_id', $data)->orderBY('subname', 'asc')->only('id','category_id','subname');
        return response()->json($subcategories);
    }
}
