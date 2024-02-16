@extends('layouts.master')

@section('title', 'Tableau de bord')
@section('styles')
    <!-- BEGIN: Vendor CSS-->
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/vendors.min.css') }}"> --}}
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
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/colors/palette-gradient.min.css') }}">
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

    {{-- <link rel="stylesheet" href="{{ asset('css/top-header-style.css') }}"> --}}

    <!-- BEGIN: Page CSS-->
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/fonts/feather/style.min.css') }}"> --}}
    <!-- END: Page CSS-->

    {{-- <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');
        *{
            font-family: 'Poppins'!important, sans-serif;
        }

        .h1, .h2, .h3, .h4, .h5, .h6, h1, h2, h3, h4, h5, h6, body{
            font-family: 'Poppins'!important, sans-serif;
        }
        :root{
            --font-family-sans-serif:'Poppins'!important, sans-serif;
            --font-family-monospace:'Poppins'!important, sans-serif;
        }
        .btn-success{
            height: 40px!important;
            display: flex;
            align-items: center;
        }

        @media only screen and (max-width: 768px) {
            .w-50 {
                width: 100%!important;
            }
            .btn_init_demande{
                margin-top: 10px;
            }
            .card-header .card-title{
                text-align: center!important;
            }
        }
    </style> --}}

@endsection

@section('content')
    <div class="content-wrapper" style="">
        <div class="content-header row">
            <div class="mb-2 col-md-6 col-12">
                <h3 class="content-header-title">Tableau de bord</h3>
            </div>
            <div class="mb-2 col-md-6 col-12">
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb float-md-right">
                            <li class="breadcrumb-item active">
                                Accueil
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body"><!-- eCommerce statistic -->
            <div class="row">
                <div class="col-xl-3 col-lg-6 col-12">
                    <div class="card pull-up">
                        <a href="{{ route('de.inprocess') }}">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="media d-flex">
                                        <div class="text-left media-body">
                                            <h3 class="info">{{ $de_enattente }}</h3>
                                            <h6>DE en cours de traitement</h6>
                                        </div>
                                        <div>
                                            <i class="float-right icon-layers info font-large-2"></i>
                                        </div>
                                    </div>
                                    <div class="mt-1 mb-0 progress progress-sm box-shadow-2">
                                        <div class="progress-bar bg-gradient-x-info" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-12">
                    <div class="card pull-up">
                        <a href="{{ route('de.archived') }}">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="media d-flex">
                                        <div class="text-left media-body">
                                            <h3 class="warning">{{ $de_archived }}</h3>
                                            <h6>DE archivées</h6>
                                        </div>
                                        <div>
                                            <i class="float-right ft-save warning font-large-2"></i>
                                        </div>
                                    </div>
                                    <div class="mt-1 mb-0 progress progress-sm box-shadow-2">
                                        <div class="progress-bar bg-gradient-x-warning" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-12">
                    <div class="card pull-up">
                        <a href="{{ route('users.index') }}">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="media d-flex">
                                        <div class="text-left media-body">
                                            <h3 class="success">{{ $users }}</h3>
                                            <h6>Utilisateurs</h6>
                                        </div>
                                        <div>
                                            <i class="float-right ft-users success font-large-2"></i>
                                        </div>
                                    </div>
                                    <div class="mt-1 mb-0 progress progress-sm box-shadow-2">
                                        <div class="progress-bar bg-gradient-x-success" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-12">
                    <div class="card pull-up">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="text-left media-body">
                                        <h3 class="text-white">w</h3>
                                        <h6>Statistiques</h6>
                                    </div>
                                    <div>
                                        <i class="float-right icon-bar-chart danger font-large-2"></i>
                                    </div>
                                </div>
                                <div class="mt-1 mb-0 progress progress-sm box-shadow-2">
                                    <div class="progress-bar bg-gradient-x-danger" role="progressbar" style="width: 85%" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ eCommerce statistic -->

        </div>

        <div class="card">
            <div class="card-head">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="card-title"> Liste des dernières demandes d'explication</h4>
                        </div>
                        <div class="col-md-6">
                            <div class="card-title float-right btn_init_demande">
                                <a  class="btn btn-success" href="{{ route('de.create') }}">
                                    <i class="mr-1 ft-file-plus"></i>
                                    Initier une demande
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-content">
                <div class="card-body">
	                <!-- Invoices List table -->
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered default-ordering">
                            <thead>
                                <tr>
                                    <th>Numéro de la DE</th>
                                    <th>initiateur</th>
                                    <th>Motif</th>
                                        <th>Date d'envoi</th>
                                    <th>Destinataire</th>
                                    <th>statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($de_lasts as $de)
                                    <tr>
                                        <td>
                                            <a href="{{ route('de.show', $de->id) }}" title="Voir les détails de cette DE">
                                                <i class="ft-eye"></i>
                                                #{{ $de->numero_demande_explication }}
                                            </a>
                                        </td>
                                        <td>{{ $de->emetteur->fname }} {{ $de->emetteur->lname }}</td>
                                        <td>{{ $de->motif->motif }}</td>
                                        <td>{{ $de->created_at }}</td>
                                        <td>{{ $de->destinataires->fname }} {{ $de->destinataires->lname }}</td>
                                        <td><span class="badge badge-{{ $de->reponse ? 'success':'danger'}}">{{ $de->reponse ? 'Répondu':'Non répondu'}}</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Numéro de la DE</th>
                                    <th>initiateur</th>
                                    <th>Motif</th>
                                    <th>Date d'envoie</th>
                                    <th>Destinataire</th>
                                    <th>statut</th>
                                </tr>
                            </tfoot>
                        </table>
					</div>
					<!--/ Invoices table -->
				</div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')<!-- BEGIN: Vendor JS-->
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
    <!-- END: Theme JS-->
@endsection
