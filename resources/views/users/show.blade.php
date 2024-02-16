@extends('layouts.master')

@section('title', 'Utilisateurs')

@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="col-md-6 col-12 mb-2">
            <h3 class="content-header-title">Profil de {{ $user->fname }} {{ $user->lname }}</h3>
        </div>
        <div class="col-md-6 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb float-md-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">Accueil</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Profil
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body"><!-- Zero configuration table -->
        <section id="configuration">
            <div class="row">
                <div class="col-12">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="card">
                        <div class="text-center">
                            <div class="card-body">
                                <img src="{{ asset('images/default_profil.jpg') }}" class="rounded-circle  height-150"
                                alt="Card image">
                            </div>
                            <div class="card-body">
                                <h4 class="card-title"> {{ $user->lname}} {{ $user->fname }}</h4>
                                <h6 class="card-subtitle text-muted">

                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="text-left">
                            <div class="card-body">
                                <h4 class="card-title ml-1"> Modifier ces informations</h4>

                                <form action="{{ route('users.update', $user->id) }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="form-body">

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="fname">Nom</label>
                                                        <input type="text" name="fname" id="fname" value="{{ old('fname', $user->fname) }}" class="form-control  @error('fname') is-invalid @enderror" placeholder="Nom" required>
                                                        @error('fname')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="lname">Prénom</label>
                                                        <input type="text" name="lname" id="lname" value="{{ old('lname', $user->lname) }}" class="form-control  @error('lname') is-invalid @enderror" placeholder="Prénom"  required>
                                                        @error('lname')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="email">E-mail</label>
                                                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="form-control  @error('email') is-invalid @enderror" placeholder="E-mail" required>
                                                        @error('email')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="phone">Téléphone</label>
                                                        <input type="tel" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" class="form-control  @error('phone') is-invalid @enderror" placeholder="Téléphone" required>
                                                        @error('phone')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="password">Mot de passe</label>
                                                        <input type="password" name="password" id="password" class="form-control @error('password')
                                                            is-invalid
                                                        @enderror" placeholder="Mot de passe">
                                                        @error('password')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="password-confirmation">Confirmation de mot de passe</label>
                                                        <input type="password" name="password_confirmation" id="password-confirmation" class="form-control" placeholder="Confirmation de mot de passe">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer row" style="margin-right: 0px!important;margin-left: 0px!important;">
                                        <div class="col" style="margin-left: -15px!important;">

                                        </div>
                                        <div class="col" style="margin-right: -15px!important;">
                                            <button type="submit" class="btn btn-success float-right">
                                                <i class="ft-plus"></i>
                                                Mettre à jour
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <section id="drag-area">
                        <div class="row">
                            <div class="col-12 my-1">
                                <h4 class="text-uppercase">Informations supplémentaires</h4>
                                <hr>
                            </div>
                        </div>
                    
                        <div class="row" id="card-drag-area">
                            <div class="col-md-12 col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Gestion des fonctions</h4>
                                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                        <div class="heading-elements visible">
                                            <ul class="list-inline mb-0">
                                                {{-- <li><a data-action="collapse"><i class="ft-minus"></i></a></li> --}}
                                                {{-- <li><a data-action="close"><i class="ft-x"></i></a></li> --}}
                                                <li>
                                                    <button class="btn btn-success" type="button"  data-toggle="modal" data-target="#addfonction">
                                                        <i class="ft-settings"></i> Ajouter une fonction
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="card-content collapse show">
                                        <div class="card-body table-responsive">
                                            <table class="table table-striped w-100">
                                                <thead>
                                                    <tr class="bg-dark text-white">
                                                        <th scope="col" class="text-center">#N°</th>
                                                        <th scope="col" class="text-center">Entité</th>
                                                        <th scope="col" class="text-center">Grade</th>
                                                        <th scope="col" class="text-center">Département</th>
                                                        <th scope="col">Catégorie</th>
                                                        <th scope="col" class="text-center">Echélon</th>
                                                        <th scope="col" class="text-center">Fonction</th>
                                                        <th scope="col" class="text-center">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $k = 1;
                                                    @endphp
                                                    @foreach ($user->user_entity as $user_entity)
                                                        @foreach ($user_entity->fonctions as $fonction)
                                                            <tr class="scope">
                                                                <th scope="col" class="text-center">{{ $k }}</th>
                                                                <td scope="col" class="text-center">{{ $user_entity->entity->sigle}}</td>
                                                                <td scope="col" class="text-center">{{ $user_entity->grade->title }}</td>
                                                                <td scope="col" class="text-center">
                                                                    {{ $fonction->department->sigle}}
                                                                </td>
                                                                <td scope="col" class="text-center">{{ substr($fonction->category->title, -2) }}</td>
                                                                <td scope="col" class="text-center">
                                                                    {{ $fonction->echelon->title}}
                                                                </td>
                                                                <td scope="col" class="text-center">{{ $fonction->fonction }}</td>
                                                                <td scope="col" class="text-center">
                                                                    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#fonction{{ $fonction->id }}">
                                                                        <i class="ft-edit"></i> Modifier
                                                                    </a>
                                                                    <a href="#" class="btn btn-danger">
                                                                        <i class="ft-trash-2"></i> Supprimer
                                                                    </a>
                                                                    
                                                                    <div class="modal fade text-left" id="fonction{{ $fonction->id }}" tabindex="-1" role="dialog" aria-labelledby="addusers"
                                                                        aria-hidden="true">
                                                                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">                                                   
                                                                                    <h4 class="modal-title" id="addusers"><i class="ft-user"></i> Mettre à jour une fonction</h4>
                                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                        <span aria-hidden="true">&times;</span>
                                                                                    </button>
                                                                                </div>
                                
                                                                                <form action="{{ route('users.update.fonction', $fonction->id) }}" method="post" enctype="multipart/form-data">
                                                                                    @csrf
                                                                                    @method('PUT')
                                                                                    <div class="modal-body">
                                                                                        <div class="form-body">                                
                                                                                            <div class="row">
                                                                                                <div class="col-md-4">
                                                                                                    <div class="form-group">
                                                                                                        <label for="entity_id">Entité<span class="text-danger"><sub>*</sub></span></label>
                                                                                                        <select id="entity_id" name="entity_id" class="form-control @error('entity_id') is-invalid @enderror" required>
                                                                                                            @foreach ($entities as $entity)
                                                                                                                <option value="{{ $entity->id }}" {{ $user_entity->entity->id == $entity->id ? 'selected':''}}>{{ $entity->sigle }}</option>
                                                                                                            @endforeach
                                                                                                        </select>
                                                                                                    </div>
                                                                                                    @error('entity_id')
                                                                                                        <span class="invalid-feedback" role="alert">
                                                                                                            <strong>{{ $message }}</strong>
                                                                                                        </span>
                                                                                                    @enderror
                                                                                                </div>
                                                                                                <div class="col-md-4">
                                                                                                    <div class="form-group">
                                                                                                        <label for="grade_id">Grade<span class="text-danger"><sub>*</sub></span></label>
                                                                                                        <select id="grade_id" name="grade_id" class="form-control @error('grade_id') is-invalid @enderror" required>
                                                                                                            @foreach ($grades as $grade)
                                                                                                                <option value="{{ $grade->id }}" {{ $user_entity->grade->id == $grade->id ? 'selected':'' }}>{{ $grade->title }}</option>
                                                                                                            @endforeach
                                                                                                        </select>
                                                                                                    </div>
                                                                                                    @error('grade_id')
                                                                                                        <span class="invalid-feedback" role="alert">
                                                                                                            <strong>{{ $message }}</strong>
                                                                                                        </span>
                                                                                                    @enderror
                                                                                                </div>
                                                                                                <div class="col-md-4">
                                                                                                    <div class="form-group">
                                                                                                        <label for="department_id">Département<span class="text-danger"><sub>*</sub></span></label>
                                                                                                        <select id="department_id" name="department_id" class="form-control @error('department_id') is-invalid @enderror" required>
                                                                                                            @foreach ($departments as $department)
                                                                                                                <option value="{{ $department->id }}" {{ $fonction->department->id == $department->id ? 'selected':'' }}>{{ $department->title }}</option>
                                                                                                            @endforeach
                                                                                                        </select>
                                                                                                    </div>
                                                                                                    @error('department_id')
                                                                                                        <span class="invalid-feedback" role="alert">
                                                                                                            <strong>{{ $message }}</strong>
                                                                                                        </span>
                                                                                                    @enderror
                                                                                                </div>
                                                                                            </div>
                                                                                            
                                                                                            <div class="row">
                                                                                                <div class="col-md-4">
                                                                                                    <div class="form-group">
                                                                                                        <label for="fonction">Fonction<span class="text-danger"><sub>*</sub></span></label>
                                                                                                        <input type="text" id="fonction" name="fonction" value="{{ old('fonction', $fonction->fonction) }}" class="form-control @error('fonction') is-invalid @enderror" placeholder="Titre de la fonction" required>
                                                                                                    </div>
                                                                                                    @error('fonction')
                                                                                                        <span class="invalid-feedback" role="alert">
                                                                                                            <strong>{{ $message }}</strong>
                                                                                                        </span>
                                                                                                    @enderror
                                                                                                </div>
                                                                                                <div class="col-md-4">
                                                                                                    <div class="form-group">
                                                                                                        <label for="category_id">Catégorie<span class="text-danger"><sub>*</sub></span></label>
                                                                                                        <select id="category_id" name="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                                                                                                            @foreach ($categories as $category)
                                                                                                                <option value="{{ $category->id }}" {{ $fonction->category->id == $category->id ? 'selected':'' }}>{{ $category->title }}</option>
                                                                                                            @endforeach
                                                                                                        </select>
                                                                                                    </div>
                                                                                                    @error('category_id')
                                                                                                        <span class="invalid-feedback" role="alert">
                                                                                                            <strong>{{ $message }}</strong>
                                                                                                        </span>
                                                                                                    @enderror
                                                                                                </div>
                                                                                                <div class="col-md-4">
                                                                                                    <div class="form-group">
                                                                                                        <label for="echelon_id">Echelon<span class="text-danger"><sub>*</sub></span></label>
                                                                                                        <select id="echelon_id" name="echelon_id" class="form-control @error('echelon_id') is-invalid @enderror" required>
                                                                                                            @foreach ($echelons as $echelon)
                                                                                                                <option value="{{ $echelon->id }}" {{ $fonction->echelon->id == $echelon->id ? 'selected':'' }}>{{ $echelon->title }}</option>
                                                                                                            @endforeach
                                                                                                        </select>
                                                                                                    </div>
                                                                                                    @error('echelon_id')
                                                                                                        <span class="invalid-feedback" role="alert">
                                                                                                            <strong>{{ $message }}</strong>
                                                                                                        </span>
                                                                                                    @enderror
                                                                                                </div>
                                                                                                {{-- <div class="col-md-3 d-flex align-items-center">
                                                                                                    <div class="form-group row w-100">
                                                                                                        <div class="col-md-9 d-flex align-items-center">
                                                                                                            <label for="decideur_sanction">Décideur de sanction ?</span></label>
                                                                                                        </div>
                                                                                                        <div class="col-md-3">
                                                                                                            <input type="checkbox" id="decideur_sanction" name="decideur_sanction" class="form-control @error('decideur_sanction') is-invalid @enderror">
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div> --}}
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="modal-footer row" style="margin-right: 0px!important;margin-left: 0px!important;">
                                                                                        <div class="col" style="margin-left: -15px!important;">
                                                                                            <button type="button" class="btn grey btn-danger" data-dismiss="modal">
                                                                                                <i class="ft-x"></i>
                                                                                                Fermer
                                                                                            </button>
                                                                                        </div>
                                                                                        <div class="col" style="margin-right: -15px!important;">
                                                                                            <button type="submit" class="btn btn-success float-right">
                                                                                                <i class="ft-plus"></i>
                                                                                                Mettre à jour 
                                                                                            </button>
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            @php
                                                                $k++;
                                                            @endphp
                                                        @endforeach
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    
                            <div class="col-md-12 col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Gestion des privileges</h4>
                                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                        <div class="heading-elements">
                                            <ul class="list-inline mb-0">
                                                {{-- <li><a data-action="collapse"><i class="ft-plus"></i></a></li> --}}
                                                <li>
                                                    @include('includes.add_user_privilege')
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="card-content collapse show">
                                        <div class="card-body table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr class="bg-dark text-white">
                                                        <th scope="col" class="text-center">#N°</th>
                                                        <th scope="col" class="text-center">Intitulé du privilege</th>
                                                        <th scope="col" class="text-center">Enitité</th>
                                                        <th scope="col" class="text-center">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $k = 1;
                                                    @endphp
                                                    @forelse ($user->privileges as $privilege)
                                                        <tr class="scope">
                                                            <th scope="col" class="text-center">{{ $k }}</td>
                                                            <th scope="col" class="text-center">{{ $privilege->role->title }}</td>
                                                            <th scope="col" class="text-center">{{ $privilege->entity->sigle }}</td>
                                                            <th scope="col" class="text-center">
                                                                <a href="#" class="btn btn-danger">
                                                                    <i class="ft-trash-2"></i> Rétirer
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        @php
                                                            $k++;
                                                        @endphp
                                                    @empty
                                                        <tr class="scope">
                                                            <th scope="col" class="text-center" colspan="3">
                                                                Aucun privilège pour cet utilisateur
                                                            </th>
                                                        </tr>
                                                    @endforelse
                                                    @if($k>1 && $user->isDecideurSanction())
                                                        <tr class="scope">
                                                            <th scope="col" class="text-center">{{ $k }}</td>
                                                            <th scope="col" colspan="2" class="text-center">Décideur des sanctions</td>
                                                            {{-- <th scope="col" class="text-center">{{ $privilege->entity->sigle }}</td> --}}
                                                            <th scope="col" class="text-center">
                                                                <button type="button" class="btn btn-danger" onclick="document.getElementById('btn_remove_privilege_{{ $user->id}}').click();">
                                                                    <i class="ft-trash-2"></i> Rétirer
                                                                </button>
                                                                <form action="{{ route('users.remove_privilege', $user->id) }}" method="post" class="d-none">
                                                                    @csrf
                                                                    <button type="submit" class="btn-primary btn" id="btn_remove_privilege_{{ $user->id }}" onclick="confirm('Vous allez supprimer cet utilisateur');">
                                                                        supprimer
                                                                    </button>
                                                                </form>
                                                                {{-- <livewire:remove-user-privilege :user_id="$user->id" :privilege_id="0"/> --}}

                                                                {{-- <a href="#" class="btn btn-danger">
                                                                    <i class="ft-trash-2"></i> Rétirer
                                                                </a> --}}
                                                            </td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section><!-- // Card drag area section end -->
                </div>
            </div>
        </section>
        <!--/ Zero configuration table -->
    </div>
