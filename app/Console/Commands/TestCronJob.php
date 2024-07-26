<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log as FacadesLog;


class TestCronJob extends Command
{
    protected $signature = 'test:cronjob';
    protected $description = 'Test if cron job is running';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        FacadesLog::info('Cron job is running at ' . now());
    }
}