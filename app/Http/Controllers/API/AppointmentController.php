<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\AppointmentResource;
use App\Models\appointment;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AppointmentController extends Controller
{
    public function FormatD($date){
        $nDate = DateTime::createFromFormat('Y-m-d', $date)->format('d-m-Y');
        return $nDate;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $appointments = appointment::all();

        $formated = $appointments->map(
            function($a){
                $a->fecha = $this->FormatD($a->date);
                return $a;
            }, $appointments
        );

        return response(['message' => 'OK',
        'data' => AppointmentResource::collection($formated)], 200);
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
            'clientName' => 'required|max:100',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'description' => 'required|max:200'
        ]);

        if($validator->fails()){
            return response([
                'message' => 'Fail',
                'data' => $validator->errors()
            ], 400);
        }

        $appointment = appointment::create($data);

        return response([
            'message' => 'OK',
            'data' => [
                'appointment' => new AppointmentResource($appointment)
            ]], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function show(appointment $appointment)
    {
        return response([
            'message' => 'Se recupero correctamente',
            'data' => [
                'appointment' => new AppointmentResource($appointment)
            ]], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, appointment $appointment)
    {
        $appointment->update($request->all());

        return response([
            'message' => 'OK',
            'data' => [
                'appointment' => new AppointmentResource($appointment)
            ]], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function destroy(appointment $appointment)
    {
        $appointment->delete();

        return response([
            'message' => 'Se elimino correctamente'
        ], 200);
    }
}
