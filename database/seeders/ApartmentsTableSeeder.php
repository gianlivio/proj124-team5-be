<?php

namespace Database\Seeders;

use App\Models\Apartment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $apartmentsData = config('seeder-data');
        foreach ($apartmentsData as $apartmentData) {
            $newApartment = new Apartment();
            // $newApartment->title = $apartmentData["title"];
            // $newApartment->rooms = $apartmentData["rooms"];
            // $newApartment->beds = $apartmentData["beds"];
            // $newApartment->bathroom = $apartmentData["bathroom"];
            // $newApartment->square_mt = $apartmentData["square_mt"];
            // $newApartment->available = $apartmentData["available"];
            // $newApartment->latitude = $apartmentData["latitude"];
            // $newApartment->longitude = $apartmentData["longitude"];
            $newApartment->fill($apartmentData);
            $newApartment->save();
        }
    }
}
