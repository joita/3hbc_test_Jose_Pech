<?php

namespace App\Policies;

use App\Models\Flights;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\Response;
class FlightsPolicy
{
    public function index(string $role){
        return $role[0] == 'admin' ? true : false;
    }
   
}
