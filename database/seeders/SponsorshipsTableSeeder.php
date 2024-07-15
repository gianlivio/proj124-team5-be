<?php

namespace Database\Seeders;

use App\Models\Sponsorship;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SponsorshipsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sponsorshipsData = config('sponsorships-data');
        foreach ($sponsorshipsData as $sponsorshipData) {
            $newsponsorship = new Sponsorship();
            $newsponsorship->fill($sponsorshipData);
            $newsponsorship->save();
        }
    }
}
