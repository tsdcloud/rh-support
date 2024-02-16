@extends('layouts.master')

@section('title', 'DE en attente de proposition')

@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="mb-2 col-md-6 col-12">
            <h3 class="content-header-title">Liste des DE en attente de proposition</h3>
        </div>
        <div class="mb-2 col-md-6 col-12">
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb float-md-right">
                        <li class="breadcrumb-item">
                            <a href="#">Accueil</a>
                            <a href="{{ route('home') }}" class="d-none" id="home_page">Accueil</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('de.inprocess') }}">DE en cours de traitement</a>
                        </li>
                        <li class="breadcrumb-item active">
                            DE en attente de proposition
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        <section class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <h4 class="card-title mt-1">
                                    DE en  attente de ma proposition de sanction
                                </h4>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="float-md-right">
                                    <a href="{{ route('de.create')}}" class="btn btn-primary white btn-sm"><i class="ft-plus white"></i> Nouvelle demande</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body card-dashboard">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered default-ordering">
                                    <thead>
                                        <tr>
                                            <th>N° DE</th>
                                            <th>Motif</th>
                                            <th>Initiateur</th>
                                            <th>Accusé</th>
                                            <th>Date d'envoi</th>
                                            <th>Date de reponse</th>
                                            <th>Statut</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($demandes as $demande)
                                            <tr>
                                                <td>#{{ $demande->numero_demande_explication }}</td>
                                                <td>{{ $demande->motif->motif }}</td>
                                                <td>
                                                    {{ $demande->emetteur->fname }} {{ $demande->emetteur->lname }}
                                                </td>
                                                <td>
                                                    {{ $demande->destinataires->fname }} {{ $demande->destinataires->lname }}
                                                </td>
                                                <td>{{ $demande->created_at }}</td>
                                                <td>{{ $demande->date_reponse ? $demande->date_reponse:'' }}</td>
                                                <td>
                                                    @if ($demande->reponse)
                                                        <span class="badge badge-success"><i class="ft-check"></i> Répondu</span>
                                                    @else
                                                        <span class="badge badge-danger"><i class="ft-x"></i> Non répondu</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('de.show', $demande->id) }}" class="btn btn-success d-flex align-items-center">
                                                        <i class="ft-eye mr-1"></i>
                                                        Voir
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>N° DE</th>
                                            <th>Motif</th>
                                            <th>Initiateur</th>
                                            <th>Accusé</th>
                                            <th>Date d'envoi</th>
                                            <th>Date de reponse</th>
                                            <th>Statut</th>
                                            <th>Actions</th>
                                        </tr>
                                    </tfoot>
                                </table>
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
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/bootstrap-extended.min.css') }}">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/menu/menu-types/horizontal-menu.min.css') }}">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <!-- END: Custom CSS-->

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/components.min.css') }}">
    <!-- END: Vendor CSS-->

    <!-- END: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">


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

    <!-- BEGIN: Theme JS-->
    <script src="{{ asset('app-assets/js/core/app-menu.min.js') }}"></script>
    <script src="{{ asset('app-assets/js/core/app.min.js') }}"></script>
    <script src="{{ asset('app-assets/js/scripts/customizer.min.js') }}"></script>
    <script src="{{ asset('app-assets/js/scripts/footer.min.js') }}"></script>
    <!-- END: Theme JS-->
@endsection

