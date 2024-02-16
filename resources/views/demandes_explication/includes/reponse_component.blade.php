<div class="col-12 pt-3" style="border-top:1px solid rgb(175, 170, 170)">
    <h5 class="text-bold">Réponse</h5>
    @if($demande->reponse)
        <p>{{ html_entity_decode($demande->reponse) }}</p>
        <p><span class="text-bold">Répondu le:</span> {{ $demande->date_reponse }}</p>
        {{-- <p><span class="text-bold">Répondu le:</span> {{ changeDateFormat($demande->date_reponse) }}</p> --}}
    @else
        <p>Aucune réponse pour le moment</p>
    @endif
</div>

@if (auth()->user()->id == $demande->destinataire)
    <div class="col-12" style="margin-bottom:15px">
        <button type="button" class="mt-1 btn btn-primary" data-toggle="modal" data-target="#demande_amswer{{ $demande->id }}" {{$demande->reponse ? 'disabled':''}} {{ !empty($demande->sanction) ? 'disabled':''}}>
            <i class="ft-edit"></i>
            Répondre
        </button>

        <!-- Modal -->
        <div class="text-left modal fade" id="demande_amswer{{ $demande->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form action="{{ route('de.answered', $demande->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel1">Répondre à la DE</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="reponse">Motif</label>
                                        <input type="text" value="{{ $demande->motif->motif }}" class="form-control" disabled>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="reponse">Votre réponse</label>
                                        <textarea name="reponse" id="reponse" class="form-control @error('reponse') is-invalid
                                        @enderror" cols="30" rows="10">{{ old('reponse')}}</textarea>

                                        @error('reponse')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <label>Pièces jointes</label>
                                        <label id="file" class="file center-block w-100">
                                            <button type="button" onclick="document.getElementById('pieces_jointes_input').click();" name="pieces_jointe[]" class="form-control btn btn-default border @error('pieces_jointe') is-invalid @enderror">
                                                <i class="ft-upload"></i>
                                                Importer des pièces jointes
                                            </button>
                                            <input type="file" name="pieces_jointe[]" id="pieces_jointes_input" class="d-none form-control  @error('pieces_jointe') is-invalid @enderror" multiple >
                                            <span class="file-custom"></span>
                                        </label>
                                        @error('pieces_jointe')
                                        <span class="text-danger">{{ $message }}</span>
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
    </div>
@endif