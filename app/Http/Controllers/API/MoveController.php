<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\MoveResource;
use App\Models\Move;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MoveController extends Controller
{
    public function FormatD($date){
        $nDate = DateTime::createFromFormat('Y-m-d', $date)->format('d-m-Y');
        return $nDate;
    }
   
    public function index()
    {
        $p = Move::all();

        $formated = $p->map(
            function($a){
                $a->fecha = $this->FormatD($a->date);
                return $a;
            }, $p
        );

        return response(['message' => 'OK',
        'data' => MoveResource::collection($formated)], 200);
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
            'date'=>'required',
        'monto'=>'required',
        'tipo'  =>'required'
        ]);

        if($validator->fails()){
            return response([
                'message' => 'Fail',
                'data' => $validator->errors()
            ], 400);
        }

        $p = Move::create($data);

        return response([
            'message' => 'OK',
            'data' => [
                'product' => new MoveResource($p)
            ]], 200);
    }

   
    public function show(Move $Move)
    {
        return response([
            'message' => 'Se recupero correctamente',
            'data' => [
                'Move' => new ProductResource($Move)
            ]], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Move $Move)
    {
        $Move->update($request->all());

        return response([
            'message' => 'OK',
            'data' => [
                'Move' => new MoveResource($Move)
            ]], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Move $Move)
    {
        $Move->delete();

        return response([
            'message' => 'Se elimino correctamente'
        ], 200);
    }
}