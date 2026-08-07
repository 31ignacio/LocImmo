(function () {
    'use strict';

    /* ════════════════════════════════════════════════════════════
       1. TEXTE ROTATIF
    ════════════════════════════════════════════════════════════ */
    var WORDS = [
        'villa de rêve',
        'maison familiale',
        'terrain constructible',
        'appartement moderne',
        'chambre meublée',
        'bureau professionnel',
        'boutique commerciale',
        'logement idéal'
    ];

    var spinEls = document.querySelectorAll('.spin');

    if (spinEls.length) {
        var spinIdx = 0;

        /* Valeur initiale */
        spinEls.forEach(function (el) {
            el.textContent = WORDS[0];
        });

        /* Rotation toutes les 2.4 s */
        setInterval(function () {
            spinIdx = (spinIdx + 1) % WORDS.length;

            spinEls.forEach(function (el) {
                el.classList.add('out');

                setTimeout(function () {
                    el.textContent = WORDS[spinIdx];
                    el.classList.remove('out');
                }, 280);
            });
        }, 2400);
    }


    /* ════════════════════════════════════════════════════════════
       2. CAROUSEL HÉRO
    ════════════════════════════════════════════════════════════ */
    var car   = document.getElementById('car');
    var sls   = document.getElementById('sls');
    var bar   = document.getElementById('prg');
    var ctr   = document.getElementById('ctr');
    var apBtn = document.getElementById('ap');
    var anBtn = document.getElementById('an');

    if (car && sls) {
        var CAR_DUR  = 6000;
        var carIdx   = 0;
        var carTimer = null;
        var slides   = document.querySelectorAll('.sl');
        var dots     = document.querySelectorAll('.dot');
        var carTotal = slides.length;
        var NUMS     = Array.from({ length: carTotal }, function (_, i) {
            return String(i + 1).padStart(2, '0');
        });

        /* Mise à jour du compteur "01 / 03" */
        function updateCounter() {
            if (ctr) {
                ctr.innerHTML = '<span>' + NUMS[carIdx] + '</span> / ' + String(carTotal).padStart(2, '0');
            }
        }

        /* Barre de progression */
        function startBar() {
            if (!bar) return;
            bar.style.transition = 'none';
            bar.style.width      = '0%';
            /* Double rAF pour forcer le repaint avant la transition */
            requestAnimationFrame(function () {
                requestAnimationFrame(function () {
                    bar.style.transition = 'width ' + CAR_DUR + 'ms linear';
                    bar.style.width      = '100%';
                });
            });
        }

        /* Aller à la diapo n */
        function goTo(n) {
            /* Retire la classe active de la diapo et du dot courant */
            if (slides[carIdx]) slides[carIdx].classList.remove('on');
            if (dots[carIdx])   dots[carIdx].classList.remove('on');

            carIdx = ((n % carTotal) + carTotal) % carTotal;

            sls.style.transform = 'translateX(-' + (carIdx * 100) + '%)';

            if (slides[carIdx]) slides[carIdx].classList.add('on');
            if (dots[carIdx])   dots[carIdx].classList.add('on');

            updateCounter();
            tick();
        }

        /* Lance le timer auto + barre */
        function tick() {
            clearTimeout(carTimer);
            startBar();
            carTimer = setTimeout(function () { goTo(carIdx + 1); }, CAR_DUR);
        }

        /* Boutons précédent / suivant */
        if (apBtn) apBtn.addEventListener('click', function () { goTo(carIdx - 1); });
        if (anBtn) anBtn.addEventListener('click', function () { goTo(carIdx + 1); });

        /* Dots */
        dots.forEach(function (dot) {
            dot.addEventListener('click', function () {
                goTo(parseInt(dot.dataset.i, 10));
            });
        });

        /* Swipe tactile */
        var touchStartX = 0;
        car.addEventListener('touchstart', function (e) {
            touchStartX = e.touches[0].clientX;
        }, { passive: true });

        car.addEventListener('touchend', function (e) {
            var dx = e.changedTouches[0].clientX - touchStartX;
            if (Math.abs(dx) > 45) goTo(dx < 0 ? carIdx + 1 : carIdx - 1);
        });

        /* Pause au survol */
        car.addEventListener('mouseenter', function () {
            clearTimeout(carTimer);
            if (bar) {
                bar.style.transition = 'none';
                /* Fige la barre à sa largeur actuelle */
                var computed = getComputedStyle(bar).width;
                var parent   = bar.parentElement;
                bar.style.width = parent
                    ? (parseFloat(computed) / parseFloat(getComputedStyle(parent).width) * 100).toFixed(2) + '%'
                    : computed;
            }
        });

        car.addEventListener('mouseleave', tick);

        /* Pause quand l'onglet est caché */
        document.addEventListener('visibilitychange', function () {
            if (document.hidden) {
                clearTimeout(carTimer);
            } else {
                tick();
            }
        });

        /* Init */
        if (slides[0]) slides[0].classList.add('on');
        if (dots[0])   dots[0].classList.add('on');
        updateCounter();
        tick();
    }


    /* ════════════════════════════════════════════════════════════
       3. AUTOCOMPLETE QUARTIER
    ════════════════════════════════════════════════════════════ */
    var QUARTIERS = [
        'Akpakpa','Fidjrossè','Cadjehoun','Ganhi','Zogbo','Houéyiho',
        'Godomey','Ste Rita','Agla','Vêdoko','Gbégamey','Wologuèdè',
        'Jéricho','Hindé','Mènontin','Togoudo','Tankpè','Zopa',
        'Calavi Kpota','Zogbadjè','Aitchedji','Dota','Oganla','Djassin',
        'Kouhounou','Guéma','Kpébié','Zongo','Agongointo','Saclo',
        'Sodohomey','Pahou','Savi','Dantokpa','Houinta','Akassato',
        'Agori','Onigbolo'
    ];

    var qInput = document.getElementById('qi');
    var qList  = document.getElementById('qs');

    if (qInput && qList) {
        qInput.addEventListener('input', function () {
            var val = this.value.trim().toLowerCase();
            qList.innerHTML = '';

            if (val.length < 1) {
                qList.classList.remove('open');
                return;
            }

            var results = QUARTIERS
                .filter(function (q) { return q.toLowerCase().indexOf(val) !== -1; })
                .slice(0, 8);

            if (!results.length) {
                qList.classList.remove('open');
                return;
            }

            results.forEach(function (q) {
                var li = document.createElement('li');
                li.className   = 'qac-li';
                li.textContent = q;

                li.addEventListener('click', function () {
                    qInput.value = q;
                    qList.classList.remove('open');
                    qInput.focus();
                });

                qList.appendChild(li);
            });

            qList.classList.add('open');
        });

        /* Ferme la liste si clic ailleurs */
        document.addEventListener('click', function (e) {
            if (!qInput.contains(e.target) && !qList.contains(e.target)) {
                qList.classList.remove('open');
            }
        });

        /* Ferme avec Échap */
        qInput.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') qList.classList.remove('open');
        });
    }


    /* ════════════════════════════════════════════════════════════
       4. FORMULAIRE DE RECHERCHE — loader
    ════════════════════════════════════════════════════════════ */
    var searchForm = document.getElementById('sf');

    if (searchForm) {
        searchForm.addEventListener('submit', function () {
            var btnSpinner = document.getElementById('bs');
            var btnText    = document.getElementById('bt');

            if (btnText)    btnText.textContent = 'Recherche…';
            if (btnSpinner) btnSpinner.disabled = true;
        });
    }


    /* ════════════════════════════════════════════════════════════
       5. FAQ ACCORDION
       - Les catégories principales s'ouvrent/ferment indépendamment.
       - Chaque sous-catégorie s'ouvre/ferme aussi indépendamment.
    ════════════════════════════════════════════════════════════ */
    document.querySelectorAll('.faq-s .fq-group').forEach(function (group) {
        var title = group.querySelector('.fq-gtitle');
        var sublist = group.querySelector('.fq-sublist');

        if (!title || !sublist) return;

        title.addEventListener('click', function () {
            var isOpen = group.classList.contains('open');
            group.classList.toggle('open', !isOpen);
            title.setAttribute('aria-expanded', String(!isOpen));
            sublist.style.display = !isOpen ? 'flex' : 'none';
        });

        group.classList.remove('open');
        title.setAttribute('aria-expanded', 'false');
        sublist.style.display = 'none';
    });

    document.querySelectorAll('.faq-s .fq-item').forEach(function (item) {
        var question = item.querySelector('.fq-q');
        var answer = item.querySelector('.fq-a');

        if (!question || !answer) return;

        question.addEventListener('click', function () {
            var isOpen = item.classList.contains('open');
            item.classList.toggle('open', !isOpen);
            question.setAttribute('aria-expanded', String(!isOpen));
            answer.setAttribute('aria-hidden', String(isOpen));
        });
    });


    /* ════════════════════════════════════════════════════════════
       6. FAVORIS
       Utilisation : <button onclick="toggleFav(this)">…</button>
       ou           : data-fav-btn sur les boutons
    ════════════════════════════════════════════════════════════ */
    function toggleFav(btn) {
        if (!btn) return;
        var ico    = btn.querySelector('i');
        var liked  = btn.classList.toggle('liked');

        if (ico) {
            ico.className  = liked ? 'fa fa-heart' : 'fa fa-heart-o';
            ico.style.color = liked ? '#EF4444' : '';
        }

        /* Animation rapide */
        btn.style.transform = 'scale(1.25)';
        setTimeout(function () { btn.style.transform = ''; }, 200);
    }

    /* Exposé globalement pour les onclick= inline */
    window.fv = toggleFav;

    /* Délégation sur les boutons data-fav-btn (alternatif sans onclick inline) */
    document.addEventListener('click', function (e) {
        var btn = e.target.closest('[data-fav-btn]');
        if (btn) toggleFav(btn);
    });

})();