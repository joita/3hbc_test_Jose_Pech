<?php

namespace App\Http\Controllers;
use App\Models\Airport;
use Illuminate\Http\Request;

class AirportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $airports = Airport::all();
        return $airports;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $datos = json_decode(file_get_contents('php://input'));
       return Airport::create([
        'name' => $datos->name,
        'code' => $datos->code,
        'city' => $datos->city
      ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $datos = json_decode(file_get_contents('php://input'));
        return Airport::where('id', $datos->id)
        ->update([
        'name' => $datos->name,
        'code' => $datos->code,
        'city' => $datos->city
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $datos = json_decode(file_get_contents('php://input'));
        return Airport::where('id', $datos->id)->delete();
        
    }
}
