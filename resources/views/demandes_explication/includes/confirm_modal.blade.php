<div class="text-left modal fade" id="confirmSubmission" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel1">Vous allez soumettre votre proposition</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <i class="ft-alert-triangle text-warning" style="font-size: 4em"></i>
                    </div>
                    <div class="col-md-12 text-center">
                        Ne voulez-vous pas demander plus d'informations ou inviter un supérieur pour proposition de sanction ?
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row w-100" style="margin-left:-15px;">
                    <div class="col-md-6" style="margin-left:-15px;">
                        <a href="#" class="btn grey btn-danger" data-dismiss="modal"> <i class="ft-x"></i> Je vérifie</a>
                    </div>
                    <div class="col-md-6">
                        {{-- <a href="#" id="validated_submission" class="btn btn-primary float-right" onclick="document.getElementById('btn_validated_prop_sanction').click();document.getElementById('validated_submission');"> <i class="ft-navigation"></i> Je soumets</a> --}}
                        <button type="submit" class="btn btn-primary float-right"> <i class="ft-navigation"></i> Je soumets</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
