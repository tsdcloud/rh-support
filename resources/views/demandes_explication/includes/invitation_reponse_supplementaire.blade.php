<div class="text-left modal fade" id="invitationReponseSupplementaire" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ route('de.answered.supplementaire', $demande->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel1">Demander plus d'informations</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="reponse">Motif</label>
                            <select name="user_id" id="user_id" class="select2 form-control  @error('user_id') is-invalid @enderror" required>
                                <option value="0" disabled>- Choisir un destinataire -</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" @selected(old('user_id') == $user->id)>{{ $user->fname }} {{ $user->lname }}</option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-12">
                            <label for="description">Votre description</label>
                            <textarea name="description" id="description" class="form-control @error('description') is-invalid
                            @enderror" cols="30" rows="10">{{ @old('description')}}</textarea>

                            @error('description')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        {{-- <div class="col-md-12">

                            <livewire:pieces-jointes-input />

                        </div> --}}
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
