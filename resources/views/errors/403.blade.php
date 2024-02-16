@extends('layouts.master_auth')

@section('title', 'Voir une demande')

@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="mb-2 col-md-12 col-12 text-center">
            <h3 class="content-header-title">Bien vouloir choisir votre entité et fonction associée</h3>
        </div>
    </div>
    <div class="content-body"><!-- Zero configuration table -->
        <section id="configuration">
            <div class="row">
                @foreach (auth()->user()->user_entity as $entity)
                    <div class="col-md-4">
                        <div class="card">
                            <div class="text-center">
                                <div class="card-body">
                                    <img src="{{ asset('images/' . $entity->entity->logo) }}" class="rounded-circle  height-150" alt="Card image">
                                </div>
                                <div class="card-body">
                                    <h4 class="card-title">{{ auth()->user()->fname }} {{ auth()->user()->lname }}</h4>
                                    @if($entity->fonctions->count() <= 1)
                                        <div class="row">
                                            <div class="col-md-12 border-top pt-4">
                                                <form action="{{ route('entity.post', $entity->fonctions->first()->id) }}" method="post">
                                                    @csrf

                                                    <div class="form-group row">
                                                        <div class="col-md-6 d-flex align-items-center justify-content-center">
                                                            <h6 class="card-subtitle">
                                                                {{ $entity->fonctions->first()->fonction }} :
                                                            </h6>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <button type="submit" class="btn btn-primary">
                                                                <i class="ft-log-out"></i>
                                                                Se connecter
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    @else
                                        <div class="row">
                                            @foreach ($entity->fonctions as $fonction)
                                                <div class="col-md-12 border-top pt-4">
                                                    <form action="{{ route('entity.post', $fonction->id) }}" method="post">
                                                        @csrf

                                                        <div class="form-group row">
                                                            <div class="col-md-6 d-flex align-items-center justify-content-center">
                                                                <h6 class="card-subtitle">
                                                                    {{ $fonction->fonction }} :
                                                                </h6>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <button type="submit" class="btn btn-primary">
                                                                    <i class="ft-log-out"></i>
                                                                    Se connecter
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="text-center">
                        <a class="btn btn-warning" href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                            <i class="icon-login"></i> Se déconnecter ici
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

@endsection
{{-- -------------------------------- styles -------------------------------------- --}}

@section('styles')
    <!-- END: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">

@endsection
{{-- --------------------------------scripts -------------------------------------- --}}
@section('scripts')
    <!-- BEGIN: Vendor JS-->
    <script src="{{ asset('app-assets/vendors/js/vendors.min.js') }}"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{ asset('app-assets/js/scripts/footer.min.js') }}"></script>
    <!-- END: Theme JS-->

@endsection

