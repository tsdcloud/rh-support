<form action="{{ route('sanctions.proposition', $notification->user_id) }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-5">
            <div class="form-group">
                <label for="proposition_sanction">Choisir une sanction <span class="text-danger"><sub>*</sub></span></label>
                <input type="text" class="d-none" name="demande_explication_id" value="{{ $demande->id }}">
                <select name="proposition_sanction" value="{{ @old('proposition_sanction') }}" id="proposition_sanction" class="form-control @error('proposition_sanction') is-invalid @enderror" required>
                    @foreach ($motif_sanctions as $motif_sanction)
                        <option value="{{ $motif_sanction->id }}" @selected(old('proposition_sanction') == $motif_sanction->id)>{{ $motif_sanction->motif }}</option>
                    @endforeach
                </select>
                @error('proposition_sanction')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-7">
            <div class="form-group">
                <label for="user_id">Choisir votre N+1 pour proposition de sanction</label>
                <select name="user_id" value="{{ @old('user_id') }}" id="user_id" class="form-control @error('user_id') is-invalid @enderror">
                    <option value="0" selected>Aucun</option>
                    @foreach ($hierarchic_superiors as $hierarchic_superior)
                        <option value="{{ $hierarchic_superior->id }}">{{ $hierarchic_superior->fname }} {{ $hierarchic_superior->lname }}</option>
                    @endforeach
                </select>
                @error('user_id')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-12">
            <livewire:pieces-jointes-input />
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="description_proposition">Description</label>
                <textarea name="description" id="description_proposition" class="form-control" cols="30" rows="10">{{ @old('description') }}</textarea>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 d-none form-group">
            <button type="submit" id="btn_validated_prop_sanction" class="btn btn-primary"> <i class="ft-check"></i> Valider</button>
        </div>
        <div class="col-md-6">                                                                                        
            <div class="form-group">
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#confirmSubmission"> <i class="ft-check"></i> Soumettre la proposition</a>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <a href="#" class="float-right btn btn-warning" data-toggle="modal" data-target="#invitationReponseSupplementaire"> <i class="ft-check"></i> Inviter pour plus d'info</a>
            </div>
        </div>                                                                                    
    </div>

    <!-- Modal -->
    @include('demandes_explication.includes.confirm_modal')                                                        
</form>