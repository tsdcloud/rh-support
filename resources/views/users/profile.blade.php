@extends('layouts.master')

@section('title', 'Utilisateurs')

@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="col-md-6 col-12 mb-2">
            <h3 class="content-header-title">Mon profil</h3>
        </div>
        <div class="col-md-6 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb float-md-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">Accueil</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Mon profil
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
                                <h4 class="card-title"> {{ auth()->user()->lname}} {{ auth()->user()->fname }}</h4>
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
                                <h4 class="card-title ml-1"> Modifier mes informations</h4>
                                
                                <form action="{{ route('users.update', auth()->user()->id) }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="form-body">

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="fname">Nom</label>
                                                        <input type="text" name="fname" id="fname" value="{{ old('fname', auth()->user()->fname) }}" class="form-control  @error('fname') is-invalid @enderror" placeholder="Nom" required>
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
                                                        <input type="text" name="lname" id="lname" value="{{ old('lname', auth()->user()->lname) }}" class="form-control  @error('lname') is-invalid @enderror" placeholder="Prénom"  required>
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
                                                        <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email) }}" class="form-control  @error('email') is-invalid @enderror" placeholder="E-mail" required>
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
                                                        <input type="tel" name="phone" id="phone" value="{{ old('phone', auth()->user()->phone) }}" class="form-control  @error('phone') is-invalid @enderror" placeholder="Téléphone" required>
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

                                            <div class="row">

                                                
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
                                        <h4 class="card-title">Liste des fonctions</h4>
                                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                        <div class="heading-elements visible">
                                            <ul class="list-inline mb-0">
                                                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                                <li><a data-action="close"><i class="ft-x"></i></a></li>
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
                                        <h4 class="card-title">Liste des privilèges</h4>
                                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                        <div class="heading-elements">
                                            <ul class="list-inline mb-0">
                                                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                                <li><a data-action="close"><i class="ft-x"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="card-content collapse show">
                                        <div class="card-body table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr class="bg-dark text-white">
                                                        <th scope="col" class="text-center">#N°</th>
                                                        <th scope="col" class="text-center">Intitulé du privilège</th>
                                                        <th scope="col" class="text-center">Enitité</th>
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
                                                        </tr>
                                                        @php
                                                            $k++;
                                                        @endphp
                                                    @empty
                                                        <tr class="scope">
                                                            <th scope="col" class="text-center" colspan="2">Aucun privilège pour cet utilisateur</th>
                                                        </tr>
                                                    @endforelse
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

@endsection

