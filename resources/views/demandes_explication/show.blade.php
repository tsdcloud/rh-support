@extends('layouts.master')

@section('title', 'Voir une demande')

@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="mb-2 col-md-6 col-12">
            <h3 class="content-header-title">Voir une demande</h3>
        </div>
        <div class="mb-2 col-md-6 col-12">
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb float-md-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">Accueil</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('de.notanswered') }}">DE non répondues</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Répondre
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
                    <div class="card">
                        <div class="mx-1 mt-1 mb-0 row" style="margin-bottom:-10px">
                            <div class="col-md-6">
                                <h4 class="my-1 text-bold">Détails de la demande</h4>
                            </div>
                            <div class="col-md-6">
                                <div class="float-md-right">
                                    <a class="py-1 btn btn-warning " href="{{ route('sanctions.history.show', $demande->destinataire) }}">
                                        <i class="ft-eye"></i>
                                        Historique des sanctions de {{ $demande->destinataires->fname }}
                                    </a>
                                    {{-- <ul class="list-inline">
                                    </ul> --}}
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="card-content collapse show" style="margin-top:">
                            <div class="card-body card-dashboard">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="border rounded card-content collapse show" >
                                            <div class="rounded card-header bg-secondary">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h4 class="text-white">Pièces jointes de la DE</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body my-gallery" itemscope>
                                                <div class="row">
                                                    @foreach ($demande->piece_jointes as $piece_jointe)
                                                        <figure class="col-md-6 col-12" itemprop="associatedMedia" itemscope>
                                                            <a href="{{ asset('storage/'.$piece_jointe->piece_jointe)}}" itemprop="contentUrl" data-size="480x360">
                                                                <img class="img-thumbnail img-fluid" style="border: 1px rgb(156, 146, 146) solid; height:200px;width:250px" src="{{ asset('storage/'.$piece_jointe->piece_jointe)}}" itemprop="thumbnail" alt="Image description" />
                                                            </a>
                                                        </figure>
                                                    @endforeach
                                                </div>
                                            </div>

                                            {{-- Pieces jointe de reponse a une demande explication --}}
                                            @if($demande->piece_jointes_reponse->count())
                                                <div class="card-header bg-secondary">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h4 class="text-white">Pièces jointes à la réponse à la DE</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body my-gallery" itemscope>
                                                    <div class="row">
                                                        @foreach ($demande->piece_jointes_reponse as $piece_jointe)
                                                            <figure class="col-md-6 col-12" itemprop="associatedMedia" itemscope >
                                                                <a href="{{ asset('storage/'.$piece_jointe->piece_jointe)}}" itemprop="contentUrl" data-size="480x360">
                                                                    <img class="img-thumbnail img-fluid" style="border: 1px rgb(156, 146, 146) solid; height:200px;width:250px" src="{{ asset('storage/'.$piece_jointe->piece_jointe)}}" itemprop="thumbnail" alt="Image description" />
                                                                </a>
                                                            </figure>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif

                                            {{-- Pieces jointe lors des proposition des sanctions --}}
                                            @foreach ($demande->proposition_sanctions as $proposition_sanction)
                                            {{-- @dd($proposition_sanctions) --}}
                                                @if($proposition_sanction->piece_jointes_proposition_sanctions->count())
                                                    <div class="card-header bg-secondary">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <h4 class="text-white">Pièces jointes issues des propositions</h4>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="row">
                                                                    <div class="col-2">
                                                                        <h4 class="text-white">
                                                                            Par
                                                                        </h4>
                                                                    </div>
                                                                    <div class="col-10">
                                                                        <h4 class="text-white">
                                                                            : {{ $proposition_sanction->user->fname }} {{ $proposition_sanction->user->lname }}
                                                                        </h4>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-2">
                                                                        <h4 class="text-white">
                                                                            Date
                                                                        </h4>
                                                                    </div>
                                                                    <div class="col-10">
                                                                        <h4 class="text-white">
                                                                            : {{ $proposition_sanction->created_at }}
                                                                        </h4>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-body my-gallery" itemscope>
                                                        <div class="row">
                                                            @foreach ($proposition_sanction->piece_jointes_proposition_sanctions as $piece_jointe)
                                                                <figure class="col-md-6 col-12" itemprop="associatedMedia" itemscope >
                                                                    <a href="{{ asset('storage/'.$piece_jointe->piece_jointe)}}" itemprop="contentUrl" data-size="480x360">
                                                                        <img class="img-thumbnail img-fluid" style="border: 1px rgb(156, 146, 146) solid; height:200px;width:250px" src="{{ asset('storage/'.$piece_jointe->piece_jointe)}}" itemprop="thumbnail" alt="Image description" />
                                                                    </a>
                                                                </figure>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach

                                            {{-- Piece jointe liee a une note de decision de sanction --}}
                                            @if($demande->file_note_decision_sanction)
                                                <div class="card-header bg-secondary">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h4 class="text-white card-title">Note de décision de sanction</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body my-gallery" itemscope>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <iframe src="{{ asset('storage/'. $demande->file_note_decision_sanction) }}" frameborder="0" height="700px" width="100%"></iframe>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div><!--/ Image grid -->
                                    </div>
                                    <div class="col-md-7">
                                        <div class="border rounded card-content collapse show">
                                            <div class="card-header">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h4 class="card-title">Détails de la demande N° {{ $demande->numero_demande_explication }}</h4>
                                                    </div>
                                                    <div class="text-right col-md-6">
                                                        <h4 class="card-title">
                                                            @if($demande->reponse)
                                                                {{-- 259200 = 72h --}}
                                                                @if((strtotime($demande->date_reponse) - strtotime($demande->created_at)) <= 259200)
                                                                    <span class="badge badge-success"><i class="ft-check"></i> Répondu dans les délais</span>
                                                                @else
                                                                    <span class="badge badge-warning"><i class="ft-alert-triangle"></i> Répondu en retard</span>
                                                                @endif
                                                            @else
                                                                <span class="badge badge-danger"><i class="ft-x"></i> Non répondu</span>
                                                            @endif
                                                        </h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body my-gallery" itemscope>
                                                <div class="row">
                                                    <div class="col-12 bottom-1">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <h5><span class="text-bold">Initiateur</span></h5>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <h5>
                                                                    <strong>:</strong> {{ $demande->emetteur->fname }} {{ $demande->emetteur->lname }}
                                                                </h5>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <h5><span class="text-bold">Motif</span></h5>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <h5><strong>:</strong> {{ $demande->motif->motif }}</h5>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <h5><span class="text-bold">Date d'envoi</span></h5>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <h5><strong>:</strong> {{ $demande->created_at }}</h5>
                                                            </div>
                                                        </div>

                                                        @if ($demande->destinataire != auth()->user()->id)
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <h5><span class="text-bold">Destinataire</span></h5>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <h5>
                                                                        <strong>:</strong> {{ $demande->destinataires->fname }} {{ $demande->destinataires->lname }}
                                                                    </h5>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="pt-2 col-12" style="border-top:1px solid rgb(175, 170, 170)">
                                                        <h5 class="text-bold">Description</h5>
                                                        <p>{!! html_entity_decode($demande->description) !!}</p>
                                                    </div>

                                                    {{-- Reponse a la DE --}}
                                                    <div class="pt-2 col-12" style="border-top:1px solid rgb(175, 170, 170)">
                                                        <h5 class="text-bold">Réponse</h5>
                                                        @if($demande->reponse)
                                                            <p>{{ html_entity_decode($demande->reponse) }}</p>
                                                            <p><span class="text-bold">Répondu le:</span> {{ $demande->date_reponse }}</p>
                                                            {{-- <p><span class="text-bold">Répondu le:</span> {{ changeDateFormat($demande->date_reponse) }}</p> --}}
                                                        @else
                                                            <p>Aucune réponse pour le moment</p>
                                                        @endif
                                                    </div>

                                                    {{-- Autres reponses --}}

                                                    @if (auth()->user()->id == $demande->destinataire && !$demande->sanction)
                                                        <div class="col-12" style="margin-bottom:15px">
                                                            <button type="button" class="mt-1 btn btn-primary" data-toggle="modal" data-target="#demande_amswer{{ $demande->id }}" {{$demande->reponse ? 'disabled':''}} {{ !empty($demande->sanction) ? 'disabled':''}}>
                                                                <i class="ft-edit"></i>
                                                                Répondre
                                                            </button>

                                                            <!-- Modal -->
                                                            <div class="text-left modal fade" id="demande_amswer{{ $demande->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
                                                                aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <form action="{{ route('de.answered', $demande->id) }}" method="post" enctype="multipart/form-data">
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
                                                                                        <label for="reponse">Votre réponse</label>
                                                                                        <textarea name="reponse" id="reponse" class="form-control @error('reponse') is-invalid
                                                                                        @enderror" cols="30" rows="10">{{ @old('reponse')}}</textarea>

                                                                                        @error('reponse')
                                                                                        <span class="text-danger">{{$message}}</span>
                                                                                        @enderror
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <livewire:pieces-jointes-input />
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
                                                        </div>
                                                    @endif

                                                    {{-- @dump($demande->reponse || ((strtotime(now()) - strtotime($demande->created_at)) >= 259200)) --}}
                                                    {{-- @dump(now()) --}}
                                                    @if($demande->reponse || ((strtotime(now()) - strtotime($demande->created_at)) >= 259200))
                                                        {{-- Proposition de sanctions --}}
                                                        @php
                                                            $notification_invitation_decision_sanction = 0;
                                                        @endphp
                                                        @foreach ($demande->notifications as $notification)
                                                            @php
                                                                if($notification->motif == 'invitation_decision_sanction'){
                                                                    $notification_invitation_decision_sanction ++;
                                                                }
                                                            @endphp

                                                            @include('demandes_explication.includes.main_proposition_sanction_component', ['notification_invitation_decision_sanction'=>$notification_invitation_decision_sanction, 'users'=>$users])
                                                        @endforeach

                                                        {{-- Decision de sanction --}}
                                                        {{-- @if (auth()->user()->id == $demande->destinataire )
                                                            @include('demandes_explication.includes.main_decision_sanction_component', ['notification_invitation_decision_sanction'=>$notification_invitation_decision_sanction, 'notification'=>$notification, 'motif_sanctions'=>$motif_sanctions])
                                                        @else
                                                            @include('demandes_explication.includes.main_decision_sanction_component', ['notification_invitation_decision_sanction'=>$notification_invitation_decision_sanction, 'notification'=>$notification, 'motif_sanctions'=>$motif_sanctions])
                                                        @endif --}}
                                                        @include('demandes_explication.includes.main_decision_sanction_component', ['notification_invitation_decision_sanction'=>$notification_invitation_decision_sanction, 'notification'=>$notification, 'motif_sanctions'=>$motif_sanctions])

                                                        {{-- Redaction de note e decision de sanction (A faire par les RH ou Admin de l'entité si la decision est autre que *pas de sanction*) --}}
                                                        @if($demande->sanction)
                                                            @if($demande->sanction->decision != 1)
                                                                @include('demandes_explication.includes.main_note_decision_sanction_component')
                                                            @endif
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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

    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/animate/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/extensions/sweetalert2.min.css') }}">
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
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/components.min.css') }}">
    <!-- END: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/selects/select2.min.css') }}">

    @livewireStyles()
@endsection
{{-- --------------------------------scripts -------------------------------------- --}}
@section('scripts')
    <!-- BEGIN: Vendor JS-->
    <script src="{{ asset('app-assets/vendors/js/vendors.min.js') }}"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{ asset('app-assets/js/core/app-menu.min.js') }}"></script>
    <script src="{{ asset('app-assets/js/core/app.min.js') }}"></script>
    <script src="{{ asset('app-assets/js/scripts/customizer.min.js') }}"></script>
    <script src="{{ asset('app-assets/js/scripts/footer.min.js') }}"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset('app-assets/vendors/js/ui/jquery.sticky.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/charts/jquery.sparkline.min.js') }}"></script>

    <script src="{{ asset('app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Page JS-->
    <script src="{{ asset('app-assets/js/scripts/forms/select/form-select2.min.js') }}"></script>
    <!-- END: Page JS-->
    @livewireScripts()
@endsection

