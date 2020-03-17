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

        // TODO revert here to equal 0!!! XXXXXXXXXXXXXXXXXXXXXXXXX
        if(count($country) > 0) {
            $this->line('Start Process to populate database');
            $this->populateCountry();
        }

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

        $this->extractFile();
        
        $fileContent = Storage::get("GeoIPCountryWhois.csv");

        $fileContentArray = explode("\n", $fileContent);

        DB::beginTransaction();

        try{

        
            foreach($fileContentArray as $key => $line) {
                $this->line('Load Countrys');
                $countryArray = explode(",", $line);

                $countryArray = $this->formatFieldsCountry($countryArray);

                

                $country["ip"] = $countryArray[0];
                $country["mask"] = $countryArray[1];
                $country["num_start"] = $numStart;
                $country["num_end"] = $numEnd;
                $country["initials"] = $countryArray[4];
                $country["name"] = $countryArray[5];
                
                Country::Create($country);

                if($key == 5) {
                    DB::commit();
                    break;
                }
            }
        } catch (\Exception $e ){
            $this->error($e->getMessage());
            DB::rollBack();
        }

        $this->line('End Load Countrys');
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

    /**
     * Function to extract files
     *
     * @return void
     */
    protected function extractFile()
    {
        $zip = new \ZipArchive;

        $path = storage_path('app');
        
        if ($zip->open($path . '\GeoIPCountryCSV.zip') === TRUE) {
            $zip->extractTo($path);
            $zip->close();
            $this->info('File Extract with sucess');
        } else {
            $this->error('Failed to extract the file!');
        }
    }

    /**
     * Function to formater fields before insert to database
     *
     * @param array $fieldsArray
     * @return void
     */
    protected function formatFieldsCountry(array $fieldsArray){
        foreach($fieldsArray as $field){
            $fieldsArray[$key] = str_replace('"', "", $field);
        }

        $fieldsArray[2] = intval($fieldsArray[2]);

        $fieldsArray[3] = intval($fieldsArray[3]);

        return $fieldsArray;
    }

}
