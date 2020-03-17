<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\Country;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

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

        $bar = $this->output->createProgressBar(count($fileContentArray));
        $bar->start();

        try{
            foreach($fileContentArray as $key => $line) {
                $bar->advance();

                $countryArray = explode(",", $line);

                $countryArray = $this->formatFieldsCountry($countryArray);

                $country["ip"] = $countryArray[0];
                $country["mask"] = $countryArray[1];
                $country["num_start"] = $countryArray[2];
                $country["num_end"] = $countryArray[3];
                $country["initials"] = $countryArray[4];
                $country["name"] = $countryArray[5];
                
                Country::Create($country);

                // Commit by 500 register
                if($key == 500) {
                    DB::commit();
                }

                /*
                if($key == 5000) {
                    break;
                }
                */
            }
        } catch (\Exception $e ){
            $this->error($e->getMessage());
            DB::rollBack();
        }

        $bar->finish();

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
        foreach($fieldsArray as $key => $field){
            $fieldsArray[$key] = str_replace('"', "", $field);
        }

        $fieldsArray[2] = intval($fieldsArray[2]);

        $fieldsArray[3] = intval($fieldsArray[3]);

        return $fieldsArray;
    }

}
