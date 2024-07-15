<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\KontrakController;

class SyncDataSOP extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-data-sop';

    /**
     * The console command description.
     *
     * @var string
     */
    // protected $description = 'Sinkronisasi data SOP Terbaru dari SCM';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // //KODE
        // $kontrakController = new KontrakController();
        // $kontrakController->syncron();

        // $this->info('Data SOP Berhasil di Sinkronisasi!');
    }
}
