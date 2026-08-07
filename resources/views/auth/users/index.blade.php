@extends('layouts.master')
@section('content')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Manrope:wght@500;700;800&display=swap" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Manrope:wght@500;700;800&display=swap"></noscript>
    <link rel="stylesheet" href="JS/accueil.css">

    {{-- ════ CAROUSEL ════ --}}
    <div class="car" id="car">
        <button class="arr ap" id="ap" aria-label="Précédent"><i class="fa fa-chevron-left"></i></button>
        <button class="arr an" id="an" aria-label="Suivant"><i class="fa fa-chevron-right"></i></button>
        <div class="ctr" id="ctr"><span>01</span> / 03</div>

        <div class="slides" id="sls">

            {{-- SLIDE 1 --}}
            <div class="sl on">
                <div class="sl-bg">
                    <img src="{{ asset('imgAccueil/slide1.jpg') }}" alt="Villa Cotonou"
                        fetchpriority="high"
                        onerror="this.src='https://images.unsplash.com/photo-1613490493576-7fde63acd811?w=1400&q=85'">
                </div>
                <div class="sl-ov"></div>
                <div class="sl-bar"></div>
                <span class="for-tag sale">À vendre</span>

                {{-- Desktop --}}
                <div class="c" style="position:relative;z-index:3;width:100%;display:flex;align-items:center;padding-top:0;padding-bottom:0;">
                    <div class="sl-txt dsk">
                        <div class="kicker a">Nouvelle annonce exclusive</div>
                        <div class="hero-q a">Vous cherchez<br>une&nbsp;<span class="spin" id="spin">villa de rêve</span>&nbsp;?</div>
                        <p class="hero-p a">Trouvez votre logement idéal parmi des centaines d'annonces vérifiées au Bénin.</p>
                        <div class="stats a">
                            <div class="gh-stat"><span class="sv">5</span><span class="sl-lbl">Chambres</span></div>
                            <div class="gh-stat"><span class="sv">3</span><span class="sl-lbl">Salles de bain</span></div>
                            <div class="gh-stat"><span class="sv">350 m²</span><span class="sl-lbl">Surface</span></div>
                        </div>
                        <div class="btns a">
                            <a href="{{ route('annonce.all') }}" class="bg"><i class="fa fa-search"></i> Parcourir les biens</a>
                            <div class="tip">
                                <a href="{{ route('appartement') }}" class="bgh"><span class="pio"><i class="fa fa-plus"></i></span> Publier un bien</a>
                                <span class="tip-box"><div class="tip-t">Donnez de la visibilité</div>Publiez et trouvez rapidement locataires ou acheteurs sérieux.</span>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Mobile --}}
                <div class="sl-txt mob">
                    <div class="kicker a">Nouvelle annonce exclusive</div>
                    <div class="hero-q a">Vous cherchez une&nbsp;<span class="spin">villa de rêve</span>&nbsp;?</div>
                    <p class="hero-p a">Trouvez votre logement idéal au Bénin.</p>
                    <div class="stats a">
                        <div class="gh-stat"><span class="sv">5</span><span class="sl-lbl">Chambres</span></div>
                        <div class="gh-stat"><span class="sv">3</span><span class="sl-lbl">Salles de bain</span></div>
                        <div class="gh-stat"><span class="sv">350 m²</span><span class="sl-lbl">Surface</span></div>
                    </div>
                    <div class="btns a">
                        <a href="{{ route('annonce.all') }}" class="bg"><i class="fa fa-search"></i> Parcourir les biens</a>
                        <a href="{{ route('appartement') }}" class="bgh"><span class="pio"><i class="fa fa-plus"></i></span> Publier un bien</a>
                    </div>
                </div>
                
            </div>

            {{-- SLIDE 2 --}}
            <div class="sl">
                <div class="sl-bg">
                    <img src="{{ asset('imgAccueil/slide2.jpg') }}" alt="Appartement Akpakpa"
                        loading="lazy"
                        onerror="this.src='https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?w=1400&q=85'">
                </div>
                <div class="sl-ov"></div>
                <div class="sl-bar"></div>
                <span class="for-tag rent">À louer</span>
                <div class="c" style="position:relative;z-index:3;width:100%;display:flex;align-items:center;padding-top:0;padding-bottom:0;">
                    <div class="sl-txt dsk">
                        <div class="kicker a">Appartement moderne</div>
                        <div class="hero-q a">Vous cherchez<br>une&nbsp;<span class="spin">villa de rêve</span>&nbsp;?</div>
                        <p class="hero-p a">Location ou achat, notre plateforme vous connecte aux meilleures offres au Bénin.</p>
                        <div class="stats a">
                            <div class="gh-stat"><span class="sv">3</span><span class="sl-lbl">Chambres</span></div>
                            <div class="gh-stat"><span class="sv">2</span><span class="sl-lbl">Salles de bain</span></div>
                            <div class="gh-stat"><span class="sv">120 m²</span><span class="sl-lbl">Surface</span></div>
                        </div>
                        <div class="btns a">
                            <a href="{{ route('annonce.all') }}" class="bg"><i class="fa fa-search"></i> Parcourir les biens</a>
                            <div class="tip">
                                <a href="{{ route('appartement') }}" class="bgh"><span class="pio"><i class="fa fa-plus"></i></span> Publier un bien</a>
                                <span class="tip-box"><div class="tip-t">Donnez de la visibilité</div>Publiez et trouvez rapidement locataires ou acheteurs sérieux.</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sl-txt mob">
                    <div class="kicker a">Appartement moderne</div>
                    <div class="hero-q a">Vous cherchez une&nbsp;<span class="spin">villa de rêve</span>&nbsp;?</div>
                    <p class="hero-p a">Location ou achat, trouvez vos meilleures offres au Bénin.</p>
                    <div class="stats a">
                        <div class="gh-stat"><span class="sv">3</span><span class="sl-lbl">Chambres</span></div>
                        <div class="gh-stat"><span class="sv">2</span><span class="sl-lbl">Salles de bain</span></div>
                        <div class="gh-stat"><span class="sv">120 m²</span><span class="sl-lbl">Surface</span></div>
                    </div>
                    <div class="btns a">
                        <a href="{{ route('annonce.all') }}" class="bg"><i class="fa fa-search"></i> Parcourir les biens</a>
                        <a href="{{ route('appartement') }}" class="bgh"><span class="pio"><i class="fa fa-plus"></i></span> Publier un bien</a>
                    </div>
                </div>
                
            </div>

            {{-- SLIDE 3 --}}
            <div class="sl">
                <div class="sl-bg">
                    <img src="{{ asset('imgAccueil/slide3.jpg') }}" alt="Maison Calavi"
                        loading="lazy"
                        onerror="this.src='https://images.unsplash.com/photo-1564013799919-ab600027ffc6?w=1400&q=85'">
                </div>
                <div class="sl-ov"></div>
                <div class="sl-bar"></div>
                <span class="for-tag sale">À vendre</span>
                <div class="c" style="position:relative;z-index:3;width:100%;display:flex;align-items:center;padding-top:0;padding-bottom:0;">
                    <div class="sl-txt dsk">
                        <div class="kicker a">Opportunité investissement</div>
                        <div class="hero-q a">Vous cherchez<br>une&nbsp;<span class="spin">villa de rêve</span>&nbsp;?</div>
                        <p class="hero-p a">Des biens de qualité pour chaque budget — Cotonou, Calavi, Abomey et partout au Bénin.</p>
                        <div class="stats a">
                            <div class="gh-stat"><span class="sv">4</span><span class="sl-lbl">Chambres</span></div>
                            <div class="gh-stat"><span class="sv">2</span><span class="sl-lbl">Salles de bain</span></div>
                            <div class="gh-stat"><span class="sv">200 m²</span><span class="sl-lbl">Surface</span></div>
                        </div>
                        <div class="btns a">
                            <a href="{{ route('annonce.all') }}" class="bg"><i class="fa fa-search"></i> Parcourir les biens</a>
                            <div class="tip">
                                <a href="{{ route('appartement') }}" class="bgh"><span class="pio"><i class="fa fa-plus"></i></span> Publier un bien</a>
                                <span class="tip-box"><div class="tip-t">Donnez de la visibilité</div>Publiez et trouvez rapidement locataires ou acheteurs sérieux.</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sl-txt mob">
                    <div class="kicker a">Opportunité investissement</div>
                    <div class="hero-q a">Vous cherchez une&nbsp;<span class="spin">villa de rêve</span>&nbsp;?</div>
                    <p class="hero-p a">Qualité pour chaque budget — partout au Bénin.</p>
                    <div class="stats a">
                        <div class="gh-stat"><span class="sv">4</span><span class="sl-lbl">Chambres</span></div>
                        <div class="gh-stat"><span class="sv">2</span><span class="sl-lbl">Salles de bain</span></div>
                        <div class="gh-stat"><span class="sv">200 m²</span><span class="sl-lbl">Surface</span></div>
                    </div>
                    <div class="btns a">
                        <a href="{{ route('annonce.all') }}" class="bg"><i class="fa fa-search"></i> Parcourir les biens</a>
                        <a href="{{ route('appartement') }}" class="bgh"><span class="pio"><i class="fa fa-plus"></i></span> Publier un bien</a>
                    </div>
                </div>
            </div>

        </div>

        <div class="dots" id="dots">
            <div class="dot on" data-i="0"></div>
            <div class="dot" data-i="1"></div>
            <div class="dot" data-i="2"></div>
        </div>
        <div class="prg" id="prg"></div>
    </div>

    {{-- ════ SEARCH BAR ════ --}}
    <div class="sch-sec">
        <div class="sch-bar">
            <div class="c">
                <form action="{{ route('search.appartement') }}" method="GET" id="sf">
                    <div class="sch-grid">
                        <div class="sf">
                            <div class="sf-l"><i class="fa fa-map-marker"></i> Quartier</div>
                            <div class="qac">
                                <input type="text" id="qi" name="quartier" value="{{ request('quartier') }}"
                                    placeholder="Entrer un quartier" autocomplete="off"
                                    style="border:none;background:transparent;font-size:13px;font-weight:500;color:var(--mu);outline:none;width:100%;font-family:inherit;">
                                <ul class="qac-ul" id="qs"></ul>
                            </div>
                        </div>
                        <div class="sf">
                            <div class="sf-l"><i class="fa fa-home"></i> Type de bien</div>
                            <select name="type" style="border:none;background:transparent;font-size:13px;font-weight:500;color:var(--mu);outline:none;width:100%;font-family:inherit;-webkit-appearance:none;appearance:none;cursor:pointer;">
                                <option value="">Tous les types</option>
                                <option value="Maison"      {{ request('type')=='Maison'      ?'selected':'' }}>Maison</option>
                                <option value="Appartement" {{ request('type')=='Appartement' ?'selected':'' }}>Appartement</option>
                                <option value="Bureaux"     {{ request('type')=='Bureaux'     ?'selected':'' }}>Bureau</option>
                                <option value="Boutique"    {{ request('type')=='Boutique'    ?'selected':'' }}>Boutique</option>
                                <option value="Terrain"     {{ request('type')=='Terrain'     ?'selected':'' }}>Terrain</option>
                            </select>
                        </div>
                        <div class="sf">
                            <div class="sf-l"><i class="fa fa-tag"></i> Catégorie</div>
                            <select name="categorie" style="border:none;background:transparent;font-size:13px;font-weight:500;color:var(--mu);outline:none;width:100%;font-family:inherit;-webkit-appearance:none;appearance:none;cursor:pointer;">
                                <option value="">Location / Vente</option>
                                <option value="louer"  {{ request('categorie')=='louer'  ?'selected':'' }}>À louer</option>
                                <option value="vendre" {{ request('categorie')=='vendre' ?'selected':'' }}>À vendre</option>
                            </select>
                        </div>
                        <div class="sf">
                            <div class="sf-l"><i class="fa fa-money"></i> Prix minimum</div>
                            <input type="number" name="prix_min" value="{{ request('prix_min') }}" placeholder="Min FCFA"
                                style="border:none;background:transparent;font-size:13px;font-weight:500;color:var(--mu);outline:none;width:100%;font-family:inherit;">
                        </div>
                        <div class="sf">
                            <div class="sf-l"><i class="fa fa-money"></i> Prix maximum</div>
                            <input type="number" name="prix_max" value="{{ request('prix_max') }}" placeholder="Max FCFA"
                                style="border:none;background:transparent;font-size:13px;font-weight:500;color:var(--mu);outline:none;width:100%;font-family:inherit;">
                        </div>
                        <button type="submit" class="btn-sch" id="bs">
                            <i class="fa fa-search"></i>
                            <span id="bt">Rechercher</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ════ ANNONCES EN VEDETTE ════ --}}
    <section class="props">
        <div class="c">
            <div class="sec-bar">
                <div class="sec-t">Propriétés en vedette</div>
                @if(isset($appartements) && $appartements->count() > 0)
                <a href="{{ route('annonce.all') }}" class="va">Voir toutes <i class="fa fa-arrow-right"></i></a>
                @endif
            </div>
            <div class="pg">
                @forelse($appartements as $i => $app)
                @php
                    $images   = explode('|', $app->images ?? '');
                    $img      = !empty($images[0]) ? URL::to($images[0]) : asset('images/no-image.jpg');
                    $prix     = number_format($app->prix ?? 0, 0, ',', ' ');
                    $isLouer  = $app->categorie == 'louer';
                    $chambres = $app->nombreChambre ?? 0;
                    $salles   = $app->nombreSalleBain ?? 0;
                    $surface  = $app->surface ?? null;
                    $pieces   = $app->nombrePieces ?? 0;
                @endphp
                <div class="pc" style="animation:ci .38s ease {{ $i * 55 }}ms both;">
                    <a href="{{ route('appartement.detail', $app->id) }}" class="pc-lnk">
                        <div class="pc-img">
                            <img src="{{ $img }}" alt="{{ $app->quartier }}" loading="{{ $i < 5 ? 'eager' : 'lazy' }}">
                            <span class="badge {{ $isLouer ? 'br' : 'bs' }}">{{ $isLouer ? 'À louer' : 'À vendre' }}</span>
                            <button class="fav" type="button" onclick="event.preventDefault();fv(this)"><i class="fa fa-heart-o"></i></button>
                        </div>
                        <div class="pc-body">
                            <div class="pc-price">{{ $prix }} <small>FCFA{{ $isLouer ? '/mois' : '' }}</small></div>
                            <div class="pc-tit">{{ $app->type ?? '' }} — {{ Str::limit($app->quartier ?? '—', 22) }}</div>
                            <div class="pc-adr"><i class="fa fa-map-marker"></i>{{ $app->commune ?? '' }}{{ ($app->commune && $app->departement) ? ', ' : '' }}{{ $app->departement ?? '' }}</div>
                        </div>
                    </a>
                    <div class="pc-ft">
                        @if($chambres > 0)<div class=""><i class="fa fa-bed"></i><span>{{ $chambres }} ch.</span></div>@endif
                        @if($salles > 0)<div class=""><i class="fa fa-bath"></i><span>{{ $salles }} sdb</span></div>@endif
                        @if($surface)<div class=""><i class="fa fa-arrows-alt"></i><span>{{ $surface }} m²</span></div>
                        @elseif($pieces > 0)<div class=""><i class="fa fa-th-large"></i><span>{{ $pieces }} p.</span></div>@endif
                        <a href="tel:{{ $app->entreprise->telephone ?? '' }}"
                        style="margin-left:auto;background:var(--gr-lt);color:var(--gr-dk);padding:3px 9px;border-radius:5px;font-weight:700;font-size:10.5px;display:inline-flex;align-items:center;gap:4px;"
                        onclick="event.stopPropagation()"><i class="fa fa-phone"></i> Appeler</a>
                    </div>
                </div>
                @empty
                <div class="empty">
                    <div class="e-ico"><i class="fa fa-home"></i></div>
                    <div class="e-t">Aucun bien disponible</div>
                    <p class="e-p">Soyez le premier à publier une annonce !</p>
                    <a href="{{ route('appartement') }}" class="e-btn"><i class="fa fa-plus"></i> Publier</a>
                </div>
                @endforelse
            </div>
            @if(isset($appartements) && $appartements->count() > 0)
            <div class="vp"><a href="{{ route('annonce.all') }}" class="vp-btn">Voir toutes les annonces <i class="fa fa-arrow-right"></i></a></div>
            @endif
        </div>
    </section>

    {{-- ════ FAQ ════ --}}
    
