<div wire:poll>
    <form action="{{ route('sanctions.history.add') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="user_id">Choisir l'utilisateur<span class="text-danger"><sub>*</sub></span></label>
                            <select id="user_id" name="user_id" class="select2 form-control @error('user_id') is-invalid @enderror" required>
                                <option selected="" disabled=""> ---- Choisir l'utilisateur ----</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" @selected(old('user_id') == $user->id)>
                                        {{ $user->fname }} {{ $user->lname }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('user_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="motif_sanction_id">Sanction<span class="text-danger"><sub>*</sub></span></label>
                            <select id="motif_sanction_id" name="motif_sanction_id" class="select2 form-control @error('motif_sanction_id') is-invalid @enderror" required>
                                <option selected="" disabled=""> --- Choisir la sanction ---</option>
                                @foreach ($motif_sanctions as $motif_sanction)
                                    <option value="{{ $motif_sanction->id }}" @selected(old('motif_sanction_id') == $motif_sanction->id)>
                                        {{ $motif_sanction->motif }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('motif_sanction_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="motif_outdate">Motif de sanction<span class="text-danger"><sub>*</sub></span></label>
                            <input type="text" id="motif_outdate" name="motif_outdate" class="form-control @error('motif_outdate') is-invalid @enderror" placeholder="Motif de sanction" required>
                        </div>
                        @error('motif_outdate')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="motif_id">Nouvel intitulé du motif<span class="text-danger"><sub>*</sub></span></label>
                            <select id="motif_id" name="motif_id" class="select2 form-control @error('motif_id') is-invalid @enderror" required>
                                <option selected="" disabled=""> --- Choisir le motif ---</option>
                                @foreach ($motifs as $motif)
                                    <option value="{{ $motif->id }}" @selected(old('motif_id') == $motif->id)>
                                        {{ $motif->motif }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('motif_outdate_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    {{-- <div class="col-md-3">
                        <div class="form-group">
                            <label for="fonction">Fonction<span class="text-danger"><sub>*</sub></span></label>
                            <input type="text" id="fonction" name="fonction" value="{{ old('fonction') }}" class="form-control @error('fonction') is-invalid @enderror" placeholder="Titre de la fonction" required>
                        </div>
                        @error('fonction')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div> --}}
                </div>
            </div>
        </div>
        <div class="modal-footer row" style="margin-right: 0px!important;margin-left: 0px!important;">
            <div class="col" style="margin-left: -15px!important;">
                <button type="button" class="btn grey btn-danger" data-dismiss="modal">
                    <i class="ft-x"></i>
                    Fermer
                </button>
            </div>
            <div class="col" style="margin-right: -15px!important;">
                <button type="submit" class="float-right btn btn-success">
                    <i class="ft-plus"></i>
                    Ajouter
                </button>
            </div>
        </div>
    </form>
</div>
