@extends('layouts.master')

@section('title', 'Historique des DE')

@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="mb-2 col-md-6 col-12">
            <h3 class="content-header-title">Historique des sanctions de {{ $user->fname }} {{ $user->lname }}</h3>
        </div>
        <div class="mb-2 col-md-6 col-12">
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb float-md-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">Accueil</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('sanctions.history') }}">Historique des sanctions</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Historique
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body"><!-- Zero configuration table -->
        <section id="configuration">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <form class="media d-flex" method="post" action="{{ route('de.history.export', $user->id) }}">
                                    @csrf
                                    <div class="row w-100">
                                        <div class="col-md-4 form-group">
                                            <label for="date_debut">Date de début</label>
                                            <input type="date" name="date_debut" id="date_debut" class="form-control @error('date_debut')
                                            is-invalid
                                            @enderror">
                                            @error('date_debut')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label for="date_fin">Date de fin</label>
                                            <input type="date" name="date_fin" id="date_fin" class="form-control @error('date_fin')
                                            is-invalid
                                            @enderror">
                                            @error('date_fin')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label for="date_fin" class="text-white">Date de fin</label>
                                            <button type="submit" class="btn btn-primary white btn-sm w-100">
                                                <i class="ft-download white"></i>
                                                Export du dossier disciplinaire
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-3 col-12">
                                    <h4 class="card-title">Historique des sanctions</h4>
                                </div>
                                <div class="col-md-9 col-12">
                                    <div class="float-md-right d-flex">
                                        <a href="{{ URL::previous() }}" class="btn btn-warning white btn-sm mr-2">
                                            <i class="icon-action-undo white"></i>
                                            Retour
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered zero-configuration">
                                        <thead>
                                            <tr>
                                                <th>N° de la DE</th>
                                                <th>Motif</th>
                                                <th>Initiateur</th>
                                                <th>Date d'envoi de DE</th>
                                                <th>Décision</th>
                                                <th>Décision par</th>
                                                <th>Date de décision</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($user->sanctions as $sanction)
                                                <tr>
                                                    @if($sanction->demande)
                                                        <td>#{{ $sanction->demande->numero_demande_explication }}</td>
                                                        <td>{{ $sanction->demande->motif->motif }}</td>
                                                        <td>{{ $sanction->demande->emetteur->fname }} {{ $sanction->demande->emetteur->lname }}</td>
                                                        <td>{{ $sanction->demande->created_at }}</td>
                                                        <td>{{ $sanction->decisions->motif }}</td>
                                                        <td>{{ $sanction->decideurs->fname }} {{ $sanction->decideurs->lname }}</td>
                                                        <td>{{ $sanction->created_at }}</td>
                                                        <td>
                                                            <a href="{{ route('de.show', $sanction->demande_explication_id) }}" class="btn btn-primary">
                                                                <i class="ft-eye"></i> Consulter
                                                            </a>
                                                        </td>
                                                    @else
                                                        <td>---</td>
                                                        <td>
                                                            {{ $sanction->motif_outdate->motif_outdate }} <br>
                                                            <span class="badge badge-success">Nouvel intitulé</span> <br>
                                                            {{ $sanction->motif_outdate->motif->motif }}
                                                        </td>
                                                        <td>---</td>
                                                        <td>---</td>
                                                        <td>{{ $sanction->decisions->motif }}</td>
                                                        <td>{{ $sanction->decideurs->fname }} {{ $sanction->decideurs->lname }}</td>
                                                        <td>---</td>
                                                        <td>
                                                            <a href="#" class="btn btn-primary" @disabled(true)>
                                                                <i class="ft-eye"></i> Consulter
                                                            </a>
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>ID</th>
                                                <th>Motif</th>
                                                {{-- <th>Destinataire</th> --}}
                                                <th>Date d'envoi</th>
                                                <th>Statut de reponse</th>

                                                <th>Décision</th>
                                                <th>Décision par</th>
                                                <th>Date de décision</th>
                                                <th>Actions</th>
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
    </div>
</div>

@endsection
{{-- -------------------------------- styles -------------------------------------- --}}

