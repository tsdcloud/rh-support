<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MotifSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('motifs')->insert([
            [
                'motif'=>'Saisie érronée des données',
            ],
            [
                'motif'=>'Transmission des données/documents erronés ou inexploitables',
            ],
            [
                'motif'=>'Non transmission des livrables, de reporting dans les délais',
            ],
            [
                'motif'=>'Non remontée d\'informations sur l\'activité',
            ],
            [
                'motif'=>'Violation des consignes/procédures/procédés opérationnels',
            ],
            [
                'motif'=>'Non port des EPI',
            ],
            [
                'motif'=>'Absences injustifiées',
            ],
            [
                'motif'=>'Absences de longue durée',
            ],
            [
                'motif'=>'Absence du reporting des activités',
            ],
            [
                'motif'=>'Acte de violence physique/verbale/psychologique',
            ],
            [
                'motif'=>'Non respect du planning de Maintenance',
            ],
            [
                'motif'=>'Négligence/Détérioration/Destruction/Perte du matériel de travail',
            ],
            [
                'motif'=>'Violation du planning de travail',
            ],

            [
                'motif'=>'Problème de ponctualité au travail',
            ],
            [
                'motif'=>'Manquant sur versement des recettes',
            ],

            [
                'motif'=>'Vol/Détournement',
            ],
            [
                'motif'=>'Dissimulation des recettes',
            ],
            [
                'motif'=>'Problème d\'assiduité au travail',
            ],
            [
                'motif'=>'Rejet des factures/chèques/courriers émis',
            ],
            [
                'motif'=>'Dénigrement de l\'intégrité/image de l\'entreprise ou des salariés',
            ],
            [
                'motif'=>'Manquement à la déontologie et à l\'éthique',
            ],
            [
                'motif'=>'Mauvaise gestion des équipes/collaborateurs',
            ],

            [
                'motif'=>'Laxisme dans le suivi des opérations',
            ],

            [
                'motif' => 'Légèreté dans l\'exercice de vos fonctions',
            ],

            [
                'motif' => 'Accident de circulation',
            ],
            [
                'motif' => 'Non respect des instuction de le hiérarchie'
            ],
            [
                'motif' => 'Insubordination'
            ]
        ]);
        DB::table('motif_outdates')->insert([

            [
                'motif_id'=>13,
                'motif_outdate'=>'Négligence et mauvais usage des consommables en guérite',
            ],
            [
                'motif_id'=>13,
                'motif_outdate'=>'Dommages sur le téléphone de service',
            ],
            [
                'motif_id'=>13,
                'motif_outdate'=>'Injoingnable sur le téléphone de service',
            ],
            // 11
            [
                'motif_id'=>11,
                'motif_outdate'=>'Bagarre',
            ],
            [
                'motif_id'=>11,
                'motif_outdate'=>'Violence',
            ],
            // 10
            [
                'motif_id'=>10,
                'motif_outdate'=>'Refus de répondre à une demande d\'explications',
            ],
            [
                'motif_id'=>10,
                'motif_outdate'=>'Refus d\'exécuter l\'instruction de votre hiérachie',
            ],
            [
                'motif_id'=>10,
                'motif_outdate'=>'Refus de respecter les instructions',
            ],
            [
                'motif_id'=>10,
                'motif_outdate'=>'Non respect des consignes strictes de la hiérarchie',
            ],
            [
                'motif_id'=>10,
                'motif_outdate'=>'Attitude désinvolte durant votre service',
            ],
            [
                'motif_id'=>10,
                'motif_outdate'=>'Non exécution du travail demandé',
            ],
            [
                'motif_id'=>10,
                'motif_outdate'=>'Non-respect des instructions reçues',
            ],
            [
                'motif_id'=>10,
                'motif_outdate'=>'Insubordinnation',
            ],
        ]);
    }
}
