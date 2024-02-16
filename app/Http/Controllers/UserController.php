<?php

namespace App\Http\Controllers;

use App\Jobs\MultiUserImportJob;
use App\Mail\AjoutPrivilegeMail;
use App\Mail\CreationCompteMail;
use App\Mail\UpdatePasswordMail;
use App\Models\Category;
use App\Models\DecideurSanction;
use App\Models\Department;
use App\Models\Echelon;
use App\Models\Entity;
use App\Models\Fonction;
use App\Models\Grade;
use Illuminate\Support\Str;
use App\Models\Privilege;
use App\Models\Role;
use App\Models\User;
use App\Models\UserEntity;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Rap2hpoutre\FastExcel\FastExcel;
use Spatie\SimpleExcel\SimpleExcelWriter;


class UserController extends Controller
{
    public function profil($id){

        if(auth()->user()->id != $id){
            return back();
        }

        $entities = Entity::get();
        $grades = Grade::all();
        $departments = Department::all();
        $categories = Category::all();
        $echelons = Echelon::all();
        $roles = Role::all();
        $user = auth()->user();
        return view('users.profile', compact('user', 'entities','grades', 'departments', 'categories', 'echelons', 'roles'));
    }

    public function import_get()
    {
        $error_line[] = [];
        return view('users.import', compact('error_line'));
    }

    public function export(){

        $users = User::all();
        $data[] = [];
        $k = 0;
        foreach($users as $user){
            foreach($user->user_entity as $user_entity){
                foreach($user_entity->fonctions as $fonction){
                    $data[$k]['N°'] = $k + 1;
                    $data[$k]['NOMS ET PRENOMS'] = $user->fname . ' ' . $user->lname;
                    $data[$k]['EMAIL'] = $user->email;
                    $data[$k]['TELEPHONE'] = $user->phone;
                    $data[$k]['ENTITE'] = $user_entity->entity->sigle;
                    $data[$k]['FONCTION'] = $fonction->fonction;
                    $data[$k]['GRADE'] = $user_entity->grade->title;
                    $data[$k]['DEPARTEMENT'] = $fonction->department->sigle;
                    $data[$k]['CATEGORIE SOCIOPRO'] = Str::substr($fonction->category->title, -1) . '' . $fonction->echelon->title;
                    $k++;
                }
            }
        }

        $date = date('m-d-Y H:m:i');

        $writer = SimpleExcelWriter::streamDownload('user_export_'. $date .'.xlsx')
        ->addRows($data);
    }

