@extends('layouts.master')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700;800&family=Syne:wght@700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">

<style>
    :root {
        --gr:    #16a34a; --gr2:   #0d9488;
        --gr-lt: #f0fdf4; --gr-b:  #bbf7d0;
        --gr-glow: rgba(22,163,74,.22);
        --blue:  #2563eb; --blue-lt: #eff6ff; --blue-b: #bfdbfe;
        --red:   #dc2626; --red-lt:  #fff1f2;
        --am:    #d97706; --am-lt:  #fffbeb; --am-b: #fde68a;
        --vi:    #7c3aed; --vi-lt:  #f5f3ff; --vi-b: #ddd6fe;
        --bg:    #F2F4F9; --bg2:   #E8EBF3;
        --card:  #FFFFFF;
        --ink:   #0C0E17; --ink2:  #2E3244; --ink3: #7C809A;
        --bord:  rgba(14,16,34,.09); --bord2: rgba(14,16,34,.06);
        --r:    12px; --r-lg: 18px; --r-xl: 22px;
        --sh:     0 1px 4px rgba(14,16,34,.04), 0 6px 20px rgba(14,16,34,.06);
        --sh-hov: 0 10px 28px rgba(14,16,34,.09), 0 28px 72px rgba(14,16,34,.12);
        --ease: cubic-bezier(.16,1,.3,1);
    }
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'DM Sans', sans-serif; background: var(--bg); color: var(--ink); -webkit-font-smoothing: antialiased; }

    /* ══ HERO — hauteur FIXE, jamais de reflow ══ */
    .hero-outer {
        position: relative;
        width: 100%;
        height: 520px;
        overflow: hidden;
        background: #080e18;
        contain: strict;
        flex-shrink: 0;
        display: block;
    }
    .hero-outer::after {
        content: '';
        position: absolute; inset: 0;
        background: linear-gradient(to bottom,
            rgba(8,14,24,.08) 0%, transparent 30%,
            transparent 48%, rgba(8,14,24,.82) 100%);
        pointer-events: none; z-index: 4;
    }

    .hero-slides { position: absolute; inset: 0; }
    .hero-slide {
        position: absolute; inset: 0;
        opacity: 0; visibility: hidden; pointer-events: none;
        transition: opacity .55s ease, visibility .55s ease;
        will-change: opacity;
    }
    .hero-slide.active { opacity: 1; visibility: visible; pointer-events: auto; }
    .hero-slide img {
        width: 100%; height: 100%;
        object-fit: cover; object-position: center; display: block;
        transition: transform 7s ease;
        user-select: none; pointer-events: none;
    }
    .hero-slide.active img { transform: scale(1.05); }
    .hero-slide:not(.active) img { transform: scale(1); transition: none; }
    .hero-slide-empty {
        width: 100%; height: 100%;
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        gap: 10px; background: linear-gradient(135deg,#111827,#1f2937); color: rgba(255,255,255,.32);
    }
    .hero-slide-empty i { font-size: 44px; }
    .hero-slide-empty span { font-size: 13px; font-weight: 600; }

    .hero-bread {
        position: absolute; top: 0; left: 0; right: 0; z-index: 10;
        padding: 16px 24px; display: flex; align-items: center; gap: 7px;
        font-size: 12.5px; font-weight: 600; color: rgba(255,255,255,.6);
        background: linear-gradient(to bottom, rgba(8,14,24,.55) 0%, transparent 100%);
    }
    .hero-bread a { color: rgba(255,255,255,.88); text-decoration: none !important; transition: color .18s; }
    .hero-bread a:hover { color: #4ade80; }
    .hero-bread .sep { opacity: .35; }

    .hero-pills { position: absolute; top: 14px; right: 18px; z-index: 10; display: flex; gap: 6px; }
    .hp { padding: 4px 13px; border-radius: 40px; font-size: 11px; font-weight: 700; letter-spacing: .04em; backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,.14); }
    .hp-gr   { background: rgba(22,163,74,.9);  color: #fff; }
    .hp-blue { background: rgba(37,99,235,.85); color: #fff; }
    .hp-am   { background: rgba(217,119,6,.9);  color: #fff; }

    .hero-arrow {
        position: absolute; top: 50%; z-index: 6;
        transform: translateY(-50%);
        width: 46px; height: 46px; border-radius: 50%;
        background: rgba(255,255,255,.13); backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,.2); color: #fff; font-size: 16px;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; touch-action: manipulation;
        transition: background .2s, border-color .2s, transform .2s;
        -webkit-tap-highlight-color: transparent;
    }
    .hero-arrow:hover { background: var(--gr); border-color: var(--gr); transform: translateY(-50%) scale(1.08); }
    .hero-arrow.prev { left: 16px; }
    .hero-arrow.next { right: 16px; }

    .hero-dots { position: absolute; bottom: 90px; left: 50%; transform: translateX(-50%); z-index: 6; display: flex; gap: 6px; }
    .hero-dot { width: 6px; height: 6px; border-radius: 50%; background: rgba(255,255,255,.32); border: none; padding: 0; cursor: pointer; transition: all .28s ease; -webkit-tap-highlight-color: transparent; }
    .hero-dot.active { background: #fff; width: 20px; border-radius: 3px; }

    .hero-caption {
        position: absolute; bottom: 0; left: 0; right: 0; z-index: 5;
        padding: 20px 24px 20px;
        display: flex; align-items: flex-end; justify-content: space-between;
        gap: 12px; flex-wrap: wrap;
    }
    .hc-price { display: inline-flex; align-items: center; gap: 7px; background: var(--gr); color: #fff; font-family: 'JetBrains Mono', monospace; font-size: 18px; font-weight: 600; padding: 7px 20px; border-radius: 40px; margin-bottom: 9px; box-shadow: 0 6px 22px rgba(22,163,74,.45); }
    .hc-title { font-family: 'Syne', sans-serif; font-size: 27px; font-weight: 800; color: #fff; margin: 0 0 7px; line-height: 1.12; letter-spacing: -.03em; text-shadow: 0 2px 14px rgba(0,0,0,.4); }
    .hc-loc { font-size: 13px; color: rgba(255,255,255,.7); font-weight: 400; display: flex; align-items: center; gap: 5px; }
    .hero-count { background: rgba(255,255,255,.14); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,.18); color: #fff; font-size: 12px; font-weight: 600; padding: 5px 13px; border-radius: 25px; white-space: nowrap; }

    .hero-thumbs {
        display: flex; gap: 5px; padding: 8px 12px;
        background: rgba(8,14,24,.84);
        overflow-x: auto; scrollbar-width: none;
        height: 66px; flex-shrink: 0;
    }
    .hero-thumbs::-webkit-scrollbar { display: none; }
    .ht { flex-shrink: 0; width: 74px; height: 50px; border-radius: 8px; overflow: hidden; border: 2px solid transparent; cursor: pointer; opacity: .48; transition: opacity .2s, border-color .2s; }
    .ht:hover { opacity: .8; }
    .ht.active { border-color: var(--gr); opacity: 1; }
    .ht img { width: 100%; height: 100%; object-fit: cover; display: block; user-select: none; pointer-events: none; }

    .lbx { display: none; position: fixed; inset: 0; background: rgba(4,6,12,.97); z-index: 9999; flex-direction: column; align-items: center; justify-content: center; }
    .lbx.open { display: flex; animation: lbxFade .2s ease; }
    @keyframes lbxFade { from{opacity:0} to{opacity:1} }
    .lbx-toolbar { position: absolute; top: 0; left: 0; right: 0; padding: 12px 16px; display: flex; align-items: center; justify-content: space-between; background: linear-gradient(to bottom, rgba(4,6,12,.78) 0%, transparent 100%); z-index: 2; }
    .lbx-ctr { font-size: 13px; font-weight: 600; color: rgba(255,255,255,.5); font-family: 'JetBrains Mono', monospace; }
    .lbx-close { width: 38px; height: 38px; border-radius: 50%; background: rgba(255,255,255,.1); border: 1px solid rgba(255,255,255,.18); color: #fff; font-size: 16px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: background .18s; }
    .lbx-close:hover { background: var(--red); }
    .lbx-body { position: relative; width: 100%; flex: 1; display: flex; align-items: center; justify-content: center; overflow: hidden; }
    .lbx-img-wrap { display: flex; align-items: center; justify-content: center; width: 100%; height: 100%; padding: 0 62px; }
    .lbx-img { max-width: 100%; max-height: 84vh; object-fit: contain; border-radius: var(--r); box-shadow: 0 32px 80px rgba(0,0,0,.6); user-select: none; display: block; transition: opacity .18s, transform .18s; }
    .lbx-nav { position: absolute; top: 50%; transform: translateY(-50%); width: 44px; height: 44px; border-radius: 50%; background: rgba(255,255,255,.1); backdrop-filter: blur(8px); border: 1px solid rgba(255,255,255,.18); color: #fff; font-size: 16px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: background .2s, border-color .2s; z-index: 2; }
    .lbx-nav:hover { background: var(--gr); border-color: var(--gr); }
    .lbx-nav.prev { left: 8px; }
    .lbx-nav.next { right: 8px; }

    .dp { padding: 24px 0 80px; }
    .dp > .container { max-width: 1240px; }
    .dp-row { display: flex; align-items: flex-start; gap: 22px; }
    .dp-left { flex: 1; min-width: 0; }
    .dp-right { width: 330px; flex-shrink: 0; position: sticky; top: 80px; }

    .dc { background: var(--card); border: 1px solid var(--bord); border-radius: var(--r-xl); box-shadow: var(--sh); margin-bottom: 18px; overflow: hidden; opacity: 0; transform: translateY(14px); transition: opacity .46s var(--ease), transform .46s var(--ease), box-shadow .26s; }
    .dc:hover { box-shadow: var(--sh-hov); }
    .dc.vis, .dc.ready { opacity: 1; transform: none; }
    .dc-head { padding: 17px 22px 14px; border-bottom: 1px solid var(--bord2); display: flex; align-items: center; gap: 13px; background: linear-gradient(105deg,#fafbff 0%,var(--card) 60%); }
    .dh-ico { width: 40px; height: 40px; border-radius: var(--r); display: flex; align-items: center; justify-content: center; font-size: 15px; flex-shrink: 0; }
    .dh-ico.gr   { background: var(--gr-lt); color: var(--gr);   border: 1.5px solid var(--gr-b); }
    .dh-ico.blue { background: var(--blue-lt); color: var(--blue); border: 1.5px solid var(--blue-b); }
    .dh-ico.am   { background: var(--am-lt);  color: var(--am);  border: 1.5px solid var(--am-b); }
    .dh-ico.vi   { background: var(--vi-lt);  color: var(--vi);  border: 1.5px solid var(--vi-b); }
    .dh-title { font-size: 14px; font-weight: 800; color: var(--ink); letter-spacing: -.02em; }
    .dh-sub   { font-size: 11.5px; color: var(--ink3); margin-top: 2px; }
    .dc-body  { padding: 20px 22px; }

    .ft-section { font-size: 10px; font-weight: 800; color: var(--ink3); text-transform: uppercase; letter-spacing: .12em; display: flex; align-items: center; gap: 6px; padding: 16px 0 10px; border-bottom: 1.5px dashed var(--bord2); margin-bottom: 12px; width: 100%; }
    .ft-section:first-child { padding-top: 0; }
    .ft-section i { color: var(--gr); font-size: 11px; }

    .feat-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(148px, 1fr)); gap: 9px; margin-bottom: 6px; }
    .feat-tile { background: var(--bg); border: 1.5px solid var(--bord2); border-radius: var(--r-lg); padding: 13px 11px; display: flex; align-items: center; gap: 11px; transition: border-color .2s, background .2s, box-shadow .2s, transform .2s; }
    .feat-tile:hover { border-color: rgba(22,163,74,.35); background: var(--gr-lt); transform: translateY(-2px); box-shadow: 0 5px 16px rgba(22,163,74,.09); }
    .ft-ico { width: 36px; height: 36px; border-radius: 10px; background: var(--card); border: 1.5px solid var(--bord); display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 14px; color: var(--gr); transition: all .18s; }
    .feat-tile:hover .ft-ico { background: var(--gr); border-color: var(--gr); color: #fff; }
    .ft-content { min-width: 0; flex: 1; }
    .ft-lbl { font-size: 9.5px; font-weight: 700; color: var(--ink3); text-transform: uppercase; letter-spacing: .08em; display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .ft-val { font-size: 13.5px; font-weight: 700; color: var(--ink); display: block; margin-top: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .ft-yes  { color: var(--gr)   !important; }
    .ft-no   { color: var(--ink3) !important; font-weight: 500 !important; }
    .ft-blue { color: var(--blue) !important; }
    .ft-am   { color: var(--am)   !important; }

    .cpt-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 12px; }
    .cpt-card { border-radius: var(--r-lg); padding: 16px 18px; border: 1.5px solid; }
    .cpt-card.eau  { background: #eff6ff; border-color: #bfdbfe; }
    .cpt-card.elec { background: #fefce8; border-color: #fde68a; }
    .cpt-ico { font-size: 22px; margin-bottom: 7px; }
    .cpt-lbl { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .09em; margin-bottom: 4px; }
    .cpt-card.eau  .cpt-lbl { color: #1d4ed8; }
    .cpt-card.elec .cpt-lbl { color: #92400e; }
    .cpt-val { font-size: 14px; font-weight: 700; }
    .cpt-card.eau  .cpt-val { color: #1e40af; }
    .cpt-card.elec .cpt-val { color: #78350f; }

    .surf-bar { display: flex; align-items: center; justify-content: space-between; padding: 10px 0; border-bottom: 1px dashed var(--bord2); }
    .surf-bar:last-child { border-bottom: none; }
    .surf-bar-lbl { display: flex; align-items: center; gap: 9px; font-size: 13px; font-weight: 600; color: var(--ink2); }
    .surf-bar-lbl i { width: 26px; height: 26px; border-radius: 7px; background: var(--gr-lt); color: var(--gr); display: flex; align-items: center; justify-content: center; font-size: 12px; flex-shrink: 0; }
    .surf-bar-val { font-size: 13px; font-weight: 700; color: var(--ink); font-family: 'JetBrains Mono', monospace; }
    .surf-bar-val small { font-size: 10px; font-weight: 500; color: var(--ink3); }
    .surf-total-row { margin-top: 12px; background: var(--gr-lt); border: 1.5px solid var(--gr-b); border-radius: var(--r); padding: 11px 15px; display: flex; align-items: center; justify-content: space-between; }
    .surf-total-lbl { font-size: 11.5px; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; color: var(--gr); }
    .surf-total-val { font-size: 16px; font-weight: 800; color: var(--gr); font-family: 'JetBrains Mono', monospace; }

    .terrain-dims { display: grid; grid-template-columns: repeat(3,1fr); gap: 12px; }
    .terrain-dim-card { background: var(--gr-lt); border: 1.5px solid var(--gr-b); border-radius: var(--r-lg); padding: 16px; text-align: center; }
    .tdc-ico { font-size: 22px; margin-bottom: 6px; }
    .tdc-lbl { font-size: 10px; font-weight: 700; color: var(--gr); text-transform: uppercase; letter-spacing: .08em; margin-bottom: 5px; }
    .tdc-val { font-size: 18px; font-weight: 800; color: var(--ink); font-family: 'JetBrains Mono', monospace; }
    .tdc-unit { font-size: 11px; color: var(--ink3); font-weight: 500; }

    .tf-badge { display: inline-flex; align-items: center; gap: 7px; padding: 8px 16px; border-radius: var(--r-lg); font-size: 13px; font-weight: 700; background: var(--blue-lt); border: 1.5px solid var(--blue-b); color: var(--blue); }
    .tf-badge i { font-size: 14px; }

    .vid-wrap { border-radius: var(--r-lg); overflow: hidden; border: 1.5px solid var(--bord); background: #000; position: relative; }
    .vid-wrap video { width: 100%; max-height: 400px; display: block; }
    .vid-pill { position: absolute; top: 11px; left: 11px; background: rgba(37,99,235,.88); color: #fff; font-size: 11.5px; font-weight: 700; padding: 4px 12px; border-radius: 18px; backdrop-filter: blur(6px); }

    .map-frame { width: 100%; height: 280px; border-radius: var(--r-lg); overflow: hidden; border: 1.5px solid var(--bord); }
    .map-frame iframe { width: 100%; height: 100%; border: none; display: block; }
    .map-chips { display: flex; gap: 7px; margin-top: 12px; flex-wrap: wrap; align-items: center; }
    .geo-chip { display: inline-flex; align-items: center; gap: 5px; background: var(--blue-lt); border: 1.5px solid var(--blue-b); border-radius: 7px; padding: 5px 11px; font-size: 11.5px; font-weight: 700; color: var(--blue); font-family: 'JetBrains Mono', monospace; }
    .btn-gmaps { display: inline-flex; align-items: center; gap: 5px; background: var(--gr-lt); border: 1.5px solid var(--gr-b); border-radius: 7px; padding: 5px 13px; font-size: 12px; font-weight: 700; color: var(--gr); text-decoration: none !important; transition: all .18s; }
    .btn-gmaps:hover { background: var(--gr); color: #fff; border-color: var(--gr); }

    .desc-banner { background: linear-gradient(135deg,var(--gr-lt) 0%,#f6fdf9 100%); border: 1.5px solid var(--gr-b); border-radius: var(--r-lg); padding: 16px 20px; margin-bottom: 18px; display: flex; gap: 13px; align-items: flex-start; }
    .desc-banner-ico { width: 42px; height: 42px; border-radius: 11px; background: var(--gr); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 17px; flex-shrink: 0; }
    .desc-banner p { margin: 0; font-size: 14px; color: var(--ink2); line-height: 1.72; white-space: pre-line; }
    .desc-banner strong { color: var(--ink); }
    .desc-body { font-size: 14.5px; line-height: 1.95; color: var(--ink2); white-space: pre-line; margin: 0; border-left: 3px solid var(--bord2); padding-left: 16px; word-wrap: break-word; }

    .cf-group { margin-bottom: 14px; }
    .cf-group label { display: block; font-size: 10.5px; font-weight: 700; color: var(--ink3); text-transform: uppercase; letter-spacing: .09em; margin-bottom: 5px; }
    .cf-group input, .cf-group textarea { display: block; width: 100%; padding: 11px 14px; border-radius: var(--r); border: 1.5px solid var(--bord); background: var(--bg); font-size: 13.5px; font-family: 'DM Sans', sans-serif; color: var(--ink); outline: none; transition: all .2s; }
    .cf-group input:focus, .cf-group textarea:focus { border-color: var(--gr); background: var(--card); box-shadow: 0 0 0 3px rgba(22,163,74,.09); }
    .cf-group textarea { min-height: 100px; resize: vertical; }
    .cf-group .text-danger { font-size: 11.5px; color: var(--red); margin-top: 4px; display: block; }
    .btn-send { display: flex; align-items: center; justify-content: center; gap: 8px; width: 100%; padding: 13px; border-radius: var(--r); border: none; background: var(--gr); color: #fff; font-size: 14.5px; font-weight: 700; font-family: 'DM Sans', sans-serif; cursor: pointer; box-shadow: 0 6px 18px rgba(22,163,74,.32); transition: all .2s; }
    .btn-send:hover { background: #15803d; transform: translateY(-2px); box-shadow: 0 10px 26px rgba(22,163,74,.42); }
    .btn-send:disabled { opacity: .7; cursor: not-allowed; transform: none; }
    .alert-ok { background: var(--gr-lt); border: 1.5px solid var(--gr-b); border-radius: var(--r); padding: 12px 15px; font-size: 13px; color: var(--gr); font-weight: 700; margin-bottom: 14px; display: flex; gap: 8px; align-items: center; }

    /* ── CTA "Envoyer un message" (ouvre la modale) ── */
    .cta-send-box { display: flex; align-items: center; gap: 16px; flex-wrap: wrap; }
    .cta-send-txt { flex: 1; min-width: 200px; }
    .cta-send-txt p { font-size: 13px; color: var(--ink3); margin-top: 3px; line-height: 1.55; }
    .btn-open-modal { display: inline-flex; align-items: center; gap: 9px; padding: 13px 26px; border-radius: var(--r); border: none; background: var(--gr); color: #fff; font-size: 14px; font-weight: 700; font-family: 'DM Sans', sans-serif; cursor: pointer; box-shadow: 0 6px 18px rgba(22,163,74,.32); transition: all .2s; flex-shrink: 0; }
    .btn-open-modal:hover { background: #15803d; transform: translateY(-2px); box-shadow: 0 10px 26px rgba(22,163,74,.42); }

    /* ── Modale de contact ── */
    .cmodal-overlay { display: none; position: fixed; inset: 0; background: rgba(8,14,24,.66); backdrop-filter: blur(3px); z-index: 9998; align-items: center; justify-content: center; padding: 20px; }
    .cmodal-overlay.open { display: flex; animation: cmodalFade .2s ease; }
    @keyframes cmodalFade { from{opacity:0} to{opacity:1} }
    .cmodal-box { background: var(--card); border-radius: var(--r-xl); width: 100%; max-width: 480px; max-height: 90vh; overflow-y: auto; box-shadow: 0 32px 80px rgba(0,0,0,.35); transform: translateY(14px) scale(.98); opacity: 0; transition: transform .28s var(--ease), opacity .28s var(--ease); }
    .cmodal-overlay.open .cmodal-box { transform: none; opacity: 1; }
    .cmodal-head { display: flex; align-items: center; gap: 13px; padding: 20px 22px 16px; border-bottom: 1px solid var(--bord2); position: sticky; top: 0; background: var(--card); z-index: 1; }
    .cmodal-head .dh-ico { margin: 0; }
    .cmodal-head-txt { flex: 1; }
    .cmodal-head-txt .dh-title { display: block; }
    .cmodal-close { width: 34px; height: 34px; border-radius: 50%; border: 1.5px solid var(--bord); background: var(--bg); color: var(--ink3); font-size: 14px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all .18s; flex-shrink: 0; }
    .cmodal-close:hover { background: var(--red); border-color: var(--red); color: #fff; }
    .cmodal-body { padding: 20px 22px 24px; }

    .sec-block { background: var(--card); border: 1.5px solid var(--bord); border-radius: var(--r-xl) var(--r-xl) 0 0; padding: 20px 18px 18px; position: relative; overflow: hidden; }
    .sec-block::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, var(--gr), var(--gr2), var(--gr)); }
    .sec-block::after { content: ''; position: absolute; bottom: 0; left: 20px; right: 20px; height: 1px; background: var(--bord2); }
    .sec-head { display: flex; align-items: center; gap: 9px; margin-bottom: 14px; }
    .sec-badge { display: inline-flex; align-items: center; gap: 5px; background: rgba(22,163,74,.1); border: 1px solid rgba(22,163,74,.25); color: var(--gr); border-radius: 30px; padding: 3px 10px; font-size: 10px; font-weight: 800; letter-spacing: .07em; text-transform: uppercase; }
    .sec-badge .sdot { width: 5px; height: 5px; border-radius: 50%; background: var(--gr); animation: pulseDot 2s ease-in-out infinite; }
    @keyframes pulseDot { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.3;transform:scale(.6)} }
    .sec-title { font-size: 13px; font-weight: 700; color: var(--ink); }
    .sec-tips { display: flex; flex-direction: column; gap: 8px; }
    .sec-tip { display: flex; align-items: flex-start; gap: 10px; background: var(--bg); border: 1.5px solid var(--bord2); border-radius: 10px; padding: 10px 12px; transition: border-color .18s, background .18s, transform .18s; }
    .sec-tip:hover { border-color: rgba(22,163,74,.28); background: var(--gr-lt); transform: translateX(2px); }
    .sec-tip-ico { width: 30px; height: 30px; border-radius: 8px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; font-size: 13px; }
    .sec-tip:nth-child(1) .sec-tip-ico { background: rgba(22,163,74,.12); color: var(--gr); }
    .sec-tip:nth-child(2) .sec-tip-ico { background: rgba(37,99,235,.10); color: var(--blue); }
    .sec-tip:nth-child(3) .sec-tip-ico { background: rgba(234,179,8,.12); color: #b45309; }
    .sec-tip:nth-child(4) .sec-tip-ico { background: rgba(168,85,247,.10); color: #7c3aed; }
    .sec-tip-txt strong { display: block; font-size: 12px; font-weight: 700; color: var(--ink); margin-bottom: 2px; }
    .sec-tip-txt p { font-size: 11px; color: var(--ink3); margin: 0; line-height: 1.52; }

    .agent-top { padding: 20px 18px 16px; text-align: center; background: linear-gradient(160deg,#f5fdf8 0%,var(--card) 60%); border-bottom: 1px solid var(--bord2); position: relative; }
    .agent-av-wrap { position: relative; display: inline-block; margin-bottom: 11px; }
    .agent-av { width: 72px; height: 72px; border-radius: 50%; border: 3px solid #fff; box-shadow: 0 4px 16px rgba(14,16,34,.13); object-fit: cover; display: block; }
    .agent-online { position: absolute; bottom: 4px; right: 4px; width: 13px; height: 13px; border-radius: 50%; background: var(--gr); border: 2.5px solid #fff; }
    .agent-name { font-size: 16px; font-weight: 700; color: var(--ink); margin: 0 0 5px; letter-spacing: -.02em; }
    .agent-badge { display: inline-block; background: var(--gr-lt); color: var(--gr); border: 1.5px solid var(--gr-b); font-size: 10px; font-weight: 700; padding: 3px 10px; border-radius: 18px; text-transform: uppercase; letter-spacing: .05em; }
    .agent-contacts { list-style: none; padding: 12px 16px; border-bottom: 1px solid var(--bord2); }
    .agent-contacts li { display: flex; align-items: center; gap: 9px; font-size: 12.5px; color: var(--ink2); font-weight: 500; padding: 7px 0; border-bottom: 1px dashed var(--bord2); }
    .agent-contacts li:last-child { border-bottom: none; }
    .ac-ico { width: 30px; height: 30px; border-radius: 8px; background: var(--gr-lt); color: var(--gr); border: 1.5px solid var(--gr-b); display: inline-flex; align-items: center; justify-content: center; font-size: 11px; flex-shrink: 0; }
    .agent-cta { padding: 14px 16px 18px; }
    .cta-note { font-size: 12.5px; color: var(--ink3); margin-bottom: 13px; line-height: 1.6; }
    .btn-call { display: flex; align-items: center; justify-content: center; gap: 7px; width: 100%; padding: 11px 14px; border-radius: var(--r); border: none; background: var(--ink); color: #fff !important; font-size: 13.5px; font-weight: 700; font-family: 'DM Sans', sans-serif; cursor: pointer; margin-bottom: 8px; transition: all .2s; text-decoration: none !important; }
    .btn-call:hover { background: var(--gr); transform: translateY(-2px); box-shadow: 0 8px 22px var(--gr-glow); }
    .btn-wa { display: flex; align-items: center; justify-content: center; gap: 7px; width: 100%; padding: 11px 14px; border-radius: var(--r); border: none; background: #16a34a; color: #fff !important; font-size: 13.5px; font-weight: 700; font-family: 'DM Sans', sans-serif; cursor: pointer; transition: all .2s; text-decoration: none !important; }
    .btn-wa:hover { background: #15803d; transform: translateY(-2px); box-shadow: 0 8px 22px rgba(22,163,74,.32); }

    .sim-list { display: flex; flex-direction: column; gap: 10px; max-height: 480px; overflow-y: auto; overflow-x: hidden; padding: 4px 2px 4px 4px; scrollbar-width: thin; scrollbar-color: var(--gr-b) transparent; }
    .sim-list::-webkit-scrollbar { width: 4px; }
    .sim-list::-webkit-scrollbar-thumb { background: var(--gr-b); border-radius: 4px; }
    .sim-card { display: flex; gap: 10px; border-radius: var(--r-lg); overflow: hidden; border: 1.5px solid var(--bord); background: var(--card); text-decoration: none !important; color: var(--ink); transition: transform .2s, box-shadow .2s, border-color .2s; }
    .sim-card:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(14,16,34,.1); border-color: rgba(22,163,74,.3); color: var(--ink); }
    .sim-card-img { width: 88px; height: 80px; flex-shrink: 0; overflow: hidden; background: var(--bg2); position: relative; }
    .sim-card-img img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform .38s ease; }
    .sim-card:hover .sim-card-img img { transform: scale(1.07); }
    .sim-badge { position: absolute; top: 5px; left: 5px; font-size: 8.5px; font-weight: 800; padding: 2px 7px; border-radius: 16px; }
    .sim-badge.louer  { background: var(--gr);   color: #fff; }
    .sim-badge.vendre { background: #f59e0b; color: #fff; }
    .sim-body { padding: 8px 10px 8px 0; flex: 1; min-width: 0; display: flex; flex-direction: column; justify-content: center; gap: 3px; }
    .sim-loc { font-size: 12.5px; font-weight: 700; color: var(--ink); display: flex; align-items: center; gap: 4px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis; }
    .sim-loc i { color: var(--gr); font-size: 9px; flex-shrink: 0; }
    .sim-type  { font-size: 10.5px; color: var(--ink3); font-weight: 500; }
    .sim-price { font-size: 13px; font-weight: 800; color: var(--gr); font-family: 'JetBrains Mono', monospace; margin-top: 2px; }
    .sim-arrow { display: inline-flex; align-items: center; gap: 3px; font-size: 10px; font-weight: 700; color: var(--ink3); margin-top: 2px; transition: color .18s; }
    .sim-card:hover .sim-arrow { color: var(--gr); }
    .sim-empty { padding: 20px; text-align: center; font-size: 13px; color: var(--ink3); }

    @media (max-width: 991px) {
        .hero-outer { height: 400px; }
        .hc-title { font-size: 22px; }
        .dp-row { flex-direction: column; gap: 0; }
        .dp-right { width: 100%; position: static; }
    }
    @media (max-width: 767px) {
        .hero-outer { height: 52vw; min-height: 210px; max-height: 320px; }
        .hero-caption { padding: 10px 14px 14px; flex-direction: column; align-items: flex-start; gap: 6px; }
        .hc-title { font-size: 18px; } .hc-price { font-size: 15px; padding: 6px 16px; }
        .hero-thumbs { height: 56px; }
        .ht { width: 66px; height: 44px; }
        .hero-arrow { width: 38px; height: 38px; font-size: 14px; }
        .dp { padding: 12px 0 50px; }
        .dc-body { padding: 14px 15px; } .dc-head { padding: 14px 15px; }
        .feat-grid { grid-template-columns: repeat(2, 1fr); gap: 8px; }
        .terrain-dims { grid-template-columns: repeat(2,1fr); }
        .lbx-img-wrap { padding: 0 46px; }
    }
    @media (max-width: 480px) {
        .feat-grid { grid-template-columns: repeat(2, 1fr); }
        .terrain-dims { grid-template-columns: 1fr 1fr; }
        .lbx-img-wrap { padding: 0 38px; }
        .hero-count { display: none; }
        .dp > .container { padding: 0 11px; }
    }
</style>

@php
    $imgs    = array_values(array_filter(explode('|', $appartements->images ?? '')));
    $imgCnt  = count($imgs);
    $type    = $appartements->type ?? '';

    $oui = function($v){ return strtolower(trim($v ?? '')) === 'oui'; };
    $non = function($v){ return strtolower(trim($v ?? '')) === 'non'; };
    $val = function($v){ return !empty(trim($v ?? '')); };
    $num = function($v){ return isset($v) && intval($v) > 0; };

    $isMaison   = in_array($type, ['Maison','Appartement']);
    $isTerrain  = $type === 'Terrain';
    $isBureau   = $type === 'Bureaux';
    $isBoutique = $type === 'Boutique';

    $hasCompteurs = $val($appartements->compteur_eau ?? '') || $val($appartements->compteur_elec ?? '');
    $hasSurfaces  = $isMaison && (
        $num($appartements->surface_salon   ?? null) ||
        $num($appartements->surface_cuisine ?? null) ||
        $num($appartements->surface_chambre ?? null) ||
        $num($appartements->surface_sdb     ?? null)
    );
    $hasTerrainDims = $isTerrain && (
        $num($appartements->terrain_largeur  ?? null) ||
        $num($appartements->terrain_longueur ?? null) ||
        $num($appartements->surface          ?? null)
    );
    // Section "légale" du terrain : titre foncier + texte libre saisi par le propriétaire
    $hasTerrainLegal = $isTerrain && (
        $val($appartements->titre_foncier ?? '') ||
        $val($appartements->autres_caracteristiques_terrain ?? '')
    );

    $catColor = ($appartements->categorie ?? '') === 'louer' ? 'hp-gr' : 'hp-am';
    $catLabel = ($appartements->categorie ?? '') === 'louer' ? 'À louer' : 'À vendre';
@endphp

{{-- ══ LIGHTBOX ══ --}}
<div class="lbx" id="lbx" role="dialog" aria-modal="true">
    <div class="lbx-toolbar">
        <div class="lbx-ctr" id="lbxCtr">1 / {{ $imgCnt }}</div>
        <button class="lbx-close" id="lbxClose" aria-label="Fermer"><i class="fa fa-times"></i></button>
    </div>
    <div class="lbx-body">
        <button class="lbx-nav prev" id="lbxPrev"><i class="fa fa-angle-left"></i></button>
        <div class="lbx-img-wrap" id="lbxImgWrap">
            <img src="" alt="" class="lbx-img" id="lbxImg" draggable="false">
        </div>
        <button class="lbx-nav next" id="lbxNext"><i class="fa fa-angle-right"></i></button>
    </div>
</div>

{{-- ══ MODALE CONTACT ══ --}}
<div class="cmodal-overlay" id="contactModal" role="dialog" aria-modal="true">
    <div class="cmodal-box">
        <div class="cmodal-head">
            <div class="dh-ico gr"><i class="fa fa-paper-plane"></i></div>
            <div class="cmodal-head-txt">
                <div class="dh-title">Envoyer un message</div>
            </div>
            <button type="button" class="cmodal-close" id="cmodalClose" aria-label="Fermer"><i class="fa fa-times"></i></button>
        </div>
        <div class="cmodal-body">
            <form action="{{ route('appartement.mailProprietaire') }}" method="POST" id="cForm">
                @csrf
                <input type="hidden" name="entreprise" value="{{ $appartements->entreprise?->user?->email ?? '' }}">
                <input type="hidden" name="appartement_id" value="{{ $appartements->id }}">
                <div class="row">
                    <div class="col-sm-6"><div class="cf-group"><label>Nom &amp; prénom</label><input type="text" name="nom" placeholder="Loc Immo" value="{{ old('nom') }}">@error('nom')<span class="text-danger">{{ $message }}</span>@enderror</div></div>
                    <div class="col-sm-6"><div class="cf-group"><label>Adresse e-mail</label><input type="email" name="email" placeholder="vous@email.com" value="{{ old('email') }}">@error('email')<span class="text-danger">{{ $message }}</span>@enderror</div></div>
                </div>
                <div class="cf-group"><label>Téléphone</label><input type="tel" name="telephone" placeholder="+229 00 00 00 00" value="{{ old('telephone') }}">@error('telephone')<span class="text-danger">{{ $message }}</span>@enderror</div>
                <div class="cf-group"><label>Votre message</label><textarea name="message" placeholder="Bonjour, je suis intéressé(e) par ce bien…">{{ old('message') }}</textarea>@error('message')<span class="text-danger">{{ $message }}</span>@enderror</div>
                <button type="submit" class="btn-send" id="btnSend"><i class="fa fa-paper-plane"></i> Envoyer le message</button>
            </form>
        </div>
    </div>
</div>

{{-- ══ HERO ══ --}}
<div class="hero-outer" id="heroOuter">
    <div class="hero-bread">
        <a href="{{ route('home') }}"><i class="fa fa-home"></i></a>
        <span class="sep">/</span>
        <a href="{{ route('annonce.all') }}">Annonces</a>
        <span class="sep">/</span>
        <span style="color:rgba(255,255,255,.48)">{{ Str::limit($appartements->quartier ?? '', 26) }}</span>
    </div>
    

    <div class="hero-slides" id="heroSlides">
        @if($imgCnt > 0)
            @foreach($imgs as $k => $img)
            <div class="hero-slide {{ $k===0?'active':'' }}" data-index="{{ $k }}" data-src="{{ URL::to($img) }}" title="Cliquez pour voir {{ $type }} à {{ $appartements->quartier ?? '' }} — Photo {{ $k+1 }}">
                <img src="{{ URL::to($img) }}"
                     alt="{{ $type }} à {{ $appartements->quartier ?? '' }} — Photo {{ $k+1 }}"
                     loading="{{ $k===0?'eager':'lazy' }}" draggable="false" >
            </div>
            @endforeach
        @else
            {{-- Annonce sans photo (ancienne donnée) : on évite un hero vide --}}
            <div class="hero-slide active" data-index="0">
                <div class="hero-slide-empty">
                    <i class="fa fa-home"></i>
                    <span>Aucune photo disponible</span>
                </div>
            </div>
        @endif
    </div>

    @if($imgCnt > 1)
    <button class="hero-arrow prev" id="heroPrev" type="button"><i class="fa fa-angle-left"></i></button>
    <button class="hero-arrow next" id="heroNext" type="button"><i class="fa fa-angle-right"></i></button>
    @endif

    @if($imgCnt > 1 && $imgCnt <= 12)
    <div class="hero-dots" id="heroDots">
        @for($d=0; $d<$imgCnt; $d++)
        <button class="hero-dot {{ $d===0?'active':'' }}" data-index="{{ $d }}" type="button"></button>
        @endfor
    </div>
    @endif

    <div class="hero-caption">
        <div>
            <div class="hc-price"><i class="fa fa-money"></i> {{ number_format($appartements->prix ?? 0,0,',',' ') }} FCFA</div>
            <h1 class="hc-title">{{ $appartements->quartier }}</h1>
            <div class="hc-loc"><i class="fa fa-map-marker"></i> {{ $appartements->departement }}, {{ $appartements->commune }}, Bénin</div>
        </div>
        @if($imgCnt > 0)
        <div class="hero-count"><i class="fa fa-camera" style="margin-right:5px;"></i>{{ $imgCnt }} photo{{ $imgCnt>1?'s':'' }}</div>
        @endif
    </div>
</div>

@if($imgCnt > 1)
<div class="hero-thumbs" id="heroThumbs">
    @foreach($imgs as $k => $img)
    <div class="ht {{ $k===0?'active':'' }}" data-index="{{ $k }}" role="button" tabindex="0">
        <img src="{{ URL::to($img) }}" alt="Miniature {{ $k+1 }}" loading="lazy" draggable="false">
    </div>
    @endforeach
</div>
@endif

{{-- ══ CONTENU ══ --}}
<div class="dp">
<div class="container">
<div class="dp-row">

{{-- ═══ COLONNE GAUCHE ═══ --}}
<div class="dp-left">

    {{-- ▌ INFOS GÉNÉRALES (commun à tous les types) --}}
    <div class="dc">
        <div class="dc-head">
            <div class="dh-ico gr"><i class="fa fa-sliders"></i></div>
            <div>
                <div class="dh-title">{{ $type }} — Caractéristiques</div>
                <div class="dh-sub">{{ $catLabel }} · {{ $appartements->commune }}, {{ $appartements->departement }}</div>
            </div>
        </div>
        <div class="dc-body">

            {{-- === MAISON / APPARTEMENT === --}}
            @if($isMaison)

            <div class="ft-section"><i class="fa fa-info-circle"></i> Informations générales</div>
            <div class="feat-grid">
                <div class="feat-tile"><div class="ft-ico"><i class="fa fa-tag"></i></div><div class="ft-content"><span class="ft-lbl">Catégorie</span><span class="ft-val {{ ($appartements->categorie??'')==='louer'?'ft-yes':'ft-blue' }}">{{ $catLabel }}</span></div></div>
                @if($val($appartements->surface ?? ''))<div class="feat-tile"><div class="ft-ico"><i class="fa fa-arrows-alt"></i></div><div class="ft-content"><span class="ft-lbl">Surface totale</span><span class="ft-val">{{ $appartements->surface }} m²</span></div></div>@endif
                @if($val($appartements->caution ?? '') && $appartements->caution !== '0')<div class="feat-tile"><div class="ft-ico"><i class="fa fa-shield"></i></div><div class="ft-content"><span class="ft-lbl">Caution</span><span class="ft-val">{{ $appartements->caution }}</span></div></div>@endif
                @if($val($appartements->negociable ?? ''))<div class="feat-tile"><div class="ft-ico"><i class="fa fa-money"></i></div><div class="ft-content"><span class="ft-lbl">Prix</span><span class="ft-val {{ $oui($appartements->negociable??'')?'ft-yes':'ft-no' }}">{{ $oui($appartements->negociable??'')?'Négociable':'Non négociable' }}</span></div></div>@endif
            </div>

            <div class="ft-section"><i class="fa fa-th-large"></i> Répartition des pièces</div>
            <div class="feat-grid">
                @if($num($appartements->nombrePieces??null))<div class="feat-tile"><div class="ft-ico"><i class="fa fa-building-o"></i></div><div class="ft-content"><span class="ft-lbl">Total pièces</span><span class="ft-val">{{ $appartements->nombrePieces }}</span></div></div>@endif
                @if($num($appartements->nombreSalon??null))<div class="feat-tile"><div class="ft-ico"><i class="fa fa-television"></i></div><div class="ft-content"><span class="ft-lbl">Salon(s)</span><span class="ft-val">{{ $appartements->nombreSalon }}</span></div></div>@endif
                @if($num($appartements->nombreCuisine??null))<div class="feat-tile"><div class="ft-ico"><i class="fa fa-cutlery"></i></div><div class="ft-content"><span class="ft-lbl">Cuisine(s)</span><span class="ft-val">{{ $appartements->nombreCuisine }}</span></div></div>@endif
                @if($num($appartements->nombreChambre??null))<div class="feat-tile"><div class="ft-ico"><i class="fa fa-bed"></i></div><div class="ft-content"><span class="ft-lbl">Chambre(s)</span><span class="ft-val">{{ $appartements->nombreChambre }}</span></div></div>@endif
                @if($num($appartements->nombreSalleBain??null))<div class="feat-tile"><div class="ft-ico"><i class="fa fa-bath"></i></div><div class="ft-content"><span class="ft-lbl">Salle(s) de bain</span><span class="ft-val">{{ $appartements->nombreSalleBain }}</span></div></div>@endif
            </div>

            <div class="ft-section"><i class="fa fa-check-circle"></i> Options résidentielles</div>
            <div class="feat-grid">
                <div class="feat-tile"><div class="ft-ico"><i class="fa fa-car"></i></div><div class="ft-content"><span class="ft-lbl">Parking</span><span class="ft-val {{ $oui($appartements->packing??'')?'ft-yes':($non($appartements->packing??'')?'ft-no':'') }}">{{ $appartements->packing ?? '—' }}</span></div></div>
                <div class="feat-tile"><div class="ft-ico"><i class="fa fa-tint"></i></div><div class="ft-content"><span class="ft-lbl">Sanitaire / WC</span><span class="ft-val {{ $oui($appartements->sanitaire??'')?'ft-yes':($non($appartements->sanitaire??'')?'ft-no':'') }}">{{ $appartements->sanitaire ?? '—' }}</span></div></div>
                @if($val($appartements->collocation??''))<div class="feat-tile"><div class="ft-ico"><i class="fa fa-users"></i></div><div class="ft-content"><span class="ft-lbl">Colocation</span><span class="ft-val {{ $oui($appartements->collocation??'')?'ft-yes':'ft-no' }}">{{ $appartements->collocation }}</span></div></div>@endif
                @if($val($appartements->proprio_vit??''))<div class="feat-tile"><div class="ft-ico"><i class="fa fa-user-circle"></i></div><div class="ft-content"><span class="ft-lbl">Proprio sur place</span><span class="ft-val {{ $oui($appartements->proprio_vit??'')?'ft-yes':'ft-no' }}">{{ $appartements->proprio_vit }}</span></div></div>@endif
            </div>

            <div class="ft-section"><i class="fa fa-plug"></i> Équipements</div>
            <div class="feat-grid">
                <div class="feat-tile"><div class="ft-ico"><i class="fa fa-snowflake"></i></div><div class="ft-content"><span class="ft-lbl">Climatiseur</span><span class="ft-val {{ $oui($appartements->clime??'')?'ft-yes':($non($appartements->clime??'')?'ft-no':'') }}">{{ $appartements->clime ?? '—' }}</span></div></div>
                <div class="feat-tile"><div class="ft-ico"><i class="fa fa-circle-o-notch"></i></div><div class="ft-content"><span class="ft-lbl">Brasseur d'air</span><span class="ft-val {{ $oui($appartements->brasseur??'')?'ft-yes':($non($appartements->brasseur??'')?'ft-no':'') }}">{{ $appartements->brasseur ?? '—' }}</span></div></div>
                <div class="feat-tile"><div class="ft-ico"><i class="fa fa-wifi"></i></div><div class="ft-content"><span class="ft-lbl">Wifi</span><span class="ft-val {{ $oui($appartements->wifi??'')?'ft-yes':($non($appartements->wifi??'')?'ft-no':'') }}">{{ $appartements->wifi ?? '—' }}</span></div></div>
                <div class="feat-tile"><div class="ft-ico"><i class="fa fa-lock"></i></div><div class="ft-content"><span class="ft-lbl">Sécurité</span><span class="ft-val {{ $oui($appartements->securite??'')?'ft-yes':($non($appartements->securite??'')?'ft-no':'') }}">{{ $appartements->securite ?? '—' }}</span></div></div>
                <div class="feat-tile"><div class="ft-ico"><i class="fa fa-sun-o"></i></div><div class="ft-content"><span class="ft-lbl">Terrasse</span><span class="ft-val {{ $oui($appartements->terasse??'')?'ft-yes':($non($appartements->terasse??'')?'ft-no':'') }}">{{ $appartements->terasse ?? '—' }}</span></div></div>
                <div class="feat-tile"><div class="ft-ico"><i class="fa fa-cutlery"></i></div><div class="ft-content"><span class="ft-lbl">Cuisine équipée</span><span class="ft-val {{ $oui($appartements->cuisine??'')?'ft-yes':($non($appartements->cuisine??'')?'ft-no':'') }}">{{ $appartements->cuisine ?? '—' }}</span></div></div>
                <div class="feat-tile"><div class="ft-ico"><i class="fa fa-magic"></i></div><div class="ft-content"><span class="ft-lbl">Entretien inclus</span><span class="ft-val {{ $oui($appartements->entretien??'')?'ft-yes':($non($appartements->entretien??'')?'ft-no':'') }}">{{ $appartements->entretien ?? '—' }}</span></div></div>
            </div>

            {{-- === TERRAIN === --}}
            @elseif($isTerrain)

            <div class="ft-section"><i class="fa fa-info-circle"></i> Informations générales</div>
            <div class="feat-grid">
                <div class="feat-tile"><div class="ft-ico"><i class="fa fa-tag"></i></div><div class="ft-content"><span class="ft-lbl">Catégorie</span><span class="ft-val ft-am">{{ $catLabel }}</span></div></div>
                @if($val($appartements->negociable ?? ''))<div class="feat-tile"><div class="ft-ico"><i class="fa fa-money"></i></div><div class="ft-content"><span class="ft-lbl">Prix</span><span class="ft-val {{ $oui($appartements->negociable??'')?'ft-yes':'ft-no' }}">{{ $oui($appartements->negociable??'')?'Négociable':'Non négociable' }}</span></div></div>@endif
            </div>

            @if($hasTerrainDims)
            <div class="ft-section"><i class="fa fa-arrows-alt"></i> Dimensions du terrain</div>
            <div class="terrain-dims">
                @if($num($appartements->terrain_largeur??null))
                <div class="terrain-dim-card"><div class="tdc-ico">↔️</div><div class="tdc-lbl">Largeur</div><div class="tdc-val">{{ $appartements->terrain_largeur }}</div><div class="tdc-unit">mètres</div></div>
                @endif
                @if($num($appartements->terrain_longueur??null))
                <div class="terrain-dim-card"><div class="tdc-ico">↕️</div><div class="tdc-lbl">Longueur</div><div class="tdc-val">{{ $appartements->terrain_longueur }}</div><div class="tdc-unit">mètres</div></div>
                @endif
                @if($val($appartements->surface??''))
                <div class="terrain-dim-card" style="background:var(--gr-lt);border-color:var(--gr-b);"><div class="tdc-ico">📐</div><div class="tdc-lbl" style="color:var(--gr);">Superficie</div><div class="tdc-val" style="color:var(--gr);">{{ $appartements->surface }}</div><div class="tdc-unit">m²</div></div>
                @endif
            </div>
            @endif

            {{-- Remplace l'ancien bloc cloture / viabilise / constructible (colonnes
                 supprimées) par le titre foncier + le texte libre saisi par le propriétaire --}}
            @if($hasTerrainLegal)
            <div class="ft-section"><i class="fa fa-file-text-o"></i> Informations légales &amp; état</div>

            @if($val($appartements->titre_foncier??''))
            <div class="tf-badge" style="margin-bottom:14px;">
                <i class="fa fa-file-text-o"></i> Titre foncier : {{ $appartements->titre_foncier }}
            </div>
            @endif

            @if($val($appartements->autres_caracteristiques_terrain??''))
            <div class="desc-banner" style="margin-bottom:0;">
                <div class="desc-banner-ico"><i class="fa fa-map"></i></div>
                <p>{{ $appartements->autres_caracteristiques_terrain }}</p>
            </div>
            @endif
            @endif

            {{-- === BUREAUX === --}}
            @elseif($isBureau)

            <div class="ft-section"><i class="fa fa-info-circle"></i> Informations générales</div>
            <div class="feat-grid">
                <div class="feat-tile"><div class="ft-ico"><i class="fa fa-tag"></i></div><div class="ft-content"><span class="ft-lbl">Catégorie</span><span class="ft-val {{ ($appartements->categorie??'')==='louer'?'ft-yes':'ft-blue' }}">{{ $catLabel }}</span></div></div>
                @if($val($appartements->surface??''))<div class="feat-tile"><div class="ft-ico"><i class="fa fa-arrows-alt"></i></div><div class="ft-content"><span class="ft-lbl">Surface totale</span><span class="ft-val">{{ $appartements->surface }} m²</span></div></div>@endif
                @if($num($appartements->nombrePieces??null))<div class="feat-tile"><div class="ft-ico"><i class="fa fa-building-o"></i></div><div class="ft-content"><span class="ft-lbl">Pièces / Postes</span><span class="ft-val">{{ $appartements->nombrePieces }}</span></div></div>@endif
                @if($val($appartements->negociable??''))<div class="feat-tile"><div class="ft-ico"><i class="fa fa-money"></i></div><div class="ft-content"><span class="ft-lbl">Prix</span><span class="ft-val {{ $oui($appartements->negociable??'')?'ft-yes':'ft-no' }}">{{ $oui($appartements->negociable??'')?'Négociable':'Non négociable' }}</span></div></div>@endif
                @if($val($appartements->caution??'') && $appartements->caution !== '0')<div class="feat-tile"><div class="ft-ico"><i class="fa fa-shield"></i></div><div class="ft-content"><span class="ft-lbl">Caution</span><span class="ft-val">{{ $appartements->caution }}</span></div></div>@endif
            </div>

            {{-- "packing" et "sanitaire" portent déjà la valeur résolue côté contrôleur
                 pour ce type de bien — plus besoin de packing_bureaux / sanitaire_bureaux --}}
            <div class="ft-section"><i class="fa fa-briefcase"></i> Options &amp; Équipements bureau</div>
            <div class="feat-grid">
                <div class="feat-tile"><div class="ft-ico"><i class="fa fa-car"></i></div><div class="ft-content"><span class="ft-lbl">Parking</span><span class="ft-val {{ $oui($appartements->packing??'')?'ft-yes':'ft-no' }}">{{ $appartements->packing ?? '—' }}</span></div></div>
                <div class="feat-tile"><div class="ft-ico"><i class="fa fa-tint"></i></div><div class="ft-content"><span class="ft-lbl">Sanitaire / WC</span><span class="ft-val {{ $oui($appartements->sanitaire??'')?'ft-yes':'ft-no' }}">{{ $appartements->sanitaire ?? '—' }}</span></div></div>
                <div class="feat-tile"><div class="ft-ico"><i class="fa fa-snowflake"></i></div><div class="ft-content"><span class="ft-lbl">Climatiseur</span><span class="ft-val {{ $oui($appartements->clime??'')?'ft-yes':'ft-no' }}">{{ $appartements->clime ?? '—' }}</span></div></div>
                <div class="feat-tile"><div class="ft-ico"><i class="fa fa-circle-o-notch"></i></div><div class="ft-content"><span class="ft-lbl">Brasseur d'air</span><span class="ft-val {{ $oui($appartements->brasseur??'')?'ft-yes':'ft-no' }}">{{ $appartements->brasseur ?? '—' }}</span></div></div>
                <div class="feat-tile"><div class="ft-ico"><i class="fa fa-wifi"></i></div><div class="ft-content"><span class="ft-lbl">Wifi</span><span class="ft-val {{ $oui($appartements->wifi??'')?'ft-yes':'ft-no' }}">{{ $appartements->wifi ?? '—' }}</span></div></div>
                <div class="feat-tile"><div class="ft-ico"><i class="fa fa-lock"></i></div><div class="ft-content"><span class="ft-lbl">Sécurité</span><span class="ft-val {{ $oui($appartements->securite??'')?'ft-yes':'ft-no' }}">{{ $appartements->securite ?? '—' }}</span></div></div>
                <div class="feat-tile"><div class="ft-ico"><i class="fa fa-users"></i></div><div class="ft-content"><span class="ft-lbl">Salle de conf.</span><span class="ft-val {{ $oui($appartements->salle_conf??'')?'ft-yes':'ft-no' }}">{{ $appartements->salle_conf ?? '—' }}</span></div></div>
            </div>

            {{-- === BOUTIQUE === --}}
            @elseif($isBoutique)

            <div class="ft-section"><i class="fa fa-info-circle"></i> Informations générales</div>
            <div class="feat-grid">
                <div class="feat-tile"><div class="ft-ico"><i class="fa fa-tag"></i></div><div class="ft-content"><span class="ft-lbl">Catégorie</span><span class="ft-val {{ ($appartements->categorie??'')==='louer'?'ft-yes':'ft-blue' }}">{{ $catLabel }}</span></div></div>
                @if($val($appartements->surface??''))<div class="feat-tile"><div class="ft-ico"><i class="fa fa-arrows-alt"></i></div><div class="ft-content"><span class="ft-lbl">Surface</span><span class="ft-val">{{ $appartements->surface }} m²</span></div></div>@endif
                @if($val($appartements->negociable??''))<div class="feat-tile"><div class="ft-ico"><i class="fa fa-handshake-o"></i></div><div class="ft-content"><span class="ft-lbl">Prix</span><span class="ft-val {{ $oui($appartements->negociable??'')?'ft-yes':'ft-no' }}">{{ $oui($appartements->negociable??'')?'Négociable':'Non négociable' }}</span></div></div>@endif
                @if($val($appartements->caution??'') && $appartements->caution !== '0')<div class="feat-tile"><div class="ft-ico"><i class="fa fa-shield"></i></div><div class="ft-content"><span class="ft-lbl">Caution</span><span class="ft-val">{{ $appartements->caution }}</span></div></div>@endif
            </div>

            <div class="ft-section"><i class="fa fa-shopping-bag"></i> Équipements boutique</div>
            <div class="feat-grid">
                <div class="feat-tile"><div class="ft-ico"><i class="fa fa-snowflake-o"></i></div><div class="ft-content"><span class="ft-lbl">Climatiseur</span><span class="ft-val {{ $oui($appartements->clime??'')?'ft-yes':'ft-no' }}">{{ $appartements->clime ?? '—' }}</span></div></div>
                <div class="feat-tile"><div class="ft-ico"><i class="fa fa-circle-o-notch"></i></div><div class="ft-content"><span class="ft-lbl">Brasseur d'air</span><span class="ft-val {{ $oui($appartements->brasseur??'')?'ft-yes':'ft-no' }}">{{ $appartements->brasseur ?? '—' }}</span></div></div>
                <div class="feat-tile"><div class="ft-ico"><i class="fa fa-lock"></i></div><div class="ft-content"><span class="ft-lbl">Sécurité</span><span class="ft-val {{ $oui($appartements->securite??'')?'ft-yes':'ft-no' }}">{{ $appartements->securite ?? '—' }}</span></div></div>
                <div class="feat-tile"><div class="ft-ico"><i class="fa fa-car"></i></div><div class="ft-content"><span class="ft-lbl">Parking</span><span class="ft-val {{ $oui($appartements->packing??'')?'ft-yes':'ft-no' }}">{{ $appartements->packing ?? '—' }}</span></div></div>
                <div class="feat-tile"><div class="ft-ico"><i class="fa fa-eye"></i></div><div class="ft-content"><span class="ft-lbl">Vitrine</span><span class="ft-val {{ $oui($appartements->vitrine??'')?'ft-yes':'ft-no' }}">{{ $appartements->vitrine ?? '—' }}</span></div></div>
            </div>

            @endif

            {{-- Disponibilité — commun à tous sauf terrain --}}
            @if(!$isTerrain)
            <div class="ft-section"><i class="fa fa-calendar"></i> Disponibilité</div>
            <div class="feat-grid">
                <div class="feat-tile">
                    <div class="ft-ico"><i class="fa fa-calendar-check-o"></i></div>
                    <div class="ft-content">
                        <span class="ft-lbl">Disponible</span>
                        <span class="ft-val">
                            @if(!empty($appartements->disponible_date))
                                {{ \Carbon\Carbon::parse($appartements->disponible_date)->format('d/m/Y') }}
                            @else
                                <span style="color:var(--ink3)">Sur demande</span>
                            @endif
                        </span>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>

    {{-- ▌ COMPTEURS (Maison / Appartement / Bureaux / Boutique) --}}
    @if($hasCompteurs && !$isTerrain)
    <div class="dc">
        <div class="dc-head">
            <div class="dh-ico blue"><i class="fa fa-bolt"></i></div>
            <div><div class="dh-title">Compteurs &amp; Énergie</div><div class="dh-sub">Eau et électricité</div></div>
        </div>
        <div class="dc-body">
            <div class="cpt-grid">
                @if($val($appartements->compteur_eau??''))
                <div class="cpt-card eau"><div class="cpt-ico">💧</div><div class="cpt-lbl">Compteur eau</div><div class="cpt-val">{{ $appartements->compteur_eau }}</div></div>
                @endif
                @if($val($appartements->compteur_elec??''))
                <div class="cpt-card elec"><div class="cpt-ico">⚡</div><div class="cpt-lbl">Compteur électricité</div><div class="cpt-val">{{ $appartements->compteur_elec }}</div></div>
                @endif
            </div>
        </div>
    </div>
    @endif

    {{-- ▌ SURFACES PAR PIÈCE (Maison / Appartement) --}}
    @if($hasSurfaces)
    <div class="dc">
        <div class="dc-head">
            <div class="dh-ico gr"><i class="fa fa-arrows-alt"></i></div>
            <div><div class="dh-title">Surfaces par pièce</div><div class="dh-sub">Répartition détaillée en m²</div></div>
        </div>
        <div class="dc-body">
            @if($num($appartements->surface_salon??null))<div class="surf-bar"><div class="surf-bar-lbl"><i class="fa fa-television"></i> Salon</div><div class="surf-bar-val">{{ $appartements->surface_salon }} <small>m²</small></div></div>@endif
            @if($num($appartements->surface_cuisine??null))<div class="surf-bar"><div class="surf-bar-lbl"><i class="fa fa-cutlery"></i> Cuisine</div><div class="surf-bar-val">{{ $appartements->surface_cuisine }} <small>m²</small></div></div>@endif
            @if($num($appartements->surface_chambre??null))<div class="surf-bar"><div class="surf-bar-lbl"><i class="fa fa-bed"></i> Chambre(s)</div><div class="surf-bar-val">{{ $appartements->surface_chambre }} <small>m²/ch.</small></div></div>@endif
            @if($num($appartements->surface_sdb??null))<div class="surf-bar"><div class="surf-bar-lbl"><i class="fa fa-bath"></i> Salle de bain</div><div class="surf-bar-val">{{ $appartements->surface_sdb }} <small>m²</small></div></div>@endif
            @if($val($appartements->surface??''))
            <div class="surf-total-row"><span class="surf-total-lbl"><i class="fa fa-arrows-alt" style="margin-right:5px;"></i>Surface totale</span><span class="surf-total-val">{{ $appartements->surface }} m²</span></div>
            @endif
        </div>
    </div>
    @endif

    {{-- ▌ VIDÉO --}}
    @if(!empty($appartements->video))
    <div class="dc">
        <div class="dc-head">
            <div class="dh-ico blue"><i class="fa fa-video-camera"></i></div>
            <div><div class="dh-title">Vidéo de présentation</div><div class="dh-sub">Découvrez le bien en vidéo</div></div>
        </div>
        <div class="dc-body">
            <div class="vid-wrap">
                <span class="vid-pill"><i class="fa fa-play" style="margin-right:5px;"></i>Vidéo</span>
                <video controls preload="metadata"><source src="{{ URL::to($appartements->video) }}" type="video/mp4"></video>
            </div>
        </div>
    </div>
    @endif

    {{-- ▌ CARTE GPS --}}
    @if(!empty($appartements->latitude) && !empty($appartements->longitude))
    <div class="dc">
        <div class="dc-head">
            <div class="dh-ico blue"><i class="fa fa-map-o"></i></div>
            <div><div class="dh-title">Localisation GPS</div><div class="dh-sub">Position exacte du bien</div></div>
        </div>
        <div class="dc-body">
            <div class="map-frame">
                <iframe src="https://www.openstreetmap.org/export/embed.html?bbox={{ $appartements->longitude-0.005 }},{{ $appartements->latitude-0.005 }},{{ $appartements->longitude+0.005 }},{{ $appartements->latitude+0.005 }}&layer=mapnik&marker={{ $appartements->latitude }},{{ $appartements->longitude }}" allowfullscreen loading="lazy"></iframe>
            </div>
            <div class="map-chips">
                <div class="geo-chip"><i class="fa fa-crosshairs"></i> {{ $appartements->latitude }}</div>
                <div class="geo-chip"><i class="fa fa-crosshairs"></i> {{ $appartements->longitude }}</div>
                <a href="https://www.google.com/maps?q={{ $appartements->latitude }},{{ $appartements->longitude }}" target="_blank" rel="noopener" class="btn-gmaps"><i class="fa fa-external-link"></i> Google Maps</a>
            </div>
        </div>
    </div>
    @endif

    {{-- ▌ DESCRIPTION --}}
    <div class="dc">
        <div class="dc-head">
            <div class="dh-ico gr"><i class="fa fa-file-text-o"></i></div>
            <div><div class="dh-title">Description du bien</div><div class="dh-sub">Ce que le propriétaire dit de ce bien</div></div>
        </div>
        <div class="dc-body">
            <div class="desc-banner">
                <div class="desc-banner-ico"><i class="fa fa-home"></i></div>
                <p>
                    Bien situé à <strong>{{ $appartements->quartier }}</strong>, proposé à <strong>{{ number_format($appartements->prix??0,0,',',' ') }} FCFA</strong>
                    @if($val($appartements->surface??'')) — <strong>{{ $appartements->surface }} m²</strong>@endif.
                    @if($isMaison && $num($appartements->nombreChambre??null)) <strong>{{ $appartements->nombreChambre }} chambre(s)</strong>@if($num($appartements->nombreSalleBain??null)), <strong>{{ $appartements->nombreSalleBain }} sdb</strong>@endif.@endif
                    @if($isTerrain && $val($appartements->titre_foncier??'')) Titre : <strong>{{ $appartements->titre_foncier }}</strong>.@endif
                </p>
            </div>
            @if($val($appartements->description ?? $appartements->autres_caracteristiques_terrain ))
            <p class="desc-body">{{ $appartements->description ?? $appartements->autres_caracteristiques_terrain }}</p>
            @endif
        </div>
    </div>

    {{-- ▌ FORMULAIRE CONTACT — bouton qui ouvre la modale --}}
    <div class="dc">
        <div class="dc-head">
            <div class="dh-ico gr"><i class="fa fa-paper-plane"></i></div>
            <div><div class="dh-title">Envoyer un message</div></div>
        </div>
        <div class="dc-body">
            <div class="cta-send-box">
                <div class="cta-send-txt">
                    <div class="dh-title" style="font-size:13.5px;">Une question sur ce bien ?</div>
                    <p>Contactez directement le propriétaire via notre formulaire sécurisé.</p>
                </div>
                <button type="button" class="btn-open-modal" id="btnOpenContactModal">
                    <i class="fa fa-paper-plane"></i> Envoyer un message
                </button>
            </div>
        </div>
    </div>

</div>{{-- /dp-left --}}

{{-- ═══ COLONNE DROITE ═══ --}}
<div class="dp-right">

    <div class="dc ready" style="overflow:hidden;">
        <div class="sec-block">
            <div class="sec-head"><div class="sec-badge"><span class="sdot"></span> Important</div><div class="sec-title">Avant de contacter</div></div>
            <div class="sec-tips">
                <div class="sec-tip"><div class="sec-tip-ico"><i class="fa fa-eye"></i></div><div class="sec-tip-txt"><strong>Visitez avant tout paiement</strong><p>Visitez le bien physiquement avant tout paiement (frais, avance, caution).</p></div></div>
                <div class="sec-tip"><div class="sec-tip-ico"><i class="fa fa-ban"></i></div><div class="sec-tip-txt"><strong>Ne payez jamais à distance</strong><p>Méfiez-vous des offres alléchantes et des paiements sans visite.</p></div></div>
                <div class="sec-tip"><div class="sec-tip-ico"><i class="fa fa-users"></i></div><div class="sec-tip-txt"><strong>Lieu de rencontre sécurisé</strong><p>Rencontrez le propriétaire dans un lieu public et sécurisé.</p></div></div>
                <div class="sec-tip"><div class="sec-tip-ico"><i class="fa fa-file-text-o"></i></div><div class="sec-tip-txt"><strong>Vérifiez les documents</strong><p>Titre foncier, contrat — toujours vérifier avant de signer.</p></div></div>
            </div>
        </div>
        <div class="agent-top">
            <div class="agent-av-wrap">
                <img src="{{ asset('assets/img/client-face1.jpg') }}" class="agent-av" alt="{{ $appartements->entreprise?->entreprise ?? '' }}" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($appartements->entreprise?->entreprise ?? 'P') }}&background=16a34a&color=fff&size=80'">
                <span class="agent-online"></span>
            </div>
            <div class="agent-name">{{ $appartements->entreprise?->entreprise ?? 'Propriétaire' }}</div>
            <span class="agent-badge">Propriétaire vérifié</span>
        </div>
        <ul class="agent-contacts">
            <li><span class="ac-ico"><i class="fa fa-map-marker"></i></span>{{ $appartements->entreprise?->ville ?? '' }} / {{ $appartements->entreprise?->quatier ?? '' }}</li>
            <li><span class="ac-ico"><i class="fa fa-envelope"></i></span><span style="word-break:break-all;font-size:12px;">{{ $appartements->entreprise?->user?->email ?? '' }}</span></li>
            <li><span class="ac-ico"><i class="fa fa-phone"></i></span>{{ $appartements->entreprise?->telephone ?? '' }}</li>
        </ul>
        <div class="agent-cta">
            <p class="cta-note">Intéressé(e) ? Contactez le propriétaire pour une visite.</p>
            <a href="tel:{{ $appartements->entreprise?->telephone ?? '' }}" class="btn-call"><i class="fa fa-phone"></i> Appeler maintenant</a>
            <a href="https://api.whatsapp.com/send?phone={{ $appartements->entreprise?->telephone ?? '' }}&text=Bonjour%2C+je+suis+int%C3%A9ress%C3%A9(e)+par+votre+bien+%C3%A0+{{ urlencode($appartements->quartier ?? '') }}" target="_blank" rel="noopener" class="btn-wa"><i class="fa fa-whatsapp"></i> WhatsApp</a>
        </div>
    </div>

    <div class="dc ready">
        <div class="dc-head">
            <div class="dh-ico gr"><i class="fa fa-th-large"></i></div>
            <div><div class="dh-title">Annonces similaires</div><div class="dh-sub">Faites défiler pour voir plus</div></div>
        </div>
        @if($appartementSimilaires->count() > 0)
        <div style="padding:10px 14px 14px;">
            <div class="sim-list">
                @foreach($appartementSimilaires as $sim)
                @php $sImgs=array_values(array_filter(explode('|',$sim->images??''))); $sIsLoc=($sim->categorie??'')==='louer'; @endphp
                <a href="{{ route('appartement.detail', $sim->id) }}" class="sim-card">
                    <div class="sim-card-img">
                        @if(count($sImgs)>0)<img src="{{ URL::to($sImgs[0]) }}" alt="{{ $sim->quartier }}" loading="lazy">
                        @else<div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:var(--bg2);"><i class="fa fa-home" style="font-size:22px;color:var(--ink3);"></i></div>@endif
                        <span class="sim-badge {{ $sIsLoc?'louer':'vendre' }}">{{ $sIsLoc?'À louer':'À vendre' }}</span>
                    </div>
                    <div class="sim-body">
                        <div class="sim-loc"><i class="fa fa-map-marker"></i><span>{{ Str::limit($sim->quartier??'',22) }}</span></div>
                        <div class="sim-type">{{ $sim->type }}</div>
                        <div class="sim-price">{{ number_format($sim->prix??0,0,',',' ') }} <small style="font-size:9px;font-weight:600;color:var(--ink3);">FCFA</small></div>
                        <div class="sim-arrow">Voir le bien <i class="fa fa-arrow-right"></i></div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @else<div class="sim-empty">Aucune annonce similaire disponible.</div>@endif
    </div>

</div>{{-- /dp-right --}}
</div>{{-- /dp-row --}}
</div>{{-- /container --}}
</div>{{-- /dp --}}

<script>
(function () {
'use strict';

/* ═══════════════════════════════════════════
   ÉTAT PARTAGÉ — déclaré en haut pour éviter
   toute confusion liée au hoisting des "var"
═══════════════════════════════════════════ */
var slides    = Array.prototype.slice.call(document.querySelectorAll('.hero-slide'));
var thumbs    = Array.prototype.slice.call(document.querySelectorAll('.ht'));
var dots      = Array.prototype.slice.call(document.querySelectorAll('.hero-dot'));
var total     = slides.length;
var curIdx    = 0;
var autoTimer = null;
var inTrans   = false;
var imgSrcs   = slides.map(function(s){ return s.getAttribute('data-src'); });

var lbx     = document.getElementById('lbx');
var lbxImg  = document.getElementById('lbxImg');
var lbxCtr  = document.getElementById('lbxCtr');
var lbxOpen = false;
var lbxIdx  = 0;

/* ═══════════════════════════════════════════
   CAROUSEL — ZÉRO SCROLL, ZÉRO REFLOW
   Toutes les slides sont position:absolute,
   la hauteur du hero est fixée en CSS (contain:strict)
═══════════════════════════════════════════ */
/* Scroll HORIZONTAL uniquement, limité au conteneur des miniatures.
   On évite volontairement Element.scrollIntoView() : cette API agit sur
   TOUS les ancêtres scrollables, y compris la fenêtre — comme .hero-thumbs
   se trouve tout en haut de la page, cela provoquait un retour en haut
   de la page à chaque changement de slide (auto ou manuel). */
var heroThumbs = document.getElementById('heroThumbs');
function scrollThumbIntoView(thumb) {
    if (!heroThumbs || !thumb) return;
    var containerWidth = heroThumbs.clientWidth;
    var currentScroll  = heroThumbs.scrollLeft;
    var thumbLeft       = thumb.offsetLeft;
    var thumbRight       = thumbLeft + thumb.offsetWidth;
    var target = currentScroll;
    if (thumbLeft < currentScroll) {
        target = thumbLeft - 8;
    } else if (thumbRight > currentScroll + containerWidth) {
        target = thumbRight - containerWidth + 8;
    } else {
        return; // déjà visible, rien à faire
    }
    if (typeof heroThumbs.scrollTo === 'function') {
        heroThumbs.scrollTo({ left: target, behavior: 'smooth' });
    } else {
        heroThumbs.scrollLeft = target; // fallback navigateurs anciens
    }
}

function goSlide(n, noThumbScroll) {
    if (total <= 1) return;
    n = ((n % total) + total) % total;
    if (n === curIdx || inTrans) return;
    inTrans = true;
    slides[curIdx].classList.remove('active');
    if (thumbs[curIdx]) thumbs[curIdx].classList.remove('active');
    if (dots[curIdx])   dots[curIdx].classList.remove('active');
    curIdx = n;
    slides[curIdx].classList.add('active');
    if (thumbs[curIdx]) {
        thumbs[curIdx].classList.add('active');
        if (!noThumbScroll) {
            scrollThumbIntoView(thumbs[curIdx]);
        }
    }
    if (dots[curIdx]) dots[curIdx].classList.add('active');
    setTimeout(function(){ inTrans = false; }, 560);
}

var bPrev = document.getElementById('heroPrev');
var bNext = document.getElementById('heroNext');
function onArrow(e, dir) {
    e.preventDefault();
    e.stopPropagation();
    stopAuto();
    goSlide(curIdx + dir);
    startAuto();
}
if (bPrev) bPrev.addEventListener('click', function(e){ onArrow(e,-1); });
if (bNext) bNext.addEventListener('click', function(e){ onArrow(e, 1); });

thumbs.forEach(function(t){
    t.addEventListener('click', function(e){
        e.preventDefault(); e.stopPropagation();
        stopAuto(); goSlide(parseInt(t.getAttribute('data-index'),10), true); startAuto();
    });
    t.addEventListener('keydown', function(e){
        if (e.key==='Enter'||e.key===' '){ e.preventDefault(); stopAuto(); goSlide(parseInt(t.getAttribute('data-index'),10), true); startAuto(); }
    });
});
dots.forEach(function(d){
    d.addEventListener('click', function(e){
        e.preventDefault(); e.stopPropagation();
        stopAuto(); goSlide(parseInt(d.getAttribute('data-index'),10)); startAuto();
    });
});

/* Swipe tactile — passive:true pour ne jamais bloquer le scroll vertical */
var txS=0, tyS=0, swipe=false;
var hs = document.getElementById('heroSlides');
if (hs) {
    hs.addEventListener('touchstart', function(e){ txS=e.touches[0].clientX; tyS=e.touches[0].clientY; swipe=false; }, { passive:true });
    hs.addEventListener('touchmove',  function(e){
        var dx=Math.abs(e.touches[0].clientX-txS), dy=Math.abs(e.touches[0].clientY-tyS);
        if (!swipe && dx>8 && dx>dy) swipe=true;
    }, { passive:true });
    hs.addEventListener('touchend', function(e){
        if (!swipe) return;
        var dx = e.changedTouches[0].clientX - txS;
        if (Math.abs(dx)>38){ stopAuto(); goSlide(dx<0?curIdx+1:curIdx-1); startAuto(); }
        swipe=false;
    }, { passive:true });
}

function startAuto(){ if(total<=1) return; stopAuto(); autoTimer=setInterval(function(){ goSlide(curIdx+1); },5200); }
function stopAuto() { clearInterval(autoTimer); autoTimer=null; }

var ho = document.getElementById('heroOuter');
if (ho) {
    ho.addEventListener('mouseenter', stopAuto);
    ho.addEventListener('mouseleave', startAuto);
}
startAuto();

/* Clavier global (carousel) — ignoré quand la lightbox est ouverte
   ou quand le focus est dans un champ de saisie */
document.addEventListener('keydown', function(e){
    if (e.target.tagName==='INPUT'||e.target.tagName==='TEXTAREA') return;
    if (lbxOpen) return;
    if (e.key==='ArrowLeft')  { stopAuto(); goSlide(curIdx-1); startAuto(); }
    if (e.key==='ArrowRight') { stopAuto(); goSlide(curIdx+1); startAuto(); }
});

/* ═══════════════════════════════════════════
   LIGHTBOX
   Gardes ajoutées : total===0 (annonce sans
   photo) ne doit jamais déclencher d'ouverture
═══════════════════════════════════════════ */
function openLbx(idx){
    if (total === 0) return;
    stopAuto();
    lbxIdx = ((idx % total) + total) % total;
    if (!imgSrcs[lbxIdx]) return; // pas d'image réelle (placeholder) → on ignore
    lbxImg.src = imgSrcs[lbxIdx];
    if (lbxCtr) lbxCtr.textContent = (lbxIdx+1)+' / '+total;
    lbx.classList.add('open');
    lbxOpen = true;
    document.body.style.overflow = 'hidden';
}
function closeLbx(){
    lbx.classList.remove('open');
    lbxOpen = false;
    document.body.style.overflow = '';
    startAuto();
}
function lbxNav(dir){
    if (total === 0) return;
    lbxIdx = ((lbxIdx + dir + total) % total);
    if (!imgSrcs[lbxIdx]) return;
    lbxImg.style.opacity = '0';
    setTimeout(function(){
        lbxImg.src = imgSrcs[lbxIdx];
        lbxImg.style.opacity = '1';
        if (lbxCtr) lbxCtr.textContent = (lbxIdx+1)+' / '+total;
    }, 120);
}

/* Seules les slides qui possèdent réellement une photo (data-src) ouvrent la lightbox.
   Le slide "placeholder" (annonce sans photo) n'a pas de data-src donc reste inerte. */
slides.forEach(function(s){
    if (!s.getAttribute('data-src')) return;
    s.addEventListener('click', function(){ openLbx(parseInt(s.getAttribute('data-index'),10)); });
});

var lbxClose=document.getElementById('lbxClose');
var lbxPrev =document.getElementById('lbxPrev');
var lbxNext =document.getElementById('lbxNext');
if(lbxClose) lbxClose.addEventListener('click', closeLbx);
if(lbx)      lbx.addEventListener('click', function(e){ if(e.target===lbx) closeLbx(); });
if(lbxPrev)  lbxPrev.addEventListener('click', function(e){ e.stopPropagation(); lbxNav(-1); });
if(lbxNext)  lbxNext.addEventListener('click', function(e){ e.stopPropagation(); lbxNav(1); });

var lbxW=document.getElementById('lbxImgWrap'), ltxS=0;
if(lbxW){
    lbxW.addEventListener('touchstart', function(e){ ltxS=e.touches[0].clientX; }, { passive:true });
    lbxW.addEventListener('touchend',   function(e){ var dx=e.changedTouches[0].clientX-ltxS; if(Math.abs(dx)>42) lbxNav(dx<0?1:-1); }, { passive:true });
}

document.addEventListener('keydown', function(e){
    if(!lbxOpen) return;
    if(e.key==='ArrowLeft') lbxNav(-1);
    if(e.key==='ArrowRight') lbxNav(1);
    if(e.key==='Escape') closeLbx();
});

/* ═══════════════════════════════════════════
   SCROLL REVEAL
═══════════════════════════════════════════ */
var dcEls = document.querySelectorAll('.dc:not(.ready)');
if ('IntersectionObserver' in window) {
    var obs = new IntersectionObserver(function(entries){
        entries.forEach(function(e){ if(e.isIntersecting){ e.target.classList.add('vis'); obs.unobserve(e.target); } });
    }, { threshold:.06 });
    dcEls.forEach(function(el){ obs.observe(el); });
} else { dcEls.forEach(function(el){ el.classList.add('vis'); }); }

/* ═══════════════════════════════════════════
   FORM LOADER
═══════════════════════════════════════════ */
var cForm = document.getElementById('cForm');
var bSend = document.getElementById('btnSend');
if (cForm && bSend) {
    cForm.addEventListener('submit', function(){
        bSend.disabled = true;
        bSend.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Envoi en cours…';
    });
}

/* ═══════════════════════════════════════════
   MODALE CONTACT — ouverture / fermeture
═══════════════════════════════════════════ */
var cModal      = document.getElementById('contactModal');
var btnOpenCM   = document.getElementById('btnOpenContactModal');
var btnCloseCM  = document.getElementById('cmodalClose');

function openContactModal() {
    if (!cModal) return;
    cModal.classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeContactModal() {
    if (!cModal) return;
    cModal.classList.remove('open');
    document.body.style.overflow = '';
}

if (btnOpenCM)  btnOpenCM.addEventListener('click', openContactModal);
if (btnCloseCM) btnCloseCM.addEventListener('click', closeContactModal);
if (cModal) {
    cModal.addEventListener('click', function (e) {
        if (e.target === cModal) closeContactModal();
    });
}
document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && cModal && cModal.classList.contains('open')) {
        closeContactModal();
    }
});

/* Si le formulaire revient avec des erreurs de validation (redirect back()),
   Laravel réaffiche la page avec les erreurs déjà présentes dans le HTML :
   on rouvre alors la modale automatiquement pour que l'utilisateur les voie. */
@if ($errors->has('nom') || $errors->has('email') || $errors->has('telephone') || $errors->has('message'))
openContactModal();
@endif

})();
</script>

@endsection