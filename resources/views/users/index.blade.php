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
                            <h4 class="card-title">Listes des utilisateurs</h4>
                            {{-- <a class="heading-elements-toggle"><i class="ft-more-vertical font-medium-3"></i></a> --}}
                            <div class="mr-1 heading-elements">
                                <ul class="mb-0 list-inline">
                                    @if (auth()->user()->isAdmin())
                                        @include('users.add_user_component')
                                    @else
                                        <a href="{{ route('profil', auth()->user()->id) }}" class="btn btn-success">
                                            <i class="ft-user"></i> Mon profil
                                        </a>                                                
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard">
                                <div class="table-responsive">
                                    <table id="example" class="table table-striped table-bordered default-ordering">
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
                                            @php
                                                $k = 1;
                                            @endphp
                                            @foreach ($users as $user)
                                                <tr class="align-items-center">
                                                    <td>
                                                        {{ $k++ }}
                                                        {{-- {{ dump(storage_path('app\images\\'.$user->picture)) }} --}}
                                                        {{-- <img src="{{ asset('images/'.$user->picture) }}" alt="profil"class="users-avatar-shadow rounded-circle" height="64" width="64"> --}}
                                                    </td>
                                                    <td>{{ $user->fname }}</td>
                                                    <td>{{ $user->lname }}</td>
                                                    <td>{{ $user->phone }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>
                                                        <ul style="padding-left: -25px!important">
                                                            @foreach ($user->user_entity as $entity)
                                                                <li>{{ $entity->entity->sigle }}</li>
                                                            @endforeach
                                                        </ul>

                                                    </td>
                                                    @if (auth()->user()->isAdmin())
                                                        <td>    
                                                            <a href="{{ route('users.show', $user->id) }}" class="btn btn-primary" title="Cliquez pour voir les details">
                                                                <i class="ft-eye"></i> Voir
                                                            </a>
                                                            
                                                            <a href="#" onclick="document.getElementById('btn_destroy_{{ $user->id }}').click();" class="btn btn-danger" title="Cliquez pour voir les details">
                                                                <i class="ft-trash-2"></i> Supprimer
                                                            </a>

                                                            <form action="{{ route('users.destroy', $user->id) }}" method="post" class="d-none">
                                                                @csrf
                                                                <button type="submit" class="btn-primary btn" id="btn_destroy_{{ $user->id }}" onclick="confirm('Vous allez supprimer cet utilisateur');">
                                                                    supprimer
                                                                </button>
                                                            </form>
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endforeach

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

    <script>
        $(document).ready(function () {
            $('.table').DataTable().destroy();
            $('.table').DataTable({
                order: [[ 0, 'asc' ],[ 1, 'asc' ]],
            });
        });
    </script>
@endsection