<section class="faq-s">
    <div class="c">
        <div class="faq-in">
 
            {{-- IMAGE COLONNE GAUCHE --}}
            <div class="faq-iw">
                <img src="/faq.jpg" alt="FAQ LOCIMMO" loading="lazy"
                    onerror="this.src='https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=700&q=80'">
                <div class="faq-bd">
                    <div class="fbico"><i class="fa fa-star"></i></div>
                    <div>
                        <div class="fbv">4.9/5</div>
                        <div class="fbl">Satisfaction clients</div>
                    </div>
                </div>
            </div>
 
            {{-- CONTENU COLONNE DROITE --}}
            <div class="faq-right">
                <div class="fq-kk">Foire Aux Questions (FAQ)</div>
                <div class="fq-h">Bienvenue sur la FAQ de LOCIMMO.COM ! Cette section est conçue pour répondre à vos questions les plus fréquentes concernant le fonctionnement de notre plateforme de mise en relation immobilière.</div>
 
                @php
                $faqData = [
                    [
                        'num'   => '01',
                        'titre' => 'À Propos de LOCIMMO.COM',
                        'icon'  => 'fa-info-circle',
                        'items' => [
                            [
                                'q' => "Qu'est-ce que LOCIMMO.COM ?",
                                'r' => "LOCIMMO.COM est une plateforme numérique dédiée à la mise en relation entre les propriétaires de biens immobiliers (ou leurs mandataires) et le public (acheteurs et locataires). Notre objectif est de faciliter la recherche et la publication d'annonces immobilières pour divers types de biens, tels que les appartements (meublés ou non), les boutiques, les locaux commerciaux, et les terrains bâtir et à bâtir, que ce soit pour la location ou la vente.",
                            ],
                            [
                                'q' => "LOCIMMO.COM est-il un professionnel de l'immobilier ou une agence ?",
                                'r' => "Non, LOCIMMO.COM n'est pas une agence immobilière, un agent immobilier, ni un professionnel de l'immobilier. Nous agissons exclusivement en tant qu'intermédiaire technique, fournissant une plateforme pour que les propriétaires et les mandataires puissent publier leurs annonces et que le public puisse les consulter. Nous ne participons pas directement aux transactions immobilières et n'offrons pas de services de conseil, de courtage ou de gestion immobilière.",
                            ],
                        ],
                    ],
                    [
                        'num'   => '02',
                        'titre' => 'Responsabilités et Clauses de Non-Responsabilité',
                        'icon'  => 'fa-shield',
                        'items' => [
                            [
                                'q' => "Quelle est la responsabilité de LOCIMMO.COM dans les transactions immobilières ?",
                                'r' => "Étant une plateforme de mise en relation, LOCIMMO.COM ne peut être tenu responsable des vices cachés, de l'état des biens immobiliers, de la conformité des documents, ou de tout autre aspect lié directement à la location ou à la vente. Les transactions se déroulent directement entre l'annonceur et le public. Il est de la responsabilité de chaque partie de vérifier toutes les informations, l'état du bien et la légalité de la transaction.",
                            ],
                            [
                                'q' => "Comment sont gérés les litiges entre utilisateurs ?",
                                'r' => "Tout litige survenant entre un annonceur et un acheteur/locataire doit être résolu directement entre les parties concernées. LOCIMMO.COM n'intervient pas dans la résolution de ces litiges.",
                            ],
                            [
                                'q' => "Quelles précautions dois-je prendre avant de m'engager ?",
                                'r' => "Nous recommandons fortement : de visiter le bien avant toute signature ou versement d'argent ; de vérifier l'identité de votre interlocuteur et son droit à agir (titre de propriété, mandat) ; d'examiner attentivement tous les documents (contrat, compromis, diagnostics) et de consulter un notaire ou avocat si nécessaire ; de ne jamais verser d'argent avant d'avoir visité le bien et vérifié la légitimité de l'annonceur.",
                            ],
                        ],
                    ],
                    [
                        'num'   => '03',
                        'titre' => 'Utilisation du Site pour le Public (Acheteurs & Locataires)',
                        'icon'  => 'fa-users',
                        'items' => [
                            [
                                'q' => "L'accès au site et la recherche de biens sont-ils payants ?",
                                'r' => "Non, l'accès à LOCIMMO.COM, la consultation des annonces et la recherche de biens immobiliers sont entièrement gratuits pour le public. Vous pouvez naviguer librement, consulter toutes les annonces disponibles et contacter les annonceurs sans aucun frais.",
                            ],
                            [
                                'q' => "Quels types de biens puis-je trouver sur le site ?",
                                'r' => "Notre plateforme propose une large gamme de biens pour la location et la vente : appartements meublés et non meublés, boutiques et locaux commerciaux, terrains bâtis et à bâtir.",
                            ],
                            [
                                'q' => "Comment contacter un propriétaire ou un mandataire ?",
                                'r' => "Sur chaque fiche de bien, vous trouverez un bouton « Détail ». Il vous suffit de cliquer dessus pour accéder à toutes les informations concernant l'annonce. Depuis cette page, vous pouvez contacter directement le responsable de l'annonce en l'appelant, lui envoyer un message via le formulaire sécurisé intégré à notre plateforme ou échanger avec lui via WhatsApp.",
                            ],
                            [
                                'q' => "Comment filtrer mes recherches pour trouver le bien idéal ?",
                                'r' => "Notre moteur de recherche avancé vous permet d'affiner vos résultats selon : le type de bien (appartement, terrain, boutique), la catégorie (meublé/non meublé), la transaction (location/vente), la localisation géographique, la surface, le nombre de pièces, et bien d'autres critères.",
                            ],
                            [
                                'q' => "Puis-je sauvegarder des annonces en favoris ?",
                                'r' => "Oui, en créant un compte utilisateur gratuit, vous avez la possibilité d'enregistrer vos annonces préférées dans une liste de favoris pour les retrouver facilement et suivre leur évolution.",
                            ],
                        ],
                    ],
                    [
                        'num'   => '04',
                        'titre' => 'Utilisation du Site pour les Annonceurs (Propriétaires & Mandataires)',
                        'icon'  => 'fa-bullhorn',
                        'items' => [
                            [
                                'q' => "Qui peut publier une annonce sur LOCIMMO.COM ?",
                                'r' => "La publication est ouverte aux propriétaires de biens immobiliers ainsi qu'aux personnes ayant reçu un mandat formel (délégation de pouvoir, procuration, mandat de gestion) pour agir en leur nom. Cela inclut les agents immobiliers, les gestionnaires de biens, ou toute personne dûment autorisée à représenter le propriétaire.",
                            ],
                            [
                                'q' => "Est-il gratuit de publier une annonce ?",
                                'r' => "Non, la publication d'annonces sur LOCIMMO.COM est un service payant. Ce modèle nous permet de maintenir la qualité de notre plateforme et d'assurer une visibilité optimale à vos annonces. Les frais contribuent également à la modération et à l'amélioration continue de nos services.",
                            ],
                            [
                                'q' => "Où puis-je consulter les tarifs de publication ?",
                                'r' => "Vous pouvez retrouver le détail complet de nos offres, nos différentes formules de publication et nos options de visibilité (boost d'annonces, mise en avant) en consultant notre grille tarifaire disponible sur le site.",
                            ],
                            [
                                'q' => "Je suis mandataire, puis-je gérer plusieurs annonces pour différents propriétaires ?",
                                'r' => "Oui, notre interface est conçue pour vous permettre de gérer efficacement un portefeuille de biens. Vous pouvez créer et administrer plusieurs annonces simultanément, même si elles proviennent de différents propriétaires que vous représentez.",
                            ],
                            [
                                'q' => "Comment rendre mon annonce plus attractive ?",
                                'r' => "Pour maximiser l'attractivité de votre annonce : incluez des photos de haute qualité et récentes ; rédigez une description détaillée mentionnant la surface, le nombre de pièces, les équipements, la localisation exacte et les commodités à proximité ; répondez rapidement et professionnellement aux demandes de contact.",
                            ],
                            [
                                'q' => "Quelles sont mes responsabilités en tant qu'annonceur ?",
                                'r' => "En tant qu'annonceur, vous vous engagez à : fournir des informations exactes, complètes et à jour ; disposer des droits de propriété ou des mandats nécessaires ; respecter la législation en vigueur sur les annonces immobilières ; retirer votre annonce dès que le bien n'est plus disponible.",
                            ],
                        ],
                    ],
                    [
                        'num'   => '05',
                        'titre' => 'Sécurité et Bonnes Pratiques',
                        'icon'  => 'fa-lock',
                        'items' => [
                            [
                                'q' => "Comment puis-je me protéger des arnaques ?",
                                'r' => "La prudence est de mise sur toutes les plateformes en ligne. Méfiez-vous des offres trop alléchantes ou des prix anormalement bas. Ne communiquez jamais d'informations personnelles sensibles (coordonnées bancaires, mots de passe) à des inconnus. N'envoyez jamais d'argent via Western Union, MoneyGram ou recharges PCS à une personne non vérifiée. Privilégiez les échanges directs et les visites physiques. Signalez toute annonce suspecte à notre équipe de modération.",
                            ],
                        ],
                    ],
                ];
                @endphp
 
                <div class="fq-list">
                    @foreach($faqData as $gi => $groupe)
                    <div class="fq-group">
 
                        {{-- ── GRAND TITRE ── --}}
                        <button type="button" class="fq-gtitle" aria-expanded="false">
                            <div class="fq-gnum">{{ $groupe['num'] }}</div>
                            <div class="fq-gico"><i class="fa {{ $groupe['icon'] }}"></i></div>
                            <span>{{ $groupe['titre'] }}</span>
                            <span class="fq-arrow"><i class="fa-solid fa-chevron-down"></i></span>
                        </button>
 
                        {{-- ── SOUS-QUESTIONS ── --}}
                        <div class="fq-sublist">
                            @foreach($groupe['items'] as $si => $item)
                            <div class="fq-item">
                                <button type="button" class="fq-q" aria-expanded="false">
                                    <span class="fq-n">{{ $groupe['num'] }}.{{ $si + 1 }}</span>
                                    <span class="fq-tx">{{ $item['q'] }}</span>
                                    <span class="fq-ic"><i class="fa fa-plus"></i></span>
                                </button>
                                <div class="fq-a" aria-hidden="true">{{ $item['r'] }}</div>
                            </div>
                            @endforeach
                        </div>
 
                    </div>
                    @endforeach
                </div>{{-- /.fq-list --}}
 
            </div>{{-- /.faq-right --}}
        </div>{{-- /.faq-in --}}
    </div>{{-- /.c --}}
</section>
 
    {{-- ════ NEWSLETTER ════ --}}
    <section class="nl">
        <div class="c">
            <div class="nl-in">
                <div class="nl-body">
                    <div class="nl-t">Restez informé des nouvelles offres</div>
                    <p class="nl-s">Recevez les meilleures annonces directement dans votre boîte mail.</p>
                </div>
                <form action="{{ route('newsletter') }}" method="POST" class="nl-form">
                    @csrf
                    <div class="nl-iw"><i class="fa fa-envelope"></i><input type="email" name="email" class="nl-inp" placeholder="votre@email.com" required></div>
                    <button type="submit" class="nl-btn">S'inscrire</button>
                </form>
            </div>
        </div>
    </section>

    {{-- Script minimal en fin de page --}}
    <script src="JS/accueil.js"></script>
    
@endsection