@section('styles')
    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/datatable/datatables.min.css') }}">

    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/animate/animate.css') }}"> --}}
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/extensions/sweetalert2.min.css') }}"> --}}
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/bootstrap-extended.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/colors.min.css') }}">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/menu/menu-types/horizontal-menu.min.css') }}">
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/colors/palette-gradient.min.css') }}"> --}}
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <!-- END: Custom CSS-->

    <!-- BEGIN: Vendor CSS-->
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}"> --}}
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/icheck/icheck.css') }}"> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/components.min.css') }}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Page CSS-->
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/invoice.min.css') }}"> --}}
    <!-- END: Page CSS-->
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/vendors.min.css') }}"> --}}
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/pickers/miniColors/jquery.minicolors.css') }}"> --}}
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/pickers/spectrum/spectrum.css') }}"> --}}
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/bootstrap.min.css') }}"> --}}
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/bootstrap-extended.min.css') }}"> --}}
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/colors.min.css') }}"> --}}
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/components.min.css') }}"> --}}
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/menu/menu-types/horizontal-menu.min.css') }}"> --}}
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/colors/palette-gradient.min.css') }}"> --}}
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/pickers/colorpicker/colorpicker.min.css') }}"> --}}

    <!-- BEGIN: Vendor CSS-->
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/selects/select2.min.css') }}"> --}}
    <!-- END: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">

    {{-- <link rel="stylesheet" href="{{ asset('css/sweetalert.css') }}"> --}}
    {{-- <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i%7CQuicksand:300,400,500,700" rel="stylesheet"> --}}

@endsection
{{-- --------------------------------scripts -------------------------------------- --}}
@section('scripts')
    <!-- BEGIN: Vendor JS-->
    <script src="{{ asset('app-assets/vendors/js/vendors.min.js') }}"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset('app-assets/vendors/js/tables/datatable/datatables.min.js') }}"></script>

    <!-- BEGIN: Page JS-->
    <script src="{{ asset('app-assets/js/scripts/tables/datatables/datatable-basic.min.js')}}"></script>
    <!-- END: Page JS-->


    <!-- BEGIN: Page Vendor JS-->
    {{-- <script src="{{ asset('app-assets/vendors/js/tables/jquery.dataTables.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('app-assets/vendors/js/forms/icheck/icheck.min.js') }}"></script> --}}
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    {{-- <script src="{{ asset('app-assets/js/core/app-menu.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('app-assets/js/core/app.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('app-assets/js/scripts/customizer.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('app-assets/js/scripts/footer.min.js') }}"></script> --}}
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    {{-- <script src="{{ asset('app-assets/js/scripts/ui/breadcrumbs-with-stats.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('app-assets/js/scripts/pages/invoices-list.min.js') }}"></script> --}}
    <!-- END: Page JS-->


    <!-- BEGIN: Page Vendor JS-->
    {{-- <script src="{{ asset('app-assets/vendors/js/ui/jquery.sticky.js') }}"></script> --}}
    {{-- <script src="{{ asset('app-assets/vendors/js/charts/jquery.sparkline.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('app-assets/vendors/js/forms/repeater/jquery.repeater.min.js') }}"></script> --}}
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{ asset('app-assets/js/core/app-menu.min.js') }}"></script>
    <script src="{{ asset('app-assets/js/core/app.min.js') }}"></script>
    <script src="{{ asset('app-assets/js/scripts/customizer.min.js') }}"></script>
    {{-- <script src="{{ asset('app-assets/js/scripts/footer.min.js') }}"></script> --}}
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    {{-- <script src="{{ asset('app-assets/js/scripts/ui/breadcrumbs-with-stats.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('app-assets/js/scripts/forms/form-repeater.min.js') }}"></script> --}}
    <!-- END: Page JS-->

    <!-- BEGIN: Page Vendor JS-->
    {{-- <script src="{{ asset('app-assets/vendors/js/ui/jquery.sticky.js') }}"></script> --}}
    {{-- <script src="{{ asset('app-assets/vendors/js/charts/jquery.sparkline.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('app-assets/vendors/js/pickers/miniColors/jquery.minicolors.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('app-assets/vendors/js/pickers/spectrum/spectrum.js') }}"></script> --}}
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    {{-- <script src="{{ asset('app-assets/js/core/app-menu.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('app-assets/js/core/app.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('app-assets/js/scripts/customizer.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('app-assets/js/scripts/footer.min.js') }}"></script> --}}
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    {{-- <script src="{{ asset('app-assets/js/scripts/ui/breadcrumbs-with-stats.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('app-assets/js/scripts/pickers/colorpicker/picker-color.min.js') }}"></script> --}}
    <!-- END: Page JS-->

    <!-- BEGIN: Page Vendor JS-->
    {{-- <script src="{{ asset('app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script> --}}
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Page JS-->
    {{-- <script src="{{ asset('app-assets/js/scripts/forms/select/form-select2.min.js') }}"></script> --}}
    <!-- END: Page JS-->

@endsection

