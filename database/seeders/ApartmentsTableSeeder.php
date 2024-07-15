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
            $newApartment->fill($apartmentData);
            $newApartment->save();
        }
    }
}
