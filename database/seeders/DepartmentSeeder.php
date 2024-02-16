<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments')->insert([
            [
                'title'=>'Information Technology',
                'sigle'=>'IT',
            ],
            [
                'title'=>'Humans Ressources',
                'sigle'=>'HR',
            ],
            [
                'title'=>'Opérations',
                'sigle'=>'Opérations',
            ],
            [
                'title'=>'Direction des Affaires Financières',
                'sigle'=>'DAF',
            ],
            [
                'title'=>'Direction Générale',
                'sigle'=>'DG',
            ],
        ]);
    }
}
