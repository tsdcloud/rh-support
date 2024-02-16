@if(($notification->user_id != $demande->destinataire && $notification_invitation_decision_sanction == 0) || auth()->user()->isRh())
<div class="col-12">

    {{-- @if (auth()->user()->id != $demande->destinataire)
    @endif --}}

        {{-- Verifier si l'utilisateur a deja fait une proposition de sanction --}}
        @php
            $count = 1;
        @endphp
        {{-- @dump(21) --}}
        @forelse($demande->reponse_supplementaires as $reponse_supplementaires)
            @if($notification->user_id == $reponse_supplementaires->initiateur && !$reponse_supplementaires->initiateurs->isDecideurSanction())
                <div class="py-2 row" style="border-top:1px solid rgb(175, 170, 170)">
                    <div class="col-md-6">
                        <h5 class="text-bold">Nouvelle interpellation</h5>
                    </div>
                    <div class="text-right col-md-6">
                        <h6>
                            <span class="text-bold">Par: </span>
                            {{ $notification->user->fname }} {{ $notification->user->lname }}
                        </h6>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        {!! html_entity_decode($reponse_supplementaires->description) !!}
                    </div>
                    <div class="pt-1 col-md-12">
                        <h6>
                            <span class="text-bold">Date: </span>
                            {{ $reponse_supplementaires->created_at }}
                        </h6>
                    </div>
                </div>
                <!-- Fin description interpellation -->

                <!-- Reponse interpellation -->
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="text-bold">Réponse interpellation</h5>
                    </div>
                    <div class="text-right col-md-6">
                        <h6>
                            <span class="text-bold">Par: </span>
                            {{ $reponse_supplementaires->user->fname }} {{ $reponse_supplementaires->user->lname }} <br>
                            @if($reponse_supplementaires->reponse)
                                <!-- 259200 = 72h -->
                                @if((strtotime($reponse_supplementaires->date_reponse) - strtotime($reponse_supplementaires->created_at)) <= 259200)
                                    <span class="badge badge-success"><i class="ft-check"></i> Répondu dans les délais</span>
                                @else
                                    <span class="badge badge-warning"><i class="ft-alert-triangle"></i> Répondu en retard</span>
                                @endif
                            @else
                                <span class="badge badge-danger"><i class="ft-x"></i> Non répondu</span>
                            @endif
                        </h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        @if($reponse_supplementaires->reponse)
                            <p>{!! html_entity_decode($reponse_supplementaires->reponse) !!}</p>
                            <p><span class="text-bold">Répondu le:</span> {{ $reponse_supplementaires->date_reponse }}</p>

                        @else
                            @if(($reponse_supplementaires->user_id == auth()->user()->id) && (strtotime($reponse_supplementaires->date_reponse) - strtotime($reponse_supplementaires->created_at)) <= 259200)

                                <div class="form-group">
                                    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#form_reponse_supplementaire"> <i class="ft-edit"></i> Répondre ici</a>
                                </div>

                                {{ $reponse_supplementaires->demande }}

                                @include('demandes_explication.includes.form_reponse_supplementaire', ['reponse_supplementaires' => $reponse_supplementaires])

                            @else
                                <p>Aucune réponse pour le moment</p>
                            @endif
                        @endif
                    </div>
                </div>
                <!-- Fin Reponse interpellation -->
            @endif
        @empty
            <!-- Verifier si l'utilisateur connecté est celui qui doit faire une proposition de sanction dans ce champs de formulaire -->
            {{-- @if (auth()->user()->id != $demande->destinataire)
                <div class="py-2 row" style="border-top:1px solid rgb(175, 170, 170)">
                    <div class="col-md-6">
                        <h5 class="text-bold">Proposition de sanction</h5>
                    </div>
                    <div class="text-right col-md-6">
                        <h6>
                            <span class="text-bold">Par: </span>
                            {{ $notification->user->fname }} {{ $notification->user->lname }}
                        </h6>
                    </div>
                </div>
                <!-- Verifier si cette personne a deja fait une proposition de sanction -->
                @if ($proposition_sanction = checkPropositionSanction($notification->user_id, $notification->demande_explication_id))

                    <div class="row">
                        <div class="col-md-12">
                            <p>
                                {{ $proposition_sanction->proposition->motif }}
                            </p>
                            <hr>
                            <div class="row">
                                <div class="col-md-3"><span class="text-bold">Commentaire  </span></div>
                                <div class="col-md-9">
                                    <p>
                                        {!! html_entity_decode($proposition_sanction->description) !!}
                                    </p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-3"><span class="text-bold">Date  </span></div>
                                <div class="col-md-9">
                                    <p>
                                        {{ $proposition_sanction->created_at }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @else

                    @if ($notification->user_id == auth()->user()->id && empty($demande->sanction))
                        @include('demandes_explication.includes.form_proposition_sanction', ['demande' => $demande, 'notification' => $notification, 'motif_sanctions' => $motif_sanctions, 'hierarchic_superiors' => $hierarchic_superiors])
                        @include('demandes_explication.includes.invitation_reponse_supplementaire', ['demande' => $demande])
                    @else
                        En attente de proposition de sanction
                    @endif
                @endif
            @endif --}}
        @endforelse
        {{--  --}}
        {{-- On verifie s'il faut deja afficher les propositions de sanctions --}}
        {{-- @dump(!reponses_supplementaires($demande)) --}}
        @if (!reponses_supplementaires($demande))

            @if (auth()->user()->id != $demande->destinataire || (auth()->user()->id == $demande->destinataire && $demande->sanction))
                
                @if ($proposition_sanction = checkPropositionSanction($notification->user_id, $notification->demande_explication_id))
                    <div class="row"  style="border-top:1px solid rgb(175, 170, 170);padding-top:20px!important">
                        <div class="col-md-6">
                            <h5 class="text-bold">Proposition de sanction</h5>
                        </div>
                        <div class="text-right col-md-6">
                            <h6>
                                <span class="text-bold">Par: </span>
                                {{ $proposition_sanction->user->fname }}
                                {{ $proposition_sanction->user->lname }}
                            </h6>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <p>
                                {{ $proposition_sanction->proposition->motif }}
                            </p>
                            <hr>
                            <div class="row">
                                <div class="col-md-3"><span class="text-bold">Commentaire  </span></div>
                                <div class="col-md-9">
                                    <p>
                                        {!! html_entity_decode($proposition_sanction->description) !!}
                                    </p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-3"><span class="text-bold">Date  </span></div>
                                <div class="col-md-9">
                                    <p>
                                        {{ $proposition_sanction->created_at }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    @if($notification->motif == 'proposition_sanction' && !$notification->user->isDecideurSanction() )
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="text-bold">Proposition de sanction</h5>
                            </div>
                            <div class="text-right col-md-6">
                                <h6>
                                    <span class="text-bold">Par : </span>
                                    {{ $notification->user->fname }}
                                    {{ $notification->user->lname }}
                                </h6>
                            </div>
                        </div>
                        @if ($notification->user_id == auth()->user()->id && empty($demande->sanction))
                            @include('demandes_explication.includes.form_proposition_sanction', ['demande' => $demande, 'notification' => $notification, 'motif_sanctions' => $motif_sanctions, 'hierarchic_superiors' => $hierarchic_superiors])
                            @include('demandes_explication.includes.invitation_reponse_supplementaire', ['demande' => $demande])
                        @else
                            En attente de proposition de sanction
                        @endif
                    @endif
                @endif
            @endif

        @endif
    {{-- @if (auth()->user()->id != $demande->destinataire)
    @endif --}}
</div>
@endif
