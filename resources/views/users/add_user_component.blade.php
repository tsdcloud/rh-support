<button class="btn btn-success" type="button"  data-toggle="modal" data-target="#addusers">
    <i class="ft-user-plus"></i> Nouveau utilisateur
</button>
<div class="modal fade text-left" id="addusers" tabindex="-1" role="dialog" aria-labelledby="addusers"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">                                                   
                <h4 class="modal-title" id="addusers"><i class="ft-user"></i> Ajouter un utilisateur</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route('users.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-body">

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="fname">Nom<span class="text-danger"><sub>*</sub></span></label>
                                    <input type="text" name="fname" id="fname" value="{{ @old('fname') }}" class="form-control  @error('fname') is-invalid @enderror" placeholder="Nom" required>
                                    @error('fname')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="lname">Prénom<span class="text-danger"><sub>*</sub></span></label>
                                    <input type="text" name="lname" id="lname" value="{{ @old('lname') }}" class="form-control  @error('lname') is-invalid @enderror" placeholder="Prénom"  required>
                                    @error('lname')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="email">E-mail<span class="text-danger"><sub>*</sub></span></label>
                                    <input type="email" name="email" id="email" value="{{ @old('email') }}" class="form-control  @error('email') is-invalid @enderror" placeholder="E-mail" required>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="phone">Téléphone<span class="text-danger"><sub>*</sub></span></label>
                                    <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" class="form-control  @error('phone') is-invalid @enderror" placeholder="Téléphone" required>
                                    @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="entity_id">Entité<span class="text-danger"><sub>*</sub></span></label>
                                    <select id="entity_id" name="entity_id" class="form-control @error('entity_id') is-invalid @enderror" required>
                                        <option selected="" disabled=""> ---- Choisir une entité ----</option>
                                        @foreach ($entities as $entity)
                                            <option value="{{ $entity->id }}" @selected(old('entity_id') == $entity->id)>{{ $entity->sigle }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('entity_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="grade_id">Grade<span class="text-danger"><sub>*</sub></span></label>
                                    <select id="grade_id" name="grade_id" class="form-control @error('grade_id') is-invalid @enderror" required>
                                        <option selected="" disabled=""> ---- Choisir un grade ----</option>
                                        @foreach ($grades as $grade)
                                            <option value="{{ $grade->id }}" @selected(old('grade_id') == $grade->id)>{{ $grade->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('grade_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="department_id">Département<span class="text-danger"><sub>*</sub></span></label>
                                    <select id="department_id" name="department_id" class="form-control @error('department_id') is-invalid @enderror" required>
                                        <option selected="" disabled=""> ---- Choisir un département ----</option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}" @selected(old('department_id') == $department->id)>{{ $department->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('department_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="fonction">Fonction<span class="text-danger"><sub>*</sub></span></label>
                                    <input type="text" id="fonction" name="fonction" value="{{ old('fonction') }}" class="form-control @error('fonction') is-invalid @enderror" placeholder="Titre de la fonction" required>
                                </div>
                                @error('fonction')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="category_id">Catégorie<span class="text-danger"><sub>*</sub></span></label>
                                    <select id="category_id" name="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                                        <option selected="" disabled=""> ---- Choisir une catégorie ----</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" @selected(old('category_id') == $category->id) >{{ $category->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('category_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="echelon_id">Echelon<span class="text-danger"><sub>*</sub></span></label>
                                    <select id="echelon_id" name="echelon_id" class="form-control @error('echelon_id') is-invalid @enderror" required>
                                        <option selected="" disabled=""> ---- Choisir un échelon ----</option>
                                        @foreach ($echelons as $echelon)
                                            <option value="{{ $echelon->id }}" @selected(old('echelon_id') == $echelon->id)>{{ $echelon->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('echelon_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-3 d-flex align-items-center">
                                <div class="form-group row w-100">
                                    <div class="col-md-9 d-flex align-items-center">
                                        <label for="decideur_sanction">Décideur de sanction ?</span></label>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="checkbox" id="decideur_sanction" name="decideur_sanction" class="form-control @error('decideur_sanction') is-invalid @enderror">
                                    </div>
                                </div>
                            </div>
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