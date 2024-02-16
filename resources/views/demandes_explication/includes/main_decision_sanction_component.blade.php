<div class="pt-3 col-12" @if(reponses_supplementaires($demande) || $demande->notifications->where('motif','invitation_decision_sanction')->count()) style="border-top:1px solid rgb(175, 170, 170)" @endif>
    {{-- On verifie s'il ya deja eu des sanction sur cette demande --}}
    {{-- @if (!($decision_sanction = checkDecisionSanction($notification->demande_explication_id))) --}}
    {{-- @dd($notification->demande_explication_id) --}}
    @php
        $decision_sanction = checkDecisionSanction($notification->demande_explication_id);
    @endphp
    {{-- @dump ($demande->sanction == null)
    @dump($notification_invitation_decision_sanction != 0) --}}
    @if ($demande->sanction == null)
        @foreach (getDecideurSanctionDE() as $decideur)
            {{-- On verifie s'il ya des reponse supplementaires --}}
            @forelse($demande->reponse_supplementaires as $reponse_supplementaires)
                @if($decideur->id == $reponse_supplementaires->initiateur)
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="text-bold">Nouvelle interpellation </h5>
                        </div>
                        <div class="text-right col-md-6">
                            <h6>
                                <span class="text-bold">Par: </span>
                                {{ $decideur->fname }} {{ $decideur->lname }}
                            </h6>
                        </div>
                    </div>

                    <div class="row">
                        <div class="pt-1 pb-2 col-md-12">
                            {!! html_entity_decode($reponse_supplementaires->description) !!}
                        </div>
                        <div class="col-md-12">
                            <h6>
                                <span class="text-bold">Date: </span>
                                {{ $reponse_supplementaires->created_at }}
                            </h6>
                        </div>
                    </div>
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
                                    @if((strtotime($reponse_supplementaires->date_reponse) - strtotime($reponse_supplementaires->created_at)) <= 172800)
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
                                @if(($reponse_supplementaires->user_id == auth()->user()->id) && (strtotime($reponse_supplementaires->date_reponse) - strtotime($reponse_supplementaires->created_at)) <= 172800)

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
                    <hr>
                @endif
            @empty

            @endforelse
            {{-- @dump(!($decision_sanction = checkDecisionSanction($notification->demande_explication_id))) --}}

            @if ((reponses_supplementaires($demande) || $demande->notifications->where('motif','invitation_decision_sanction')->count()) && auth()->user()->id != $demande->destinataire)
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="text-bold">Décision de sanction </h5>
                    </div>
                    <div class="text-right col-md-6">
                        <h6>
                            <span class="text-bold">Par: </span>
                            {{ $decideur->fname }} {{ $decideur->lname }}
                        </h6>
                    </div>
                </div>
                @if ($decideur->id == auth()->user()->id)

                    <form action="{{ route('sanctions.decision', $notification->user_id) }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="proposition_sanction">Intitulé de la décision</label>
                                    <input type="text" class="d-none" name="demande_explication_id" value="{{ $demande->id }}">

                                    <select name="decision" value="{{ @old('decision') }}" id="{{ $notification->user_id }}" class="form-control @error('decision') is-invalid @enderror">
                                        @foreach ($motif_sanctions as $motif_sanction)
                                            <option value="{{ $motif_sanction->id }}">{{ $motif_sanction->motif }}</option>
                                        @endforeach
                                    </select>
                                    @error('decision')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description_proposition">Description</label>
                                    <textarea name="description" id="description_proposition" class="form-control" cols="30" rows="10">{{ @old('description') }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ft-check"></i> Valider
                                    </button>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <a href="#" class="float-right btn btn-warning" data-toggle="modal" data-target="#invitationReponseSupplementaire">
                                        <i class="ft-check"></i> Inviter pour plus d'info
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                    @include('demandes_explication.includes.invitation_reponse_supplementaire', ['demande' => $demande])

                @else
                    En attente de décision.
                @endif
            @endif
        @endforeach
        {{-- @endif --}}
    @else
        <div class="row">
            <div class="col-md-6">
                <h5 class="text-bold">Décision de sanction </h5>
            </div>
            <div class="text-right col-md-6">
                <h6>
                    <span class="text-bold">Par: </span>
                    {{ $decision_sanction->decideurs->fname }}
                    {{ $decision_sanction->decideurs->lname }}
                </h6>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <p>
                    {{ $decision_sanction->decisions->motif }}
                </p>
                <div class="row">
                    <div class="col-md-3"><span class="text-bold">Commentaire  </span></div>
                    <div class="col-md-9">
                        <p>
                            {!! html_entity_decode($decision_sanction->description) !!}
                        </p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-3"><span class="text-bold">Date  </span></div>
                    <div class="col-md-9">
                        <p>
                            {{ $decision_sanction->created_at }}
                        </p>
                    </div>
                </div>
                {{-- <p>
                    <span class="text-bold">Date : </span> {{ $decision_sanction->created_at }}
                </p> --}}
            </div>
        </div>

    @endif
</div>
