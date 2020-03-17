<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\Country;
use Illuminate\Support\Facades\Storage;

class loadFlux extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:loadflux';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to load files from file';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Begin Flux');

        $this->line('Validate database register');
        
        $country = Country::all();

        if(count($country) == 0) {
            $this->populateCountry();
        }

        //$this->error('Something went wrong!');

        $this->info('End Flux');
    }

    /**
     * Function to populate table country
     *
     * @return void
     */
    protected function populateCountry()
    {
        $this->downloadFile();
        
        Storage::
    }

    /**
     * Function to download file and recovery your content
     *
     * @return void
     */
    protected function downloadFile()
    {
        $url = env("URL_COUNTRYIPCSV");
        $guzzle = new Client();
        $response = $guzzle->get($url);
        Storage::put('GeoIPCountryCSV.zip', $response->getBody());
    } 

}
