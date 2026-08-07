@extends('layouts.master')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<style>
*, *::before, *::after { box-sizing: border-box; }

:root {
    --ink:      #111827;
    --ink2:     #374151;
    --ink3:     #6B7280;
    --ink4:     #9CA3AF;
    --border:   #E5E7EB;
    --border2:  #F3F4F6;
    --bg:       #F9FAFB;
    --white:    #FFFFFF;
    --accent:   #FF385C;
    --accent2:  #E31C5F;
    --green:    #059669;
    --green-lt: #ECFDF5;
    --green-bd: #A7F3D0;
    --red:      #DC2626;
    --red-lt:   #FEF2F2;
    --red-bd:   #FECACA;
    --blue:     #2563EB;
    --blue-lt:  #EFF6FF;
    --blue-bd:  #BFDBFE;
    --amber:    #D97706;
    --amber-lt: #FFFBEB;
    --amber-bd: #FDE68A;
    --r:        12px;
    --r-lg:     16px;
    --r-xl:     20px;
    --sh:       0 1px 2px rgba(0,0,0,.06), 0 4px 12px rgba(0,0,0,.05);
    --sh-lg:    0 2px 4px rgba(0,0,0,.06), 0 8px 24px rgba(0,0,0,.09);
}

.ent-wrap {
    font-family: 'Outfit', sans-serif;
    background: var(--bg);
    min-height: 100vh;
    padding: 32px 0 80px;
    color: var(--ink);
    -webkit-font-smoothing: antialiased;
}
.ent-wrap .container { max-width: 1200px; }

/* ════ HEADER PAGE ════ */
.page-hd {
    display: flex; align-items: flex-start;
    justify-content: space-between; flex-wrap: wrap;
    gap: 16px; margin-bottom: 28px;
}
.page-hd-left h1 {
    font-size: 26px; font-weight: 800; color: var(--ink);
    margin: 0 0 4px; letter-spacing: -.03em;
}
.page-hd-left p { font-size: 14px; color: var(--ink3); margin: 0; font-weight: 400; }

/* ════ KPI GRID ════ */
.kpi-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px; margin-bottom: 28px;
}
.kpi-card {
    background: var(--white); border: 1.5px solid var(--border);
    border-radius: var(--r-xl); padding: 20px 22px;
    box-shadow: var(--sh); transition: all .2s;
    display: flex; align-items: center; gap: 16px;
}
.kpi-card:hover { transform: translateY(-3px); box-shadow: var(--sh-lg); border-color: var(--ink3); }
.kpi-ico {
    width: 48px; height: 48px; border-radius: var(--r-lg);
    display: flex; align-items: center; justify-content: center;
    font-size: 20px; flex-shrink: 0;
}
.kpi-ico.total  { background: var(--blue-lt);  color: var(--blue); }
.kpi-ico.active { background: var(--green-lt); color: var(--green); }
.kpi-ico.inact  { background: var(--red-lt);   color: var(--red); }
.kpi-ico.new    { background: var(--amber-lt); color: var(--amber); }
.kpi-val { font-size: 28px; font-weight: 800; color: var(--ink); line-height: 1; letter-spacing: -.04em; }
.kpi-lbl { font-size: 12px; color: var(--ink3); font-weight: 500; margin-top: 3px; text-transform: uppercase; letter-spacing: .05em; }

/* ════ MAIN CARD ════ */
.main-card {
    background: var(--white); border: 1.5px solid var(--border);
    border-radius: var(--r-xl); box-shadow: var(--sh); overflow: hidden;
}

