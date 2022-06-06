<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\State;
use Illuminate\Support\Facades\Validator;

class LocationsController extends Controller
{

	// States
    public function states() {
    	$states = State::all();

    	return $states;
    }


}
