<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProdukModel;
use Illuminate\Support\Facades\Validator;



class ApiProdukController extends Controller
{
    public function index()
    {

        $produk = ProdukModel::get();
        return response()->json(['message' => 'data', 'data' => $produk]);
    }

    public function product(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name_product' => 'required',
            'description' => 'required',
            'haryt' => 'required'
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors);
        }

        $produk = new ProdukModel();
        $produk->name_product = $request->name_product;
        $produk->description = $request->description;
        $produk->haryt = $request->haryt;

        $produk->save();

        return response()->json(['message' => 'product registered', 'data' => $produk], 200);
    }
}