/* ════ TOOLBAR ════ */
.card-toolbar {
    padding: 18px 24px; border-bottom: 1px solid var(--border);
    display: flex; align-items: center; justify-content: space-between;
    flex-wrap: wrap; gap: 12px; background: var(--white);
}
.toolbar-left { display: flex; align-items: center; gap: 10px; }
.toolbar-title {
    font-size: 15px; font-weight: 700; color: var(--ink);
    display: flex; align-items: center; gap: 8px;
}
.toolbar-badge {
    background: var(--ink); color: var(--white);
    padding: 2px 10px; border-radius: 30px;
    font-size: 11px; font-weight: 700;
}
.toolbar-search {
    display: flex; align-items: center; gap: 8px;
    background: var(--bg); border: 1.5px solid var(--border);
    border-radius: var(--r); padding: 8px 14px;
    transition: all .18s;
}
.toolbar-search:focus-within {
    border-color: var(--ink); background: var(--white);
    box-shadow: 0 0 0 3px rgba(17,24,39,.06);
}
.toolbar-search i { color: var(--ink4); font-size: 13px; }
.toolbar-search input {
    border: none; background: transparent; outline: none;
    font-size: 13.5px; font-family: 'Outfit', sans-serif;
    color: var(--ink); width: 200px;
}
.toolbar-search input::placeholder { color: var(--ink4); }

/* ════ TABLE ════ */
.ent-table { width: 100%; border-collapse: collapse; }
.ent-table th {
    padding: 11px 20px; font-size: 10.5px; font-weight: 700;
    text-transform: uppercase; letter-spacing: .07em;
    color: var(--ink3); background: var(--bg);
    border-bottom: 1px solid var(--border);
    white-space: nowrap; text-align: left;
}
.ent-table td {
    padding: 14px 20px; vertical-align: middle;
    border-bottom: 1px solid var(--border2);
    font-size: 14px; color: var(--ink2);
}
.ent-table tbody tr { transition: background .12s; }
.ent-table tbody tr:last-child td { border-bottom: none; }
.ent-table tbody tr:hover td { background: var(--bg); }

/* Cellule agent */
.agent-cell { display: flex; align-items: center; gap: 12px; }
.agent-av {
    width: 40px; height: 40px; border-radius: 50%;
    background: linear-gradient(135deg, var(--accent), var(--accent2));
    display: flex; align-items: center; justify-content: center;
    font-size: 14px; font-weight: 700; color: #fff;
    flex-shrink: 0; letter-spacing: .01em;
}
.agent-name  { font-size: 14px; font-weight: 600; color: var(--ink); display: block; }
.agent-email { font-size: 12px; color: var(--ink4); display: block; margin-top: 1px; }

/* Localisation */
.loc-val { font-size: 13.5px; font-weight: 500; color: var(--ink2); }
.loc-arr  { font-size: 11px; color: var(--ink4); display: block; margin-top: 1px; }

/* Téléphone */
.tel-val { display: inline-flex; align-items: center; gap: 6px; font-size: 13.5px; font-weight: 500; }
.tel-val i { color: var(--ink4); font-size: 11px; }

/* Date */
.date-main { font-size: 13px; font-weight: 600; color: var(--ink2); display: block; }
.date-rel  { font-size: 11px; color: var(--ink4); display: block; margin-top: 2px; }

/* Status badge */
.status-badge {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 4px 10px; border-radius: 30px;
    font-size: 11.5px; font-weight: 700;
}
.sb-active { background: var(--green-lt); color: var(--green); border: 1px solid var(--green-bd); }
.sb-inact  { background: var(--red-lt);   color: var(--red);   border: 1px solid var(--red-bd); }
.sb-dot    { width: 6px; height: 6px; border-radius: 50%; background: currentColor; flex-shrink: 0; }

/* Actions */
.act-group { display: inline-flex; align-items: center; gap: 4px; }
.act-btn {
    width: 32px; height: 32px; border-radius: 8px; border: 1.5px solid var(--border);
    background: var(--white); display: inline-flex; align-items: center; justify-content: center;
    font-size: 12px; cursor: pointer; transition: all .15s; text-decoration: none;
    color: var(--ink3); font-family: 'Outfit', sans-serif;
}
.act-btn:hover { transform: translateY(-1px); }
.act-btn.view:hover    { background: var(--blue-lt);  color: var(--blue);  border-color: var(--blue-bd); }
.act-btn.toggle-off:hover { background: var(--red-lt);  color: var(--red);   border-color: var(--red-bd); }
.act-btn.toggle-on:hover  { background: var(--green-lt); color: var(--green); border-color: var(--green-bd); }

