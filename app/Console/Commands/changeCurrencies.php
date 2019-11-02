<?php

namespace App\Console\Commands;
use App\Clases\ChangeCurrency;
use Illuminate\Console\Command;

class changeCurrencies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'changeCurrencies';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Changed currency';

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
        return new changeCurrency();
    }
}
