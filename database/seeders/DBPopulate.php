<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\City;
use App\Models\User;
use Illuminate\Database\Seeder;

class DBPopulate extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities = City::factory()->count(100000)->create();

        $cities->each(function ($city) {
            $user = User::factory()->create();

            Address::factory()->create([
                'user_id' => $user->id,
                'city_id' => $city->id
            ]);
        });
    }
}
