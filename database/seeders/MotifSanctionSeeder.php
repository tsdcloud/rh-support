<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MotifSanctionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('motif_sanctions')->insert([
            [
                'motif' => 'Pas de sanction',
            ],
            [
                'motif' => 'Rappel à l\'ordre',
            ],
            [
                'motif' => 'Avertissement',
            ],
            [
                'motif' => 'Blâme',
            ],
            [
                'motif' => 'Mise à pieds d\'un (01) jours',
            ],
            [
                'motif' => 'Mise à pieds de deux (02) jours',
            ],
            [
                'motif' => 'Mise à pieds de trois (03) jours',
            ],
            [
                'motif' => 'Mise à pieds de quatre (04) jours',
            ],
            [
                'motif' => 'Mise à pieds de cinq (05) jours',
            ],
            [
                'motif' => 'Mise à pieds de six (06) jours',
            ],
            [
                'motif' => 'Mise à pieds de sept (07) jours',
            ],
            [
                'motif' => 'Mise à pieds de huit (08) jours',
            ],            [
                'motif' => 'Licenciement',
            ],

            [
                'motif' => 'Imputation sur salaire'
            ],
            [
                'motif' => 'Avertissement + Imputation sur salaire',
            ],[
                'motif' => 'Blâme + Imputation sur salaire',
            ]
        ]);
    }
}
