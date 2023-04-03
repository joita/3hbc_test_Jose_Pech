<?php

namespace App\Http\Controllers;
use App\Models\Flights;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FlightController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$flights = Flights::all();
        $flights = DB::table('flights')
            ->join('airports', 'flights.departure_id', '=', 'airports.id')
            ->join('airports as d', 'flights.destination_id', '=', 'd.id')
            ->join('airlines', 'flights.airline_id', '=', 'airlines.id')
            ->select('flights.*', 'airports.name as name_departure', 'd.name as name_destino','airlines.name as airline_name')
            ->get();
        return $flights;
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
        return Flights::create([
            'code' => $datos->code,
            'type' => $datos->type,
            'departure_id' => $datos->departure_id,
            'destination_id' => $datos->destination_id,
            'departure_time' => $datos->departure_time,
            'arrival_time' => $datos->arrival_time,
            'airline_id' => $datos->airline_id
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
        return Flights::where('id', $datos->id)
        ->update([
            'code' => $datos->code,
            'type' => $datos->type,
            'departure_id' => $datos->departure_id,
            'destination_id' => $datos->destination_id,
            'departure_time' => $datos->departure_time,
            'arrival_time' => $datos->arrival_time,
            'airline_id' => $datos->airline_id
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
        return Flights::where('id', $datos->id)->delete();
    }
}
