<div>
    <div class="card-body card-dashboard">
        <form method="POST" action="{{ route('de.store') }}" enctype="multipart/form-data" id="fd_form">
            @csrf
            <div class="modal-body">
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="destinataire">Destinataires <span class="text-danger"><sup>*</sup></span> </label>
                                        <select name="destinataire[]"  id="destinataire" value="{{ @old('destinataire') }}" class="select2 form-control  @error('destinataire') is-invalid @enderror" multiple="multiple" required>
                                            <option disabled> - Choisir les destinataires -</option>
                                            @foreach ($destinataires as $destinataire)
                                                <option value="{{ $destinataire->id }}"  @selected(old('destinataire') == $destinataire->id)> {{ $destinataire->fname }} {{ $destinataire->lname }} </option>
                                            @endforeach
                                        </select>
                                        @error('destinataire')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="motif_id">Motif <span class="text-danger"><sup>*</sup></span></label>
                                        <select name="motif_id" id="motif_id" value="{{ @old('motif_id') }}" class="select2 form-control  @error('motif_id') is-invalid @enderror" required>
                                            <option> - Choisir un motif -</option>
                                            @foreach ($motifs as $motif)
                                            <option value="{{ $motif->id }}" @selected(old('motif_id') == $motif->id)> {{ $motif->motif }} </option>
                                            @endforeach
                                        </select>
                                        @error('motif_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- <div class="col-md-12">
                                    <label>Personnes en copie</label>
                                    <select name="personnes_en_copie[]" class="select2 form-control @error('personnes_en_copie') is-invalid @enderror" id="personnes_en_copie" multiple="multiple">
                                        @foreach ($users_encopies as $users_encopie)
                                            <option value="{{ $users_encopie->id }}" >{{ $users_encopie->fname }} {{ $users_encopie->lname }}</option>
                                        @endforeach
                                    </select>
                                    @error('personnes_en_copie')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div> --}}

                                <div class="col-md-12">
                                    <livewire:pieces-jointes-input />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 col-12">
                            <div class="form-group">
                                <label for="description">Description de la demande <span class="text-danger"><sup>*</sup></span></label>
                                    @php
$description_de = "Madame/Monsieur,

Il a été donné de constater que ...

Le rapport de votre hiérarchie fait état de ...

Vous voudriez bien nous expliquer dans un délai de 72h dès réception de la présente les raisons de ...

<b>NB:</b> Le refus de réponse à la présente demande d’explications et dans les délais annoncés sera assimilé à un acte d’insubordination et traité comme tel.
";
                                    @endphp
                                <textarea name="description" class="form-control @error('personnes_en_copie') is-invalid @enderror" id="description" cols="30" rows="12">{!! @old('description', html_entity_decode($description_de)) !!}</textarea>
                                @error('personnes_en_copie')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <div class="row w-100">
                    <div class="col" style="margin-left:-15px;">
                        <a href="#" class="btn grey btn-danger h6">
                            <i class="icon-action-undo"></i>
                            Liste DE
                        </a>
                    </div>
                    <div class="col" style="margin-right:-15px;">
                        <button type="submit" id="submit_de" class="float-right btn btn-success h6" @disabled($errors->isNotEmpty()) wire:loading.attr="disabled">
                            <i class="ft-navigation"></i>
                            Envoyer
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
