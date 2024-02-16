@extends('layouts.master')

@section('title', 'Utilisateurs')

@section('content')
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="mb-2 col-md-6 col-12">
                <h3 class="content-header-title">Liste des utilisateurs</h3>
            </div>
            <div class="mb-2 col-md-6 col-12">
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb float-md-right">
                            <li class="breadcrumb-item">
                                <a href="{{ route('home') }}">Accueil</a>
                            </li>
                            <li class="breadcrumb-item active">
                                Liste des utilisateurs
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
                    <div class="col-12">
                        <div class="card">
                            <div class="mx-1 card-header">
                                <form action="{{ route('statistics.explanation_demand.store') }}" method="post" class="row">
                                    @csrf
                                    <div class="col-md-4 form-group">
                                        <label for="date_debut">Date de début</label>
                                        <input type="date" name="date_debut" id="date_debut" class="form-control" value="{{ @old('date_debut') }}" required>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="date_fin">Date de fin</label>
                                        <input type="date" name="date_fin" id="date_fin" class="form-control" value="{{ @old('date_fin') }}">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="date_fin" class="text-white">Date de fin</label>
                                        <button type="submit" class="text-white btn btn-primary form-control"> <i class="ft-upload"></i> Exporter toutes les demandes</button>
                                    </div>
                                </form>
                            </div>
                            {{-- <div class="card-content collapse show">
                                <div class="card-body card-dashboard">
                                    <div class="table-responsive">
                                        <table id="example" class="table table-striped table-bordered zero-configuration">
                                            <thead>
                                                <tr>
                                                    <th>N°</th>
                                                    <th>Nom</th>
                                                    <th>Prénom</th>
                                                    <th>Téléphone</th>
                                                    <th>Email</th>
                                                    <th>Entité(s)</th>
                                                    @if (auth()->user()->isAdmin())
                                                        <th>Actions</th>
                                                    @endif
                                                </tr>
                                            </thead>
                                            <tbody>
                                                

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>N°</th>
                                                    <th>Nom</th>
                                                    <th>Prénom</th>
                                                    <th>Téléphone</th>
                                                    <th>Email</th>
                                                    <th>Entité(s)</th>
                                                    @if (auth()->user()->isAdmin())
                                                        <th>Actions</th>
                                                    @endif
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <div class="card">
                            <div class="mx-1 card-header">
                                <form action="{{ route('statistics.explanation_specific_demand.store') }}" method="post" class="row">
                                    @csrf
                                    <div class="col-12">
                                        <h3>Exporter les DE avec leurs informations spécifiques</h3>
                                        <hr/>
                                    </div>
                                    
                                    <div class="text-center col-md-3 col-6 form-group">
                                        <label for="with_description">Avec description de la demande ?</label>
                                        <input type="checkbox" name="with_description" id="with_description" class="form-control" value="with_description">
                                    </div>
                                    
                                    <div class="text-center col-md-3 col-6 form-group">
                                        <label for="with_answers">Avec réponse à la demande ?</label>
                                        <input type="checkbox" name="with_answers" id="with_answers" class="form-control" value="with_answers">
                                    </div>

                                    <div class="text-center col-md-3 col-6 form-group">
                                        <label for="with_proposition_sanction">Avec proposition de sanction ?</label>
                                        <input type="checkbox" name="with_proposition_sanction" id="with_proposition_sanction" class="form-control" value="with_proposition_sanction">
                                    </div>
                                    
                                    <div class="text-center col-md-3 col-6 form-group">
                                        <label for="status_note_sanction">Statut note de sanction ?</label>
                                        <input type="checkbox" name="status_note_sanction" id="status_note_sanction" class="form-control" value="status_note_sanction">
                                    </div>
                                    
                                    <div class="col-md-4 col-6 form-group">
                                        <label for="date_debut">Date de début</label>
                                        <input type="date" name="date_debut" id="date_debut" class="form-control" value="{{ @old('date_debut') }}" required>
                                    </div>
                                    <div class="col-md-4 col-6 form-group">
                                        <label for="date_fin">Date de fin</label>
                                        <input type="date" name="date_fin" id="date_fin" class="form-control" value="{{ @old('date_fin') }}">
                                    </div>
                                    
                                    <div class="col-md-4 form-group">
                                        <label for="Export des DE" class="text-white">Exporter</label>
                                        <button type="submit" class="text-white btn btn-primary form-control"> <i class="ft-upload"></i> Exporter</button>
                                    </div>
                                </form>
                            </div>
                        </div>
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

