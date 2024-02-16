<div>
    <div>
        <div>
            <button class="btn btn-danger" wire:click="$emit('triggerDelete',{{ $privilege_id }})">
                <i class="ft-trash-2"></i> Rétirer
            </button>
        </div>
    
        @push('scripts')
        <script type="text/javascript">
            // import Swal from 'sweetalert';
    
            document.addEventListener('DOMContentLoaded', function () {
                @this.on('triggerDelete', privilege_id => {
                    swal({
                        title: "Etes-vous sûr?",
                        text: "Vous allez rétirer ce privilège!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Supprimer",
                        cancelButtonText: "Annuler",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                    function(isConfirm) {
                    if (isConfirm) {
                        @this.call('destroy',privilege_id)
                        swal("Deleted!", "Privilège rétiré avec succès", "success");
                    } else {
                        swal("Cancelled", "Suppression annulée :)", "error");
                    }
                    });
                });
            })
        </script>
        @endpush
    </div>
</div>
