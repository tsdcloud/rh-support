<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EntitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('entities')->insert([
            [
                'title'=>'GI AREC',
                'sigle'=>'GI-AREC',
                'logo'=>'arec_logo.png',
                // 'logo'=>'bfc_logo.png',
            ],
            // [
            //     'title'=>'Douala Port Weighing Services',
            //     'sigle'=>'DPWS',
            //     'logo'=>'dpws_logo.png',
            // ],
        ]);
    }
}
