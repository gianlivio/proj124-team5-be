<?php

namespace Database\Seeders;

use App\Models\Apartment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Http\Controllers\Api\ApartmentController as ApiController;


class ApartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(ApiController $apiController): void
    {
        $apartmentsData = config('seeder-data');
        foreach ($apartmentsData as $index => $apartmentData) {
            $newApartment = new Apartment();
            $newApartment->fill($apartmentData);
            $response = $apiController->getAddressFromCoordinates($newApartment->latitude, $newApartment->longitude);
            $data = json_decode($response->getContent(), true);
            $newApartment->address = $data['address'];
            $newApartment->img_path = 'apartment_images/p' . ($index + 1) . '.webp';
            $newApartment->save();
        }
    }
}
