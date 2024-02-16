<div wire:poll>
    {{-- Nothing in the world is as soft and yielding as water. --}}
    <label for="note_decision_sanction">Téléverser la note de décision de sanction (fichier .pdf)</label>
    <button type="button" class="btn btn-warning" onclick="document.getElementById('note_decision_sanction').click();">
        <i class="ft-upload"></i> cliquez ici pour Importer
    </button>
    @if(count($note_decision_sanction))
        @if (count($note_decision_sanction) == 1)
            {{ count($note_decision_sanction) }} fichier importé
        @else
            {{ count($note_decision_sanction) }} fichiers importés
        @endif
    @endif
    {{-- {{ count($note_decision_sanction)  }} --}}
    <br>

    <input type="file" id="note_decision_sanction" name="note_decision_sanction" wire:change="getFile();" wire:model="note_decision_sanction" class="d-none form-control @error('note_decision_sanction') is-invalid @enderror" required>
    <input type="text" id="demande_explication" value="{{ $demande->id }}" name="demande_explication_id" class="d-none form-control @error('demande_explication_id') is-invalid @enderror" required>
    @error('note_decision_sanction')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
