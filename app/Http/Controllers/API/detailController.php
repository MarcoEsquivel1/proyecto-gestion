<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\detailResource;
use App\Models\detail;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class detailController extends Controller
{
    public function FormatD($date){
        $nDate = DateTime::createFromFormat('Y-m-d', $date)->format('d-m-Y');
        return $nDate;
    }
   
    public function index()
    {
        $p = detail::all();

        $formated = $p->map(
            function($a){
                $a->fecha = $this->FormatD($a->date);
                return $a;
            }, $p
        );

        return response(['message' => 'OK',
        'data' => detailResource::collection($formated)], 200);
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
            'move_id'=>'required',
       'unidades'=>'required',
       'precio'=>'required',
       'product_id'=>'required'
        ]);

        if($validator->fails()){
            return response([
                'message' => 'Fail',
                'data' => $validator->errors()
            ], 400);
        }

        $p = detail::create($data);

        return response([
            'message' => 'OK',
            'detail' => [
                'detail' => new detailResource($p)
            ]], 200);
    }

   
    public function show(detail $detail)
    {
        return response([
            'message' => 'Se recupero correctamente',
            'data' => [
                'detail' => new detailResource($detail)
            ]], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, detail $detail)
    {
        $detail->update($request->all());

        return response([
            'message' => 'OK',
            'data' => [
                'detail' => new detailResource($detail)
            ]], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function destroy(detail $detail)
    {
        $detail->delete();

        return response([
            'message' => 'Se elimino correctamente'
        ], 200);
    }
}