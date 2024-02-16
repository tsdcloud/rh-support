<div>
    {{-- Success is as dangerous as failure. --}}
    <div class="row">
        @if($activeFilter)
            <div class="col-12 mb-2">
                <button class="btn btn-warning">
                    <i class="ft-alert-triangle"></i>
                    Les chiffres ci-dessous sont les informations des 7 derniers jours de l'entité {{ $entity->sigle }}
                </button>
            </div>
        @endif
        <div class="col-12">
            <div class="card">
                <div class="mx-1 card-header">
                    <form class="row" wire:submit.prevent="filterData()">
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <label for="entity_id">Entité</label>
                                    <select wire:model="entity_id" class="form-control @error('entity_id') is-invalid @enderror select2" required>
                                        @foreach ($entities as $entity)
                                            <option value="{{ $entity->id }}">{{ $entity->sigle }}</option>
                                        @endforeach
                                    </select>
                                    @error('entity_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="date_debut">Date de début (mois/jour/année)</label>
                                    <input type="date" wire:model="date_debut" id="date_debut" class="form-control @error('date_debut') is-invalid @enderror " value="{{ @old('date_debut') }}">
                                    @error('date_debut')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="date_fin">Date de fin (mois/jour/année)</label>
                                    <input type="date" wire:model="date_fin" id="date_fin" class="form-control @error('date_fin') is-invalid @enderror " value="{{ $date_fin }}">
                                    @error('date_fin')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="emetteur_id">DE initiée par</label>
                                    <select wire:model="emetteur_id" class="form-control @error('emetteur_id') is-invalid @enderror select2">
                                        <option>Choisir l'emetteur</option>
                                        @foreach ($emetteurs as $emetteur)
                                            <option value="{{ $emetteur->id }}">{{ $emetteur->lname }} {{ $emetteur->fname }}</option>
                                        @endforeach
                                    </select>
                                    @error('emetteur_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="destinataire_id">DE adressée à</label>
                                    <select wire:model="destinataire_id" id="" class="form-control @error('destinataire_id') is-invalid @enderror select2">
                                        <option>Choisir le destinataire</option>
                                        @foreach ($destinataires as $destinataire)
                                            <option value="{{ $destinataire->id }}">{{ $destinataire->lname }} {{ $destinataire->fname }}</option>
                                        @endforeach
                                    </select>
                                    @error('destinataire_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label for="filtrer" class="text-white">filtrer</label>
                                    <button wire:loading  wire:target="filterData" class="btn btn-primary form-control" type="button" disabled>
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                        Filtrage...
                                    </button>
                                    <button wire:loading.remove type="submit" class="text-white btn btn-primary form-control"> <i class="ft-filter"></i> Filtrer</button>
                                </div>
                                <div class="col-md-12 form-group">
                                    <label for="filtrer" class="text-white">filtrer</label>
                                    <button type="submit" class="text-white btn btn-success form-control"> <i class="ft-upload"></i> Exporter sous Excel</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card">
                <div class="mx-1 card-header">
                    <div class="row">
                        <div class="col-xl-4 col-md-6 col-12">
                          <div class="card bg-info">
                            <div class="card-content">
                              <div class="card-body">
                                <div class="media d-flex">
                                  <div class="align-self-center">
                                    <i class="icon-pencil text-white font-large-2 float-left"></i>
                                  </div>
                                  <div class="media-body text-white text-right">
                                    <h3 class="text-white">{{$nb_de_initated}}</h3>
                                    <span>Nombre de DE initiées</span>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-md-6 col-12">
                            <div class="card bg-warning">
                                <div class="card-content">
                                  <div class="card-body">
                                      <div class="media d-flex">
                                          <div class="align-self-center">
                                              <i class="icon-speech text-white font-large-2 float-left"></i>
                                          </div>
                                          <div class="media-body text-white text-right">
                                              <h3 class="text-white">{{$nb_de_not_answered}}</h3>
                                              <span>Nombre de DE non répondues</span>
                                          </div>
                                      </div>
                                  </div>
                                </div>
                            </div>
                          </div>
                        <div class="col-xl-4 col-md-6 col-12">
                            <div class="card bg-danger">
                              <div class="card-content">
                                <div class="card-body">
                                  <div class="media d-flex">
                                    <div class="align-self-center">
                                      <i class="icon-graph text-white font-large-2 float-left"></i>
                                    </div>
                                    <div class="media-body text-white text-right">
                                      <h3 class="text-white">{{ $nb_de_answered }}</h3>
                                      <span>Nombre de DE répondues</span>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6 col-12">
                            <div class="card bg-success">
                              <div class="card-content">
                                <div class="card-body">
                                  <div class="media d-flex">
                                    <div class="align-self-center">
                                      <i class="icon-pointer text-white font-large-2 float-left"></i>
                                    </div>
                                    <div class="media-body text-white text-right">
                                      <h3 class="text-white">{{ $nb_de_without_sanction }}</h3>
                                      <span>Nombre de DE sans sanction</span>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-4 col-md-6 col-12">
                            <div class="card bg-info">
                              <div class="card-content">
                                <div class="card-body">
                                  <div class="media d-flex">
                                    <div class="align-self-center">
                                      <i class="icon-graph text-white font-large-2 float-left"></i>
                                    </div>
                                    <div class="media-body text-white text-right">
                                      <h3 class="text-white">{{ $nb_de_with_sanction }}</h3>
                                      <span>Nombre de DE avec sanction</span>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-4 col-md-6 col-12">
                            <div class="card bg-warning">
                              <div class="card-content">
                                <div class="card-body">
                                  <div class="media d-flex">
                                    <div class="align-self-center">
                                      <i class="icon-speech text-white font-large-2 float-left"></i>
                                    </div>
                                    <div class="media-body text-white text-right">
                                      <h3 class="text-white">{{$nb_de_not_notified}}</h3>
                                      <span>Nombre de DE non notifiées</span>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6 col-12">
                            <div class="card bg-danger">
                              <div class="card-content">
                                <div class="card-body">
                                  <div class="media d-flex">
                                    <div class="align-self-center">
                                      <i class="icon-speech text-white font-large-2 float-left"></i>
                                    </div>
                                    <div class="media-body text-white text-right">
                                      <h3 class="text-white">{{ $nb_de_with_sanction - $nb_de_not_notified}}</h3>
                                      <span>Nombre de DE notifiées</span>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                        
                    {{-- </div>

                    <div class="row"> --}}
                        
                        <div class="col-xl-4 col-md-6 col-12">
                            <div class="card bg-success">
                              <div class="card-content">
                                <div class="card-body">
                                  <div class="media d-flex">
                                    <div class="align-self-center">
                                      <i class="icon-pointer text-white font-large-2 float-left"></i>
                                    </div>
                                    <div class="media-body text-white text-right">
                                      <h3 class="text-white">{{ $nb_de_answered_ontime }}</h3>
                                      <span>Nombre de DE répondues dans les délais</span>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-md-6 col-12">
                            <div class="card bg-info">
                                <div class="card-content">
                                    <div class="card-body">
                                    <div class="media d-flex">
                                        <div class="align-self-center">
                                        <i class="icon-pencil text-white font-large-2 float-left"></i>
                                        </div>
                                        <div class="media-body text-white text-right">
                                        <h3 class="text-white">{{$nb_de_answered_late}}</h3>
                                        <span>Nombre de DE répondues en retard</span>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-md-6 col-12">
                          <div class="card bg-warning">
                            <div class="card-content">
                              <div class="card-body">
                                <div class="media d-flex">
                                  <div class="align-self-center">
                                    <i class="icon-pencil text-white font-large-2 float-left"></i>
                                  </div>
                                  <div class="media-body text-white text-right">
                                    <h3 class="text-white">{{$nb_de_not_answered_ontime}}</h3>
                                    <span>DE non répondues et dans les délais</span>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-md-6 col-12">
                          <div class="card bg-danger">
                            <div class="card-content">
                              <div class="card-body">
                                <div class="media d-flex">
                                  <div class="align-self-center">
                                    <i class="icon-speech text-white font-large-2 float-left"></i>
                                  </div>
                                  <div class="media-body text-white text-right">
                                    <h3 class="text-white">{{$nb_de_not_answered_late}}</h3>
                                    <span>DE non répondues et en retard</span>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        
                        <div class="col-xl-4 col-md-6 col-12">
                            <div class="card bg-success">
                                <div class="card-content">
                                    <div class="card-body">
                                    <div class="media d-flex">
                                        <div class="align-self-center">
                                        <i class="icon-pencil text-white font-large-2 float-left"></i>
                                        </div>
                                        <div class="media-body text-white text-right">
                                        <h3 class="text-white">{{$nb_de_order_reminder}}</h3>
                                        <span>Nombre de DE avec rappel à l'ordre</span>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6 col-12">
                          <div class="card bg-info">
                              <div class="card-content">
                                <div class="card-body">
                                    <div class="media d-flex">
                                        <div class="align-self-center">
                                            <i class="icon-speech text-white font-large-2 float-left"></i>
                                        </div>
                                        <div class="media-body text-white text-right">
                                            <h3 class="text-white">{{$nb_de_with_mapd}}</h3>
                                            <span>Nombre de DE avec mise à pieds</span>
                                        </div>
                                    </div>
                                </div>
                              </div>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
