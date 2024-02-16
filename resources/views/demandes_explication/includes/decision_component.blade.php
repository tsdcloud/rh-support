<div class="col-12 pt-3" @if($notification_invitation_decision_sanction != 0) style="border-top:1px solid rgb(175, 170, 170)" @endif>
    @if ($decision_sanction = checkDecisionSanction($notification->demande_explication_id))
        <div class="row">
            <div class="col-md-6">
                <h5 class="text-bold">Décision de sanction </h5>
            </div>
            <div class="col-md-6 text-right">
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
                <p>
                    <span class="text-bold">Date : </span> {{ $decision_sanction->created_at }}
                </p>
            </div>
        </div>
    @else
        @if ($notification_invitation_decision_sanction != 0)
            @foreach (getDecideurSanctionDE() as $decideur)
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="text-bold">Décision de sanction </h5>
                    </div>
                    <div class="col-md-6 text-right">
                        <h6>
                            <span class="text-bold">Par: </span>
                            {{ $decideur->fname }} {{ $decideur->lname }}
                        </h6>
                    </div>
                </div>
                @if ($notification->user_id == auth()->user()->id)
                    <form action="{{ route('sanctions.decision', $notification->user_id) }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="proposition_sanction">Intitulé de la decision</label>
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
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"> <i class="ft-check"></i> Valider
                            </button>
                        </div>
                    </form>
                @else
                    En attente de décision.
                @endif
            @endforeach
        @endif
    @endif
</div>