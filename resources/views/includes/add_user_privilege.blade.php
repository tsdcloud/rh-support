<a href="#" class="btn btn-success" data-toggle="modal" data-target="#addprivilege">
    <i class="ft-plus-circle"></i> Ajouter un privilège
</a>

<div class="modal fade text-left" id="addprivilege" tabindex="-1" role="dialog" aria-labelledby="addusers"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">                                                   
                <h4 class="modal-title" id="addusers"><i class="ft-settings"></i> Ajouter un privilège</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route('users.store.privilege', $user->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-body">                                
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="role_id">Choisir un privilège<span class="text-danger"><sub>*</sub></span></label>
                                    <select id="role_id" name="role_id" class="form-control @error('role_id') is-invalid @enderror" required>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->title }}</option>
                                        @endforeach
                                        <option value="0">Décideur des sanctions</option>
                                    </select>
                                </div>
                                @error('role_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="entity_id">Entité<span class="text-danger"><sub>*</sub></span></label>
                                    <select id="entity_id" name="entity_id" class="form-control @error('entity_id') is-invalid @enderror" required>
                                        @foreach ($entities as $entity)
                                            <option value="{{ $entity->id }}" {{ $user_entity->entity->id == $entity->id ? 'selected':''}}>{{ $entity->sigle }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('entity_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            {{-- <div class="col-md-12 d-flex align-items-center">
                                <div class="form-group row w-100">
                                    <div class="col-md-9 d-flex align-items-center">
                                        <label for="decideur_sanction">Décideur de sanction ?</span></label>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="checkbox" id="decideur_sanction" name="decideur_sanction" class="form-control @error('decideur_sanction') is-invalid @enderror">
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
                <div class="modal-footer row" style="margin-right: 0px!important;margin-left: 0px!important;">
                    <div class="col" style="margin-left: -15px!important;">
                        <button type="button" class="btn grey btn-danger" data-dismiss="modal">
                            <i class="ft-x"></i>
                            Fermer
                        </button>
                    </div>
                    <div class="col" style="margin-right: -15px!important;">
                        <button type="submit" class="btn btn-success float-right">
                            <i class="ft-plus"></i>
                            Ajouter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>