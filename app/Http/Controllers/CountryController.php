<?php

namespace App\Http\Controllers;

use App\MunicipalityState;
use App\State;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function states()
    {
        $state = State::all();
        return view('layouts._country.state', compact('state'));
    }

    public function municipality($stateId)
    {
        $municipality = MunicipalityState::with('municipio')->where('estados_id', $stateId)->get();
        // dd($municipality);
        $state = State::find($stateId);
        // dd($stateId);
        return view('layouts._country.municipality', compact('municipality', 'state'));
    }
}
