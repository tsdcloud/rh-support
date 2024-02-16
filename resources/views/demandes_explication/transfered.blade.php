@extends('layouts.master')

@section('title', 'Nouvelle demande')

@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="mb-2 col-md-8 col-12">
            <h3 class="content-header-title">Nouvelle demande <span class=" h5">(Pour un personnel exercant dans une autre entité que la nôtre)</span></h3>
        </div>
        <div class="mb-2 col-md-4 col-12">
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb float-md-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">Accueil</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('de.enattente') }}">DE en cours</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Nouvelle DE
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
                        <div class="mx-4 mt-4 row" style="margin-bottom:-10px">
                            <div class="col-md-6">
                                <h4 class="my-1 text-bold">Veuillez remplir les champs</h4>
                            </div>
                            <div class="col-md-6">
                                <div class="float-right heading-elements">
                                    <ul class="list-inline">
                                        <a class="py-1 btn btn-warning " href="{{ route('de.archived') }}">
                                            <i class="ft-save"></i>
                                            DE archivées
                                        </a>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="card-content collapse show" style="margin-top:">
                            <div class="card-body card-dashboard">
                                <form method="POST" action="{{ route('de.store') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <livewire:de-to-transfered :destinataires="$destinataires" :motifs="$motifs" />
                                                </div>
                                                <div class="col-md-8 col-12">
                                                    <div class="form-group">
                                                        <label for="description">Description de la demande <span class="text-danger"><sup>*</sup></span></label>
                                                            @php
$description_de = "Madame/Monsieur,

Il a été donné de constater que ...

Le rapport de votre hiérarchie fait état de ...

Vous voudriez bien nous expliquer dans un délai de 72h dès réception de la présente les raisons de ...

<b>NB:</b> Le refus de réponse à la présente demande d’explications et dans les délais annoncés sera assimilé à un acte d’insubordination et traité comme tel.
"; 
                                                            @endphp
                                                        <textarea name="description" class="form-control @error('personnes_en_copie') is-invalid @enderror" id="description" cols="30" rows="12">{!! @old('description', html_entity_decode($description_de)) !!}</textarea>
                                                        @error('personnes_en_copie')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <div class="row w-100">
                                            <div class="col-md-6" style="margin-left:-15px;">
                                                <a href="#" class="btn grey btn-danger">
                                                    <i class="icon-action-undo"></i>
                                                    DE en attente
                                                </a>
                                            </div>
                                            <div class="col-md-6">
                                                <button type="submit" class="float-right btn btn-success" style="margin-right:-15px;">
                                                    <i class="ft-navigation"></i>
                                                    Envoyer
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
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
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/icheck/icheck.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/components.min.css') }}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/invoice.min.css') }}">
    <!-- END: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/pickers/miniColors/jquery.minicolors.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/pickers/spectrum/spectrum.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/bootstrap-extended.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/colors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/components.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/menu/menu-types/horizontal-menu.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/colors/palette-gradient.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/pickers/colorpicker/colorpicker.min.css') }}">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/selects/select2.min.css') }}">
    <!-- END: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/sweetalert.css') }}">

    @livewireStyles()
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
    <script src="{{ asset('app-assets/vendors/js/tables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/forms/icheck/icheck.min.js') }}"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{ asset('app-assets/js/scripts/footer.min.js') }}"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="{{ asset('app-assets/js/scripts/pages/invoices-list.min.js') }}"></script>
    <!-- END: Page JS-->


    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset('app-assets/vendors/js/forms/repeater/jquery.repeater.min.js') }}"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Page JS-->
    <script src="{{ asset('app-assets/js/scripts/forms/form-repeater.min.js') }}"></script>
    <!-- END: Page JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset('app-assets/vendors/js/ui/jquery.sticky.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/charts/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/pickers/miniColors/jquery.minicolors.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/pickers/spectrum/spectrum.js') }}"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{ asset('app-assets/js/core/app-menu.min.js') }}"></script>
    <script src="{{ asset('app-assets/js/core/app.min.js') }}"></script>
    <script src="{{ asset('app-assets/js/scripts/customizer.min.js') }}"></script>
    {{-- <script src="{{ asset('app-assets/js/scripts/footer.min.js') }}"></script> --}}
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="{{ asset('app-assets/js/scripts/ui/breadcrumbs-with-stats.min.js') }}"></script>
    <script src="{{ asset('app-assets/js/scripts/pickers/colorpicker/picker-color.min.js') }}"></script>
    <!-- Ec:\Users\gnoah\AppData\Local\Programs\Microsoft VS Code\resources\app\out\vs\code\electron-sandbox\workbench\workbench.htmlND: Page JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset('app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Page JS-->
    <script src="{{ asset('app-assets/js/scripts/forms/select/form-select2.min.js') }}"></script>
    <!-- END: Page JS-->

    @livewireScripts()
@endsection

