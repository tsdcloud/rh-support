<div>
    {{-- Because she competes with no one, no one can compete with her. --}}
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="destinataire">Choisir l'entité <span class="text-danger"><sup>*</sup></span> </label>
                <select name="destinataire"  id="destinataire" wire:change="changeEntity()" wire:model="entity_id" value="{{ @old('destinataire') }}" class="select2 form-control  @error('destinataire') is-invalid @enderror" required>
                    <option> - Choisir une entité -</option>
                    @foreach ($entities as $entity)
                        <option value="{{ $entity->id }}"> {{ $entity->sigle }}</option>
                    @endforeach
                </select>
                @error('destinataire')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="destinataire">Destinataire <span class="text-danger"><sup>*</sup></span> </label>
                <select name="destinataire"  id="destinataire" value="{{ @old('destinataire') }}" wire:change="getDestinataire()" wire:model="destinataire" class="select2 form-control  @error('destinataire') is-invalid @enderror" required>
                    <option> - Choisir un destinataire -</option>
                    @foreach ($destinataires as $destinataire)
                        <option value="{{ $destinataire->id }}"> {{ $destinataire->fname }} {{ $destinataire->lname }} </option>
                    @endforeach
                </select>
                @error('destinataire')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="destinataire">Faire valider par <span class="text-danger"><sup>*</sup></span> </label>
                <select name="destinataire"  id="destinataire" value="{{ @old('initiateur') }}" wire:model="initiateur" class="select2 form-control  @error('destinataire') is-invalid @enderror" required>
                    <option> - Choisir un destinataire -</option>
                    @foreach ($destinataires as $destinataire)
                        <option value="{{ $destinataire->id }}"> {{ $destinataire->fname }} {{ $destinataire->lname }} </option>
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
                    <option value="{{ $motif->id }}"> {{ $motif->motif }} </option>
                    @endforeach
                </select>
                @error('motif_id')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-12">
            <livewire:pieces-jointes-input />
        </div>
    </div>
</div>
