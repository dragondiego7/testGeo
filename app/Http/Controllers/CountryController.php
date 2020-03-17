<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Country;

class CountryController extends Controller
{
    
    
    public function index()
    {
        return Country::all();
    }
 
    public function show($id)
    {
        return Country::find($id);
    }

    public function store(Request $request)
    {
        return Country::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $country = Country::findOrFail($id);
        $country->update($request->all());

        return $country;
    }

    public function delete(Request $request, $id)
    {
        $country = Country::findOrFail($id);
        $country->delete();

        return 204;
    }
}
