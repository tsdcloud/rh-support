@php
                                                        $notification_invitation_decision_sanction = 0;
                                                    @endphp
                                                    @foreach ($demande->notifications as $notification)
                                                        @php
                                                            if($notification->motif == 'invitation_decision_sanction'){
                                                                $notification_invitation_decision_sanction ++;
                                                            }
                                                        @endphp
                                                        @if($notification->user_id != $demande->destinataire && $notification_invitation_decision_sanction == 0)
                                                            <div class="col-12 py-3" style="border-top:1px solid rgb(175, 170, 170)">

                                                                {{-- Verifier si l'utilisateur a deja fait une proposition de sanction --}}
                                                                @if ($proposition_sanction = checkPropositionSanction($notification->user_id, $notification->demande_explication_id))
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <h5 class="text-bold">Proposition de sanction</h5>
                                                                        </div>
                                                                        <div class="col-md-6 text-right">
                                                                            <h6>
                                                                                <span class="text-bold">Par: </span>
                                                                                {{ $proposition_sanction->user->fname }}
                                                                                {{ $proposition_sanction->user->lname }}
                                                                            </h6>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <p>
                                                                                {{ $proposition_sanction->proposition->motif }}
                                                                            </p>
                                                                            <p>
                                                                                <span class="text-bold">Date : </span>{{ $proposition_sanction->created_at }}
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <h5 class="text-bold">Proposition de sanction</h5>
                                                                        </div>
                                                                        <div class="col-md-6 text-right">
                                                                            <h6>
                                                                                <span class="text-bold">Par: </span>
                                                                                {{ $notification->user->fname }} {{ $notification->user->lname }}
                                                                            </h6>
                                                                        </div>
                                                                    </div>

                                                                    {{-- Verifier si l'utilisateur connecté est celui qui doit faire une proposition de sanction dans ce champs de formulaire --}}
                                                                    @if ($notification->user_id == auth()->user()->id && empty($demande->sanction))
                                                                        <form action="{{ route('sanctions.proposition', $notification->user_id) }}" method="post">
                                                                            @csrf
                                                                            <div class="row">
                                                                                <div class="col-md-5">
                                                                                    <div class="form-group">
                                                                                        <label for="proposition_sanction">Choisir une sanction</label>
                                                                                        <input type="text" class="d-none" name="demande_explication_id" value="{{ $demande->id }}">
                                                                                        <select name="proposition_sanction" value="{{ @old('proposition_sanction') }}" id="proposition_sanction" class="form-control @error('proposition_sanction') is-invalid @enderror">
                                                                                            @foreach ($motif_sanctions as $motif_sanction)
                                                                                                <option value="{{ $motif_sanction->id }}">{{ $motif_sanction->motif }}</option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                        @error('proposition_sanction')
                                                                                            <span class="text-danger">{{ $message }}</span>
                                                                                        @enderror
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-7">
                                                                                    <div class="form-group">
                                                                                        <label for="user_id">Choisir votre N+1 pour proposition de sanction</label>
                                                                                        <select name="user_id" value="{{ @old('user_id') }}" id="user_id" class="form-control @error('user_id') is-invalid @enderror">
                                                                                            <option value="0" selected>Aucun</option>
                                                                                            @foreach ($hierarchic_superiors as $hierarchic_superior)
                                                                                                <option value="{{ $hierarchic_superior->id }}">{{ $hierarchic_superior->fname }} {{ $hierarchic_superior->lname }}</option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                        @error('user_id')
                                                                                            <span class="text-danger">{{ $message }}</span>
                                                                                        @enderror
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <button type="submit" class="btn btn-primary"> <i class="ft-check"></i> Valider</button>
                                                                            </div>
                                                                        </form>
                                                                    @else
                                                                        En attente de proposition de sanction
                                                                    @endif
                                                                @endif
                                                            </div>
                                                        @endif
                                                    @endforeach