<div wire:poll>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
    <label>
        Pièces jointes (images: jpeg, png, jpg)
        <small class="text-danger">
            @if(count($pieces_jointe))
                @if (count($pieces_jointe) == 1)
                    {{ count($pieces_jointe) }} fichier importé
                @else
                    {{ count($pieces_jointe) }} fichiers importés
                @endif
            @endif
        </small>
    </label>
    <label id="file" class="file center-block w-100">
        <button type="button" class="btn btn-default border w-100" onclick="document.getElementById('pieces_jointes_input').click();"> <i class="ft-upload"></i> Importer des pièces jointes</button>
        <input type="file" name="pieces_jointe[]" wire:model="pieces_jointe" id="pieces_jointes_input" class="d-none form-control @error('pieces_jointe') is-invalid @enderror" multiple >
        <span class="file-custom"></span>
    </label>
    @error('pieces_jointe.*')
    <span class="text-danger error">{{ $message }}</span>
    @enderror
    <div wire:loading wire:target="pieces_jointe">
        <span class="text-danger error">Importation de fichiers...</span>
    </div>

    {{-- @if ($pieces_jointe)
        <div class="row">
            @foreach ($pieces_jointe as $file)
                <div class="col-md-6 mt-3">
                    <?php try{ ?>
                        <img src="{{ $file->temporaryUrl() }}" width="100%" height="100%" class="rounded shadow">
                    <?php }catch(\Exception $e){ ?>
                        n'est pas une image
                    <?php } ?>
                </div>                
            @endforeach
        </div>
    @endif --}}

</div>
