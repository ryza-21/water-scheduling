<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WaterSource;
use App\Models\AccessRequest;
use App\Models\AccessRecord;
use Carbon\Carbon;

class WaterDataSeeder extends Seeder
{
    public function run(): void
    {
        $source1 = WaterSource::updateOrCreate(
            ['source_id' => '#SRC-001'],
            [
                'source_name' => 'Main Intake Station - Surigao',
                'location' => 'Brgy. San Juan, Surigao del Norte',
                'capacity' => '5,000 Liters',
                'status' => 'Active',
            ]
        );

        $source2 = WaterSource::updateOrCreate(
            ['source_id' => '#SRC-002'],
            [
                'source_name' => 'Community Spring Reservoir',
                'location' => 'Brgy. Luna, Surigao del Norte',
                'capacity' => '3,200 Liters',
                'status' => 'Active',
            ]
        );

        $req1 = AccessRequest::firstOrCreate(
            ['request_code' => 'REQ-2026-001'],
            [
                'user_name' => 'Xyra Feche',
                'user_email' => 'xf@gmail.com',
                'requested_source' => $source1->source_name,
                'preferred_date' => Carbon::now()->addDays(1),
                'purpose' => 'Household consumption and community supply replenishment',
                'estimated_volume' => '200 Liters',
                'status' => 'Pending',
                'submitted_at' => Carbon::now()->subHours(2),
            ]
        );

        AccessRequest::firstOrCreate(
            ['request_code' => 'REQ-2026-002'],
            [
                'user_name' => 'Juan Dela Cruz',
                'user_email' => 'juandelacruz@gmail.com',
                'requested_source' => $source2->source_name,
                'preferred_date' => Carbon::now()->addDays(2),
                'purpose' => 'Agricultural and gardening irrigation',
                'estimated_volume' => '500 Liters',
                'status' => 'Approved',
                'submitted_at' => Carbon::now()->subDays(1),
            ]
        );

        AccessRecord::firstOrCreate(
            ['record_code' => 'REC-99881'],
            [
                'access_request_id' => $req1->id,
            ]
        );
    }
}