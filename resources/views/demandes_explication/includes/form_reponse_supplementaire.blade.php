<div class="text-left modal fade" id="form_reponse_supplementaire" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ route('de.answered.form_reponse_supplementaire', $reponse_supplementaires->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel1">Fournir plus d'informations</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="reponse">Votre réponse</label>
                            <textarea name="reponse" id="reponse" class="form-control @error('reponse') is-invalid
                            @enderror" cols="30" rows="10" required>{{ @old('reponse')}}</textarea>

                            @error('reponse')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
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
