<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services =  [
            'Aria Condizionata',
            'Wi-Fi',
            'Parcheggio',
            'Piscina',
            'TV via cavo'
        ];

        foreach ($services as $service) {
            $newService = new Service();
            $newService->title = $service;
            $newService->save();
        }
    }
}
