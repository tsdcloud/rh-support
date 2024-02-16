@extends('layouts.master')

@section('title', 'Importation d\'utilisateurs')

@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="col-md-6 col-12 mb-2">
            <h3 class="content-header-title">Importez la liste des utilisateurs (Suivant le format défini dans la documentation)</h3>
        </div>
        <div class="col-md-6 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb float-md-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">Accueil</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('users.index') }}">Liste des utilisateurs</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Importation
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
                        <div class="card-header">
                            <h4 class="card-title">Lignes d'erreur dans le fichier Excel</h4>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <a href="{{ route('users.export') }}" class="btn btn-warning">
                                        <i class="ft-download"></i> exportes la liste des utilisateurs
                                    </a>
                                    <button class="btn btn-success" type="button"  data-toggle="modal" data-target="#addusers">
                                        <i class="ft-upload"></i> Importez les utilisateurs (fichier Excel)
                                    </button>
                                    <div class="modal fade text-left" id="addusers" tabindex="-1" role="dialog" aria-labelledby="addusers"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="addusers"><i class="ft-file"></i> Importer le fichier Excel</h4>
                                                    <button type="button" class="close mb-4" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <form action="{{ route('users.import.store') }}" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="form-body">

                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="file">Importez le fichier ici<span class="text-danger"><sub>*</sub></span></label>
                                                                        <input type="file" name="file" id="file" value="{{ @old('file') }}" class="form-control  @error('file') is-invalid @enderror" placeholder="Importer le fichier" required>
                                                                        @error('file')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
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
                                                                Valider
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard">
                                <div class="table-responsive">
                                    <table id="example" class="table table-striped table-bordered zero-configuration">
                                        <thead>
                                            <tr>
                                                <th>N° de la ligne</th>
                                                <th>Feuille de l'entité</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- @dump($error_line) --}}
                                            @foreach ($error_line as $entity => $errors)
                                                @foreach ($errors as $key => $error)
                                                    <tr>
                                                        <td>
                                                            {{ $error }}
                                                        </td>
                                                        <td>
                                                            {{ $entity }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <tr>
                                                    <th>N° de la ligne</th>
                                                    <th>Feuille de l'entité</th>
                                                </tr>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
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

