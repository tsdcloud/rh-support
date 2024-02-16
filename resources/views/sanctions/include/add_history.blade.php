<button class="btn btn-success" type="button"  data-toggle="modal" data-target="#addhistory">
    <i class="ft-user-plus"></i> Ajouter une historique
</button>
<div class="text-left modal fade" id="addhistory" tabindex="-1" role="dialog" aria-labelledby="addhistory"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">                                                   
                <h4 class="modal-title" id="addusers"><i class="ft-user"></i> Ajouter une historique de sanction</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <livewire:add-sanction-history />
        </div>
    </div>
</div>