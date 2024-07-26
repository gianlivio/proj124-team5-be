<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Carbon\Carbon;
use App\Models\Apartment;
use Illuminate\Support\Facades\DB as DB;

class UpdateExpiredSponsorships extends Command
{
    protected $signature = 'sponsorships:update-expired';
    protected $description = 'Update expired sponsorships to the default sponsorship';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Define the default sponsorship ID
        $defaultSponsorshipId = 1;

        // Get the current date and time
        $now = Carbon::now();

        // Find all expired sponsorships
        $expiredSponsorships = DB::table('apartment_sponsorship')
            ->where('end_date', '<', $now)
            ->get();

        foreach ($expiredSponsorships as $sponsorship) {
            // Remove expired sponsorship entries from the pivot table
            DB::table('apartment_sponsorship')
                ->where('apartment_id', $sponsorship->apartment_id)
                ->where('sponsorship_id', $sponsorship->sponsorship_id)
                ->delete();

            // Find the highest priority active sponsorship
            $activeSponsorship = DB::table('apartment_sponsorship')
                ->where('apartment_id', $sponsorship->apartment_id)
                ->where('end_date', '>', $now)
                ->join('sponsorships', 'apartment_sponsorship.sponsorship_id', '=', 'sponsorships.id')
                ->orderBy('sponsorships.price', 'desc') // Assuming higher price means higher priority
                ->first();

            // Update the apartment's sponsorship_id based on the highest priority sponsorship
            if ($activeSponsorship) {
                Apartment::where('id', $sponsorship->apartment_id)
                    ->update(['sponsorship_id' => $activeSponsorship->sponsorship_id]);
            } else {
                // If no active sponsorships are left, set to the default sponsorship
                Apartment::where('id', $sponsorship->apartment_id)
                    ->update(['sponsorship_id' => $defaultSponsorshipId]);
            }
        }

        $this->info('Expired sponsorships have been updated.');
    }
}
