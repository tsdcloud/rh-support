<div class="header-navbar navbar-expand-sm navbar navbar-horizontal navbar-fixed navbar-dark navbar-without-dd-arrow navbar-shadow" role="navigation" data-menu="menu-wrapper">
    <div class="navbar-container main-menu-content" data-menu="menu-container">
        <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="nav-item {{ setMenuActive('home') }}">
                <a class="nav-link" href="{{ route('home') }}">
                    <i class="ft-home"></i>
                    <span>
                        Tableau de bord
                    </span>
                </a>
            </li>
            <li class=" nav-item dropdown {{ setMenuActive('de') }}" data-menu="dropdown">
                <a class="nav-link dropdown-toggle " href="#" data-toggle="dropdown">
                    <i class="icon-layers"></i>
                    <span data-i18n="Apps">Demandes d'explication</span>
                </a>
                <ul class="dropdown-menu">
                    <li data-menu="">
                        <a class="dropdown-item" href="{{ route('de.create') }}" data-toggle="">
                            <i class="ft-file-plus"></i>
                            <span data-i18n="News Feed">Initier</span>
                        </a>
                    </li>
                    {{-- <li data-menu="">
                        <a class="dropdown-item" href="#" data-toggle="">
                            <i class="ft-file-text"></i>
                            <span data-i18n="News Feed">Transférer</span>
                        </a>
                    </li> --}}
                    <li data-menu="">
                        <a class="dropdown-item" href="{{ route('de.inprocess') }}" data-toggle="">
                            <i class="ft-file-text"></i>
                            <span data-i18n="News Feed">En cours de traitement</span>
                        </a>
                    </li>
                    <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu">
                        <a class="dropdown-item" href="{{ route('de.notanswered') }}" data-toggle="dropdown">
                            <i class="ft-file-text"></i>
                            <span data-i18n="News Feed">Non répondues</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li data-menu="">
                                <a class="dropdown-item" href="{{ route('de.notanswered.ontime') }}" data-toggle="">
                                    <span data-i18n="Invoice Template">Dans les délais</span>
                                </a>
                            </li>
                            <li data-menu="">
                                <a class="dropdown-item" href="{{ route('de.notanswered.late') }}" data-toggle="">
                                    <span data-i18n="En retard">Hors délais</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu">
                        <a class="dropdown-item" href="{{ route('de.alreadyanswered') }}" data-toggle="dropdown">
                            <i class="ft-file-text"></i>
                            <span data-i18n="News Feed">Répondues</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li data-menu="">
                                <a class="dropdown-item" href="{{ route('de.alreadyanswered.ontime') }}" data-toggle="">
                                    <span data-i18n="Invoice Template">Dans les délais</span>
                                </a>
                            </li>
                            <li data-menu="">
                                <a class="dropdown-item" href="{{ route('de.alreadyanswered.late') }}" data-toggle="">
                                    <span data-i18n="En retard">Hors délais</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li data-menu="">
                        <a class="dropdown-item" href="{{ route('de.repondre.supplementaire') }}" data-toggle="">
                            <i class="ft-file-text"></i>
                            <span data-i18n="News Feed">Inviter à répondre</span>
                        </a>
                    </li>
                    <li data-menu="">
                        <a class="dropdown-item" href="{{ route('de.underproposal') }}" data-toggle="">
                            <i class="ft-file-text"></i>
                            <span data-i18n="News Feed">En attente de proposition</span>
                        </a>
                    </li>
                    @if (auth()->user()->isAdmin() || auth()->user()->isRh() || auth()->user()->isDecideurSanction())
                        <li data-menu="">
                            <a class="dropdown-item" href="{{ route('de.underdecision') }}" data-toggle="">
                                <i class="ft-file-text"></i>
                                <span data-i18n="News Feed">En attente de décision</span>
                            </a>
                        </li>
                        <li data-menu="">
                            <a class="dropdown-item" href="{{ route('de.undernote') }}" data-toggle="">
                                <i class="ft-file-text"></i>
                                <span data-i18n="News Feed">En attente de note</span>
                            </a>
                        </li>
                    @endif
                    <li data-menu="">
                        <a class="dropdown-item" href="{{ route('de.archived') }}" data-toggle="">
                            <i class="ft-save"></i>
                            <span data-i18n="News Feed">Archivées</span>
                        </a>
                    </li>

                </ul>
            </li>
            @if (auth()->user()->isAdmin())
                <li class="nav-item {{ setMenuActive('users') }}">
                    <a class="nav-link" href="{{ route('users.index') }}">
                        <i class="icon-users"></i>
                        <span data-i18n="Templates">Utilisateurs</span>
                    </a>
                </li>
            @endif
            <li class="nav-item {{ setMenuActive('sanctions') }}">
                <a class="nav-link" href="{{ route('sanctions.history') }}">
                    <i class="ft-alert-triangle"></i>
                    <span data-i18n="Templates">Historique des sanctions</span>
                </a>
            </li>
            @if (auth()->user()->isAdmin() || auth()->user()->isRh())
                <li class="dropdown nav-item {{ setMenuActive('statistics') }}" data-menu="dropdown">
                    <a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">
                        <i class="ft-bar-chart-2"></i>
                        <span data-i18n="Pages">Statistiques</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li data-menu="">
                            <a class="dropdown-item {{ setMenuActive('statistics.rh') }}" href="{{ route('statistics.rh') }}" data-toggle="">
                                <i class="ft-layers"></i>
                                <span data-i18n="News Feed">
                                    Statistiques RH
                                </span>
                            </a>
                        </li>
                        <li data-menu="">
                            <a class="dropdown-item {{ setMenuActive('statistics.explanation_demand') }}" href="{{ route('statistics.explanation_demand') }}" data-toggle="">
                                <i class="ft-layers"></i>
                                <span data-i18n="News Feed">
                                    Demande d'explications
                                </span>
                            </a>
                        </li>
                        {{-- <li data-menu="">
                            <a class="dropdown-item" href="#" data-toggle="">
                                <i class="ft-plus-circle"></i>
                                <span data-i18n="News Feed">Gérer les grades</span>
                            </a>
                        </li> --}}
                    </ul>
                </li>

                <li class="dropdown nav-item {{ setMenuActive('motifs') }}" data-menu="dropdown">
                    <a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">
                        <i class="ft-more-horizontal"></i>
                        <span data-i18n="Pages">Autres</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li data-menu="">
                            <a class="dropdown-item" href="{{ route('users.import.get') }}" data-toggle="">
                                <i class="ft-plus-circle"></i>
                                <span data-i18n="News Feed">Importer les utilisateurs</span>
                            </a>
                        </li>
                        <li data-menu="">
                            <a class="dropdown-item" href="#" data-toggle="">
                                <i class="ft-plus-circle"></i>
                                <span data-i18n="News Feed">Gérer les grades</span>
                            </a>
                        </li>
                        <li data-menu="">
                            <a class="dropdown-item" href="{{ route('motifs.de.index') }}" data-toggle="">
                                <i class="ft-check-circle"></i>
                                <span data-i18n="News Feed">Motifs des DE</span>
                            </a>
                        </li>
                        <li data-menu="">
                            <a class="dropdown-item" href="{{ route('motifs.sanction.index') }}" data-toggle="">
                                <i class="ft-check-circle"></i>
                                <span data-i18n="News Feed">Motifs de sanction</span>
                            </a>
                        </li>
                        <li data-menu="">
                            <a class="dropdown-item" href="#" data-toggle="">
                                <i class="ft-save"></i>
                                <span data-i18n="News Feed">Gérer les entités</span>
                            </a>
                        </li>
                        <li data-menu="">
                            <a class="dropdown-item" href="{{ url('logs') }}" data-toggle="">
                                <i class="ft-save"></i>
                                <span data-i18n="News Feed">Journal des erreurs</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
        </ul>
    </div>
</div>
