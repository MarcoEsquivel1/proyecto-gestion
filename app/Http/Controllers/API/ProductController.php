<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function FormatD($date){
        $nDate = DateTime::createFromFormat('Y-m-d', $date)->format('d-m-Y');
        return $nDate;
    }
   
    public function index()
    {
        $p = Product::all();

        $formated = $p;

        return response(['message' => 'OK',
        'data' => ProductResource::collection($formated)], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'nombre'=>'required|max:100',
        'cantidad'=>'required',
        'p/u'=>'required',
        'description'=>'required|max:100',
        'marca'=>'required|max:50'
        ]);

        if($validator->fails()){
            return response([
                'message' => 'Fail',
                'data' => $validator->errors()
            ], 400);
        }

        $p = Product::create($data);

        return response([
            'message' => 'OK',
            'data' => [
                'product' => new ProductResource($p)
            ]], 200);
    }

   
    public function show(Product $Product)
    {
        return response([
            'message' => 'Se recupero correctamente',
            'data' => [
                'product' => new ProductResource($Product)
            ]], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $Product)
    {
        $Product->update($request->all());

        return response([
            'message' => 'OK',
            'data' => [
                'Product' => new ProductResource($Product)
            ]], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $Product)
    {
        $Product->delete();

        return response([
            'message' => 'Se elimino correctamente'
        ], 200);
    }
}
