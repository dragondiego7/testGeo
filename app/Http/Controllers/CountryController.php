<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Country;
use Illuminate\Support\Facades\DB;

/**
 * Country controller class
 */
class CountryController extends Controller
{
    
    /**
     * List all countries function
     *
     * @return void
     */
    public function index()
    {
        return Country::all();
    }
 
    /**
     * Search one county by id function
     *
     * @param Country $country
     * @return void
     */
    public function show(Country $country)
    {
        return $country;
    }

    /**
     * Save a new country function
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $country = Country::create($request->all());

        return response()->json($country, 201);
    }

    /**
     * Update Country function
     *
     * @param Request $request
     * @param Country $country
     * @return void
     */
    public function update(Request $request, Country $country)
    {
        $country->update($request->all());

        return response()->json($country, 200);
    }

    /**
     * Remove country function
     *
     * @param Country $country
     * @return void
     */
    public function delete(Country $country)
    {
        $country->delete();

        return response()->json(null, 204);
    }

    /**
     * Filter by ip function
     *
     * @param string $ip
     * @return void
     */
    public function locationByIp(string $ip)
    {
        $country = Country::where('ip', strval($ip))->first();

        return response()->json($country->name, 200);
    }
}