/* ════ ALERTE ════ */
.ent-alert {
    display: flex; align-items: center; gap: 10px;
    padding: 12px 16px; border-radius: var(--r);
    font-size: 13.5px; font-weight: 600; margin-bottom: 20px;
    border: 1px solid var(--green-bd); background: var(--green-lt);
    color: var(--green);
    animation: slideDown .3s ease both;
}
@keyframes slideDown {
    from { opacity: 0; transform: translateY(-8px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ════ EMPTY ════ */
.ent-empty {
    text-align: center; padding: 60px 24px; color: var(--ink4);
}
.ent-empty-ring {
    width: 72px; height: 72px; border-radius: 50%;
    background: var(--bg); border: 2px solid var(--border);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 16px; font-size: 26px; color: var(--ink4);
}
.ent-empty h3 { font-size: 16px; font-weight: 700; color: var(--ink2); margin: 0 0 6px; }
.ent-empty p  { font-size: 14px; color: var(--ink4); margin: 0; }

/* ════ PAGINATION ════ */
.card-footer {
    padding: 14px 24px; border-top: 1px solid var(--border);
    background: var(--bg); display: flex; align-items: center;
    justify-content: space-between; flex-wrap: wrap; gap: 10px;
}
.footer-info { font-size: 13px; color: var(--ink3); font-weight: 500; }

/* ════ RESPONSIVE ════ */
@media (max-width: 992px) { .kpi-grid { grid-template-columns: 1fr 1fr; } }
@media (max-width: 640px) {
    .kpi-grid { grid-template-columns: 1fr 1fr; }
    .toolbar-search { display: none; }
    .ent-table th:nth-child(4), .ent-table td:nth-child(4) { display: none; }
}
</style>


<div class="ent-wrap">
<div class="container">

    {{-- ════ HEADER ════ --}}
    <div class="page-hd">
        <div class="page-hd-left">
            <h1>Gestion des proprietaires</h1>
            <p>Tous les propriétaires inscrits sur la plateforme</p>
        </div>
    </div>

    {{-- ════ KPI ════ --}}
    @php
        $totalItems  = $entreprises->total();
        $actifs      = $entreprises->getCollection()->filter(fn($e) => $e->user->estActive)->count();
        $inactifs    = $entreprises->getCollection()->filter(fn($e) => !$e->user->estActive)->count();
        $nouveaux    = $entreprises->getCollection()->filter(fn($e) => $e->created_at->gte(now()->subDays(30)))->count();
    @endphp
    <div class="kpi-grid">
        <div class="kpi-card">
            <div class="kpi-ico total"><i class="fa fa-building"></i></div>
            <div>
                <div class="kpi-val">{{ $totalItems }}</div>
                <div class="kpi-lbl">Total proprietaire</div>
            </div>
        </div>
        <div class="kpi-card">
            <div class="kpi-ico active"><i class="fa fa-check-circle"></i></div>
            <div>
                <div class="kpi-val">{{ $actifs }}</div>
                <div class="kpi-lbl">Comptes actifs</div>
            </div>
        </div>
        <div class="kpi-card">
            <div class="kpi-ico inact"><i class="fa fa-ban"></i></div>
            <div>
                <div class="kpi-val">{{ $inactifs }}</div>
                <div class="kpi-lbl">Comptes inactifs</div>
            </div>
        </div>
        <div class="kpi-card">
            <div class="kpi-ico new"><i class="fa fa-star"></i></div>
            <div>
                <div class="kpi-val">{{ $nouveaux }}</div>
                <div class="kpi-lbl">Nouveaux (30j)</div>
            </div>
        </div>
    </div>

    {{-- ════ TABLE CARD ════ --}}
    <div class="main-card">

        {{-- Toolbar --}}
        <div class="card-toolbar">
            <div class="toolbar-left">
                <span class="toolbar-title">
                    <i class="fa fa-list" style="color:var(--ink3)"></i>
                    Liste des proprietaires
                    <span class="toolbar-badge">{{ $totalItems }}</span>
                </span>
            </div>
            <div class="toolbar-search">
                <i class="fa fa-search"></i>
                <input type="text" id="searchInput" placeholder="Rechercher un proprietaire...">
            </div>
        </div>

        {{-- Table --}}
        <div style="overflow-x:auto">
            <table class="ent-table" id="entTable">
                <thead>
                    <tr>
                        <th>Entreprise / Propriétaire</th>
                        <th>Localisation</th>
                        <th>Téléphone</th>
                        <th>Inscrit le</th>
                        <th>Statut</th>
                        <th style="text-align:right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($entreprises as $entreprise)
                    @php
                        $initials = strtoupper(substr($entreprise->nom ?? 'E', 0, 1) . substr($entreprise->prenom ?? '', 0, 1));
                        $isActive = $entreprise->user->estActive;
                    @endphp
                    <tr>
                        {{-- Entreprise --}}
                        <td>
                            <div class="agent-cell">
                                <div class="agent-av">{{ $initials }}</div>
                                <div>
                                    <span class="agent-name">{{ $entreprise->nom }} {{ $entreprise->prenom }}</span>
                                    <span class="agent-email">{{ $entreprise->user->email ?? '—' }}</span>
                                </div>
                            </div>
                        </td>

                        {{-- Localisation --}}
                        <td>
                            <span class="loc-val">{{ $entreprise->ville }}</span>
                            <span class="loc-arr">{{ $entreprise->quatier }}</span>
                        </td>

                        {{-- Téléphone --}}
                        <td>
                            <span class="tel-val">
                                <i class="fa fa-phone"></i>
                                {{ $entreprise->telephone }}
                            </span>
                        </td>

                        {{-- Date --}}
                        <td>
                            <span class="date-main">{{ $entreprise->created_at->format('d/m/Y') }}</span>
                            <span class="date-rel">{{ $entreprise->created_at->diffForHumans() }}</span>
                        </td>

                        {{-- Statut --}}
                        <td>
                            @if($isActive)
                                <span class="status-badge sb-active">
                                    <span class="sb-dot"></span> Actif
                                </span>
                            @else
                                <span class="status-badge sb-inact">
                                    <span class="sb-dot"></span> Inactif
                                </span>
                            @endif
                        </td>

                        {{-- Actions --}}
                        <td style="text-align:right">
                            <div class="act-group">

                                <a href="{{ route('entreprise.show', $entreprise->id) }}"
                                   class="act-btn view" title="Voir le détail">
                                    <i class="fa fa-eye"></i>
                                </a>

                                @if($isActive)
                                    <form action="{{ route('entreprise.desactiver', $entreprise->id) }}"
                                          method="post" style="display:contents">
                                        @csrf @method('PUT')
                                        <button type="submit" class="act-btn toggle-off" title="Désactiver">
                                            <i class="fa fa-ban"></i>
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('entreprise.activer', $entreprise->id) }}"
                                          method="post" style="display:contents">
                                        @csrf @method('PUT')
                                        <button type="submit" class="act-btn toggle-on" title="Activer">
                                            <i class="fa fa-check"></i>
                                        </button>
                                    </form>
                                @endif

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="ent-empty">
                                <div class="ent-empty-ring"><i class="fa fa-building-o"></i></div>
                                <h3>Aucune entreprise trouvée</h3>
                                <p>Les entreprises inscrites apparaîtront ici.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer pagination --}}
        <div class="card-footer">
            <span class="footer-info">
                Affichage {{ $entreprises->firstItem() ?? 0 }} – {{ $entreprises->lastItem() ?? 0 }}
                sur {{ $totalItems }} entreprise(s)
            </span>
            <div>{{ $entreprises->links() }}</div>
        </div>

    </div>

</div>
</div>

<script>
// Recherche live dans le tableau
document.getElementById('searchInput')?.addEventListener('input', function() {
    var q = this.value.toLowerCase();
    document.querySelectorAll('#entTable tbody tr').forEach(function(row) {
        row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
});
</script>

@endsection