</div>

@endsection
{{-- -------------------------------- styles -------------------------------------- --}}

@section('styles')
    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/datatable/datatables.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/animate/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/extensions/sweetalert2.min.css') }}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/bootstrap-extended.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/colors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/components.min.css') }}">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/menu/menu-types/horizontal-menu.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/colors/palette-gradient.min.css') }}">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <!-- END: Custom CSS-->
@endsection
{{-- --------------------------------scripts -------------------------------------- --}}
@section('scripts')
<!-- BEGIN: Vendor JS-->
<script src="{{ asset('app-assets/vendors/js/vendors.min.js') }}"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
<script src="{{ asset('app-assets/vendors/js/ui/jquery.sticky.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/charts/jquery.sparkline.min.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/tables/datatable/datatables.min.js') }}"></script>


<!-- BEGIN: Theme JS-->
<script src="{{ asset('app-assets/js/core/app-menu.min.js') }}"></script>
<script src="{{ asset('app-assets/js/core/app.min.js') }}"></script>
<script src="{{ asset('app-assets/js/scripts/customizer.min.js') }}"></script>
<script src="{{ asset('app-assets/js/scripts/footer.min.js') }}"></script>
<!-- END: Theme JS-->

<!-- BEGIN: Page JS-->
<script src="{{ asset('app-assets/js/scripts/ui/breadcrumbs-with-stats.min.js') }}"></script>
<script src="{{ asset('app-assets/js/scripts/tables/datatables/datatable-basic.min.js')}}"></script>

@stack('scripts')
@endsection

