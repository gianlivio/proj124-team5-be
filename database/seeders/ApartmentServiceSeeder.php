<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApartmentServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $apartments = 75;
        $services = 12;

        $data = [];

        for ($i = 1; $i <= $apartments; $i++) {
            $num_services = rand(1, $services);
            
            $service_ids = array_rand(array_flip(range(1, $services)), $num_services);

            if (!is_array($service_ids)) {
                $service_ids = [$service_ids];
            }

            foreach ($service_ids as $service_id) {
                $data[] = [
                    'apartment_id' => $i,
                    'service_id' => $service_id,
                ];
            }
        }

        DB::table('apartment_service')->insert($data);
    }
}
