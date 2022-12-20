<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class PetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         //Estandarizacion de respuestas con Jsend
         try {
            return jsend_success(Pet::all());
        } catch (\Exception $e) {
            return jsend_error($e);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try {           
            //Reglas para la variable Validator
            $rules =[
                'name'=>'required',
                'species'=>'required',
                'age'=>'required',
                'weight'=>'required',
            ];

            $messages=[
                //Mensaje personalizado para errores
                'required'=>'El campo:attribute es requerido'
            ];
            //Pasamos como parametros de make las reglas y mensajes
            $validator = FacadesValidator::make($request->all(),$rules,$messages);        

            if($validator->fails()){
                return jsend_fail($validator->errors());
            }

            return jsend_success(Pet::create($request->all()),status:201);
        } catch (\Exception $e) {
            return jsend_error($e);
        }

        $pet = new Pet();
        $pet->name = $request->name;
        $pet->species = $request->species;
        $pet->age = $request->age;
        $pet->weight = $request->weight;
        $pet->save();

        $data = [
            "message" => "Branch created successfully",
            "branch" => $pet,
        ];

        return response()->json($pet);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pet  $pet
     * @return \Illuminate\Http\Response
     */
    public function show(Pet $pet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pet  $pet
     * @return \Illuminate\Http\Response
     */
    public function edit(Pet $pet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pet  $pet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pet $pet)
    {

        try {
            $rules =[
                'name'=>'required',
                'species'=>'required',
                'age'=>'required',
                'weight'=>'required'
            ];

            $messages=[
                //Mensaje personalizado para errores
                'required'=>'El campo" " :attribute es requerido'
            ];
            //Pasamos como parametros de make las reglas y mensajes
            $validator = FacadesValidator::make($request->all(),$rules,$messages);

            if($validator->fails()){
                return jsend_fail($validator->errors());
            }
        } catch (\Exception $e) {
            return jsend_error($e);
        }

        $pet->name = $request->name;
        $pet->species = $request->species;
        $pet->age = $request->age;
        $pet->weight = $request->weight;
        $pet->save();

        $data = [
            "message" => "Branch created successfully",
            "branch" => $pet,
        ];

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pet  $pet
     * @return \Illuminate\Http\Response
     */
    public function destroy($pet)
    {
        try {
            return jsend_success(Pet::destroy($pet));
        } catch (\Exception $e) {
            return jsend_error($e);
        }

        $data = [
            "message" => "Branch deleted successfully",
            "branch" => $pet,
        ];
    }
}