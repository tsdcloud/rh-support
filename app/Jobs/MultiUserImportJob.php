<?php

namespace App\Jobs;

use App\Mail\CreationCompteMail;
use App\Models\Category;
use App\Models\Department;
use App\Models\Echelon;
use App\Models\Entity;
use App\Models\Fonction;
use App\Models\Grade;
use App\Models\User;
use App\Models\UserEntity;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class MultiUserImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $sheets;
    public $error_line;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($sheets, $error_line)
    {
        $this->sheets = $sheets;
        $this->error_line = $error_line;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(){
        $error_line[] = [];
        foreach($this->sheets as $entity => $sheet){
            $k = 1;
            $entity_sigle = $entity;
            $entity = Entity::where('sigle', $entity)->first();
            foreach($sheet as $line){
                $grade = Grade::where('title', $line['GRADE'])->first();
                $category = Category::find($line['CATEGORIE']);
                $echelon = Echelon::where('title', $line['ECHELON'])->first();
                $department = Department::where('sigle', $line['DEPARTEMENT'])->first();

                try{
                    DB::beginTransaction();
                        $user = User::Where('email', $line['EMAIL'])->first();

                        if($user){
                            $user_entity = $user->user_entity->where('entity_id', $entity->id)->first();
                            if($user_entity){
                                $fonction = $user_entity->fonctions->where('fonction', $line['FONCTION'])->first();
                                if(!$fonction){
                                    $this->fonction($line, $user_entity->id, $category->id, $echelon->id, $department->id);
                                }
                            }else{
                                $user_entity = $this->user_entity($user, $grade->id, $entity->id);

                                $this->fonction($line, $user_entity->id, $category->id, $echelon->id, $department->id);
                            }
                        }else{
                            $user = $this->user($line);

                            $user_entity = $this->user_entity($user, $grade->id, $entity->id);

                            $this->fonction($line, $user_entity->id, $category->id, $echelon->id, $department->id);

                            $mailData = [
                                'user' => $user
                            ];

                            Mail::to($user->email)->send(new CreationCompteMail($mailData));
                        }
                        
                    DB::commit();
                }catch(\Exception $e){
                    $error_line[$entity_sigle][$k] = $line['N°'];
                }
                $k ++;
            }
        }

        $this->error_line = $error_line;
    }

    public function error_line(){
        return $this->error_line;
    }

    public function user($line){
        return User::create([
            'fname' => $line['NOM'],
            'lname' => $line['PRENOM'],
            'phone' => $line['TELEPHONE'],
            'email' => $line['EMAIL'],
            'password' => Hash::make('password'),
        ]);
    }
    public function user_entity($user, $grade_id, $entity_id){
        return UserEntity::create([
            'user_id' => $user->id,
            'grade_id' => $grade_id,
            'entity_id' => $entity_id,
        ]);
    }
    public function fonction($line, $user_entity_id, $category_id, $echelon_id, $department_id){
        return Fonction::create([
            'fonction' => $line['FONCTION'],
            'user_entity_id' => $user_entity_id,
            'category_id' => $category_id,
            'echelon_id' => $echelon_id,
            'department_id' => $department_id,
        ]);
    }
}
