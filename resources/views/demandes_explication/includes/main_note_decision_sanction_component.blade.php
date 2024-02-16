<div class="pt-3 col-12" style="border-top:1px solid rgb(175, 170, 170)">
    <div class="row">
        <div class="col-md-6">
            <h5 class="text-bold">Note de décision de sanction </h5>
        </div>
        <div class="text-right col-md-6">
            <h6>
                <span class="text-bold">Par: </span>
                Ressources Humaines
            </h6>
        </div>
    </div>
    {{-- Condition si auth est admin ou rh affiche formulaire de saisie de note de decision de sanction --}}
    @if(!$demande->file_note_decision_sanction)
        @if ($demande->sanction->decision && (auth()->user()->isAdmin() || auth()->user()->isRh()))
            <form action="{{ route('sanctions.decision.note', auth()->user()->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="mt-3 form-group">
                    <livewire:televerser-note-decision-sanction :demande="$demande">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="ft-check"></i> Valider l'importation du fichier
                    </button>
                </div>
            </form>
        @else
        <div class="mt-2">
            <span class="text-danger text-bold h4">
            En attente de note de décision de sanction
            </span>
        </div>
        @endif
    @else
        <div class="mt-2">
            <span class="text-success text-bold h4">
                Note de décision de sanction déjà téléversée. Vous pouvez la télécharger ou l'imprimer ci-contre.
            </span>
        </div>
    @endif
</div>