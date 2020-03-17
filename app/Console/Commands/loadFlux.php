<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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

        $this->call('--version');

        //$this->artisan

        $this->info('End Flux');
    }
}
