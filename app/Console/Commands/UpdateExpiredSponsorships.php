<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Carbon\Carbon;
use App\Models\Apartment;
use Illuminate\Support\Facades\DB as DB;

class UpdateExpiredSponsorships extends Command
{
    protected $signature = 'sponsorships:update-expired';
    protected $description = 'Update expired sponsorships in the apartments table';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $now = Carbon::now();
        $expiredSponsorships = DB::table('apartment_sponsorship')
            ->where('end_date', '<', $now)
            ->get();

        foreach ($expiredSponsorships as $sponsorship) {
            Apartment::where('id', $sponsorship->apartment_id)
                ->update(['sponsorship_id' => 1]);
        }

        $this->info('Expired sponsorships have been updated.');
    }
}