    /**
     * function d'importation des utilisateurs et creation de leur compte
     * cette fonction prend en entree un fichier excel suivant le standard defini en documentation
     *
     * @param Request $request
     * @return void
     */
    public function import_store(Request $request)
    {
        $request->validate([
            'file'=> [
                'required',
                File::types(['xlsx'])
                    ->max(12 * 1024),
            ],
        ]);

        $sheets = (new FastExcel)->withSheetsNames()->importSheets($request->file);

        $error_line[] = [];
        $error_line = MultiUserImportJob::dispatch($sheets, $error_line);

        $error_line = $error_line->error_line();

        foreach($sheets as $entity => $sheet){
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
        return view('users.import', compact('error_line'));
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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        // $privileges = Privilege::all();

        $fonction = Fonction::find(session('fonction_id')['fonction_id']);
        $entity_id = $fonction->user_entity->entity_id;

        $users = User::where('deleted', false)->orderBy('id', 'DESC')->get();
        // $users = User::whereRelation('user_entity', 'entity_id', '=', $entity_id)->orderBy('id', 'DESC')->get();
        $entities = Entity::all();
        $grades = Grade::all();
        $departments = Department::all();
        $categories = Category::all();
        $echelons = Echelon::all();
        return view('users.index', compact('users', 'entities', 'grades', 'departments', 'categories', 'echelons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'fname'=>'required|string',
            'lname'=>'required|string',
            'email'=>'required|email',
            'phone'=>'required|numeric',
            'entity_id'=>'required|integer',
            'grade_id'=>'required|integer',
            'department_id'=>'required|integer',
            'fonction'=>'required|string',
            'category_id'=>'required|integer',
            'echelon_id'=>'required|integer',
        ],
        [
            'fname.required' => 'Le nom est requis',
            'lname.required' => 'Le prenom  est requis',
            'name.string' => 'Le nom doit être une chaîne de caractère',
            'lname.string' => 'Le prénom doit être une chaîne de caractère',
            'email.required' => 'L\'adresse email est requise',
            'phone.required' => 'Le numéro de téléphone est requis',
            'phone.numeric' => 'Le numéro de téléphone doit etre numerique',

            'entity_id.required' => 'Le choix de l\'entité est requis',
            'entity_id.integer' => 'L\'identifiant de l\'entité est incorrect',
            'grade_id.required' => 'Le choix du grade est requis',
            'grade_id.integer' => 'L\'identifiant du grade est incorrect',
            'department_id.required' => 'Le choix du département est requis',
            'department_id.integer' => 'L\'identifiant du département est incorrect',
            'fonction.required' => 'La fonction est requise',
            'fonction.string' => 'La fonction doit être une chaîne de caractère',

            'category_id.required' => 'Le choix de la catégorie est requise',
            'category_id.integer' => 'L\'identifiant de la catégorie est incorrect',
            'echelon_id.required' => 'Le choix de l\'échelon est requise',
            'echelon_id.integer' => 'L\'identifiant de l\'échelon est incorrect',
        ]);


        try{

            DB::beginTransaction();
            $user = User::Where('email', $data['email'])->first();

            if($user){
                $user_entity = $user->user_entity->where('entity_id', $data['entity_id'])->first();
                if($user_entity){
                    $fonction = $user_entity->fonctions->where('fonction', $data['fonction'])->first();

                    if(!$fonction){
                        Fonction::create([
                            'fonction' =>  $data['fonction'],
                            'user_entity_id' => $user_entity->id,
                            'category_id' => $data['category_id'],
                            'echelon_id' => $data['echelon_id'],
                            'department_id' => $data['department_id'],
                        ]);
                        // $this->fonction($line, $user_entity->id, $data['category_id'], $data['echelon_id'], $data['department_id']);
                    }else{
                        alert()->error('Attention','Ce compte utilisateur est déjà créé');
                        return back();
                    }
                }else{
                    $user_entity =  $user_entity = UserEntity::create([
                        'user_id' => $user->id,
                        'grade_id' => $data['grade_id'],
                        'entity_id'=>$data['entity_id'],
                    ]);

                    Fonction::create([
                        'fonction' =>  $data['fonction'],
                        'user_entity_id' => $user_entity->id,
                        'category_id' => $data['category_id'],
                        'echelon_id' => $data['echelon_id'],
                        'department_id' => $data['department_id'],
                    ]);
                }
            }else{
                $data['password'] = Hash::make('password');
                $user = User::create($data);

                $user_entity = UserEntity::create([
                    'user_id' => $user->id,
                    'grade_id' => $data['grade_id'],
                    'entity_id'=>$data['entity_id'],
                ]);

                $data['user_entity_id'] = $user_entity->id;
                $fonction = Fonction::create($data);

                $mailData = [
                    'user' => $user
                ];

                Mail::to($user->email)->send(new CreationCompteMail($mailData));
            }


            if($request->decideur_sanction){
                if(!DecideurSanction::where('entity_id', $data['entity_id'])->exists()){
                    DecideurSanction::create([
                        'entity_id' => $data['entity_id'],
                        'decision_sur' => 'demande_explication',
                        'user_id' => $user->id,
                    ]);
                }
            }
            DB::commit();

        }catch(\Exception $e){
            DB::rollback();
            alert()->error('Opération échouée','Une erreur s\'est produite. Veuillez reprendre');
        }


        alert()->success('Opération réussie','Utilisateur ajouté avec succès');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        // dump($user);
        // $user =  User::find(auth()->user()->id);

        $entities = Entity::get();
        $grades = Grade::all();
        $departments = Department::all();
        $categories = Category::all();
        $echelons = Echelon::all();
        $roles = Role::all();
        // $roles = 
        return view('users.show', compact('user', 'entities','grades', 'departments', 'categories', 'echelons', 'roles'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $user = User::find($id);

        // dump($id);
        // dump($user->email);
        // dd($user->id);
        $data = $request->validate([
            'fname'=>'required|string',
            'lname'=>'required|string',
            // 'email' => ['required', 'email'],
            'email' => ['required', 'email',Rule::unique('users')->ignore($user->id)],
            // 'email' => ['required', 'email:rfc,dns',Rule::unique('users')->ignore($user->id)],
            'phone'=>'required|numeric',
        ],[
            'fname.string' => 'Le nom doit etre une chaine de caractères',
            'lname.string' => 'Le prénom doit etre une chaine de caractères',
            'phone.numeric' => 'Le numéro doit etre de type numérique',
            'email.email' => 'L\'adresse email ne respecte pas le standard libele@domaine.com',
            'email.unique' => 'Cette adresse email est déjà utilisé',
        ]);

        // dd($data);

        if($request->password){
            $password = $request->validate([
                'password' => 'required|string|min:8|confirmed'
            ],
            [
                'password.confirmed' => 'Les mots de passe ne correspondent pas',
            ]);

            $data['password'] = Hash::make($password['password']);
        }

        // if($request->has('picture')){

        //     $request->validate([
        //         'picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        //     ],[
        //         'picture.required' => 'le choix d\'image est requis',
        //         'picture.image' => 'le fichier choisi doit etre de type image',
        //         'picture.max' => 'la taille maximale du fichier choisi est 2048 octects',
        //         'picture.mimes' => 'le fichier choisi doit etre de type image(jpeg, png, jpg, gif, svg)',
        //     ]);
        //     $fileName = time().'.'.$request->picture->extension();
        //     $request->picture->move(public_path('images'), $fileName);

        //     $user->picture = $fileName;
        // }

        $user->update($data);

        $mailData = [
            'user' => $user,
            'password' => $request->password,
        ];

        Mail::to($user->email)->send(new UpdatePasswordMail($mailData));

        // dump($data);
        // dd($request->all());
        // $user_privilege = [
        //     'user_id'=> $user->id,
        //     'privlege_id'=> $data['privilege']
        // ];
        // $user->getPrivileges()->sync($user_privilege);

        alert()->success('Opération réussie', 'Utilisateur mis à jour avec succès');

        return back()->with('success', 'Utilisateur mis à jour avec succès');
    }

    public function update_function(Request $request, Fonction $fonction){
        // dd($request->all());
        $request->validate([
            'fonction' => 'required',
        ],[
            'fonction.required' => 'Le champ fonction est requis'
        ]);

        DB::beginTransaction();
            $fonction->update($request->all());
            $fonction->user_entity->update($request->all());
        DB::commit();

        alert()->success('Opération réussie', 'Fonction utilisateur mis à jour avec succès');
        return back()->with('success', 'Fonction utilisateur mis à jour avec succès');
    }

    public function store_privilege(Request $request, User $user){
        $request->validate([
            'role_id'=>'required|integer',
            'entity_id'=>'required|integer'
        ]);

        DB::beginTransaction();
            
        
            if($request->role_id == 0){
                if(!$user->isDecideurSanction()){
                    // dd($user->id);
                    DecideurSanction::create([
                        'decision_sur'=> 'demande_explication',
                        'user_id'=> $user->id,
                    ]);
                }else{
                    alert()->error('Attention', 'Cet utilisateur a déjà ce privilège');
                    return back();
                }

            }else{

                $privilege = Privilege::where([
                    'user_id' => $user->id,
                    'role_id' => $request->role_id,
                    'entity_id' => $request->entity_id,
                ])->first();
    
                if(empty($privilege)){
                    Privilege::create([
                        'user_id' => $user->id,
                        'role_id' => $request->role_id,
                        'entity_id' => $request->entity_id,
                        ]);
                        
                        $role = Role::find($request->role_id);
                        $entity = Entity::find($request->entity_id);
                        $mailData = [
                            'user' => $user,
                            'privilege' => $role->title,
                            'entity' => $entity->sigle,
                        ];
                        
                        Mail::to($user->email)->send(new AjoutPrivilegeMail($mailData));
                }else{
                    alert()->error('Attention', 'Cet utilisateur a déjà ce privilège');
                    return back();
                }
            }



        DB::commit();

        alert()->success('Opération réussie', 'Privilège utilisateur ajouté avec succès');
        return back()->with('success', 'Privilège utilisateur ajouté avec succès');
    }

    public function update_privilege(){
        return back();
    }
    public function remove_privilege(User $user){

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $user = User::findOrfail($id);

        $user->deleted = true;
        $user->update();
        alert()->success('Opération réussie','Utilisateur supprimé avec succès');
        return back()->with('Opération réussie', 'Utilisateur supprimé avec succès');
    }
}
