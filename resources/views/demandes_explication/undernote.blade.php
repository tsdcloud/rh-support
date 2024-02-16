@extends('layouts.master')

@section('title', 'En attente de note')

@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="mb-2 col-md-6 col-12">
            <h3 class="content-header-title">DE en attente de note de décision</h3>
        </div>
        <div class="mb-2 col-md-6 col-12">
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb float-md-right">
                        <li class="breadcrumb-item">
                            <a href="#">Accueil</a>
                            <a href="{{ route('home') }}" class="d-none" id="home_page">Accueil</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{{ route('de.archived') }}">DE archivées</a>
                        </li>
                        <li class="breadcrumb-item active">
                            DE en attente de note
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
                                <h4 class="card-title mt-1">DE en attente de note de décision</h4>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="float-md-right">
                                    <a href="{{ route('de.create')}}" class="btn btn-primary white btn-sm"><i class="ft-plus white"></i> Nouvelle demande</a>
                                </div>
                            </div>
                        </div>
                        {{-- <a class="heading-elements-toggle"><i class="la la-ellipsis-h font-medium-3"></i></a> --}}
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body card-dashboard">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered default-ordering">
                                    <thead>
                                        <tr>
                                            <th>N°</th>
                                            <th>Motif</th>
                                            <th>Initiateur</th>
                                            <th>Accusé</th>
                                            <th>Date d'envoi</th>
                                            <th>Date de reponse</th>
                                            <th>Statut</th>
                                            <th>Actions</th>
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
                                                <td>{{ $demande->date_reponse }}</td>
                                                <td>
                                                    @if ($demande->reponse)
                                                        <span class="badge badge-success"><i class="ft-check"></i> Répondu</span>
                                                    @else
                                                        <span class="badge badge-danger"><i class="ft-x"></i> Non répondu</span>
                                                    @endif
                                                </td>
                                                <td class="d-flex">
                                                    <a href="{{ route('de.show', $demande->id) }}" class="btn btn-success"> <i class="ft-eye"></i> Voir</a>
                                                    @if (auth()->user()->id == $demande->destinataire)
                                                        <button type="button" class="ml-1 btn btn-primary" data-toggle="modal" data-target="#demande_amswer{{ $demande->id }}" {{$demande->reponse ? 'disabled':''}}> <i class="ft-edit"></i> Répondre</button>
                                                    @endif

                                                    <!-- Modal -->
                                                    <div class="text-left modal fade" id="demande_amswer{{ $demande->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <form action="{{ route('de.answered', $demande->id) }}" method="post">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title" id="myModalLabel1">Répondre à la DE</h4>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="form-group col-md-12">
                                                                                <label for="reponse">Motif</label>
                                                                                <input type="text" value="{{ $demande->motif->motif }}" class="form-control" disabled>
                                                                            </div>
                                                                            <div class="form-group col-md-12">
                                                                                <label for="reponse">Votre reponse</label>
                                                                                <textarea name="reponse" id="reponse" class="form-control @error('reponse') is-invalid
                                                                                @enderror" cols="30" rows="10">{{ @old('reponse')}}</textarea>

                                                                                @error('reponse')
                                                                                    <span class="text-danger">{{$message}}</span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn grey btn-danger" data-dismiss="modal"> <i class="ft-x"></i> Fermer</button>
                                                                        <button type="submit" class="btn btn-primary"> <i class="ft-navigation"></i> Envoyer</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>N°</th>
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
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/icheck/icheck.css') }}"> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/components.min.css') }}">
    <!-- END: Vendor CSS--><!-- END: Vendor CSS-->
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

