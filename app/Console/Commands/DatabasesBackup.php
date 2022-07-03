<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;

class DatabasesBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup MySQL Database';

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
     * @return int
     */
    public function handle()
    {
        // \Log::info("Cron is working fine!");
        $filename = "database-backup-".Carbon::now()->format('Y-m-d_His').".gz";
        // $command = "mysqldump --user=u5863052_cermanapi --password=Zelincasch0706! --host=127.0.0.1 u5863052_cermanapi | gzip > ".storage_path()."/app/backup/".$filename;
        $command = "mysqldump --user=root --host=127.0.0.1 rest_api | gzip > ".storage_path()."/app/backup/".$filename;

        $returnVal = NULL;
        $output = NULL;

        exec($command, $returnVal, $output);
    }
}
