
@extends('layouts.master')

@section('content')
    <style>
        :root {
            --gr:      #16a34a;
            --gr-dk:   #15803d;
            --gr-lt:   #f0fdf4;
            --gr-b:    #bbf7d0;
            --gr-mid:  #86efac;
            --gr-glow: rgba(22,163,74,.12);

            --blue:    #2563eb; --blue-lt: #eff6ff; --blue-b: #bfdbfe;
            --red:     #dc2626; --red-lt:  #fff1f2;
            --amber:   #d97706;

            --bg:      #F4F6F9;
            --bg2:     #ECEEF4;
            --white:   #FFFFFF;
            --card:    #FFFFFF;
            --ink:     #111827;
            --ink2:    #374151;
            --ink3:    #6B7280;
            --bord:    rgba(17,24,39,.09);
            --bord2:   rgba(17,24,39,.05);

            --side-bg:          #F8FAF8;
            --side-bord:        #E5E7EB;
            --side-muted:       #9CA3AF;
            --side-active-bg:   #F0FDF4;
            --side-active-bord: #16a34a;

            --r:    10px;
            --r-lg: 16px;
            --r-xl: 22px;
            --sh:    0 1px 4px rgba(17,24,39,.04), 0 4px 14px rgba(17,24,39,.05);
            --sh-md: 0 4px 8px rgba(17,24,39,.05), 0 12px 32px rgba(17,24,39,.08);
            --ease:  cubic-bezier(.16,1,.3,1);
        }
        *{box-sizing:border-box;margin:0;padding:0;}
        body{font-family:sans-serif;background:var(--bg);color:var(--ink);-webkit-font-smoothing:antialiased;}

        /* ══ LAYOUT ══ */
        .sl-wrap{display:flex;min-height:calc(100vh - 72px);}

        /* ══ SIDEBAR ══ */
        .sl-side{
            width:240px;flex-shrink:0;
            background:var(--side-bg);border-right:1px solid var(--side-bord);
            padding:26px 0 40px;
            position:sticky;
            top:72px;
            height:calc(100vh - 72px);
            overflow-y:auto;
            align-self:flex-start;
        }
        .sl-side::-webkit-scrollbar{width:3px;}
        .sl-side::-webkit-scrollbar-thumb{background:#D1D5DB;border-radius:2px;}
        .sl-side-ttl{font-size:10px;font-weight:800;color:var(--side-muted);text-transform:uppercase;letter-spacing:.14em;padding:0 22px;margin-bottom:20px;}
        .sl-list{list-style:none;position:relative;}
        .sl-list::before{content:'';position:absolute;left:34px;top:20px;bottom:20px;width:1.5px;background:var(--bord2);z-index:0;}
        .sl-item{display:flex;align-items:center;gap:11px;padding:9px 20px;cursor:pointer;position:relative;z-index:1;border-left:3px solid transparent;transition:background .15s;}
        .sl-item:hover{background:rgba(22,163,74,.04);}
        .sl-item.active{background:var(--side-active-bg);border-left-color:var(--side-active-bord);}
        .si-dot{width:24px;height:24px;border-radius:50%;flex-shrink:0;border:2px solid var(--bord2);background:var(--white);display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:700;color:var(--ink3);position:relative;z-index:2;transition:all .25s;}
        .sl-item.active .si-dot{background:var(--gr);border-color:var(--gr);color:#fff;box-shadow:0 0 0 3px var(--gr-glow);}
        .sl-item.done .si-dot{background:var(--gr-lt);border-color:var(--gr-b);color:var(--gr);}
        .sl-item.done .si-dot::after{content:'\f00c';font-family:'FontAwesome';font-size:9px;}
        .sl-item.done .si-num{display:none;}
        .si-txt{flex:1;}
        .si-name{font-size:12.5px;font-weight:600;color:var(--ink2);display:block;transition:color .15s;}
        .sl-item.active .si-name{color:var(--gr-dk);font-weight:700;}
        .sl-item.done .si-name{color:var(--gr-dk);}
        .si-st{font-size:10px;color:var(--side-muted);display:block;margin-top:1px;}
        .sl-item.active .si-st{color:var(--gr);font-weight:500;}
        .sl-item.done .si-st{color:var(--gr-mid);}
        /* Étape masquée (terrain) */
        .sl-item.skipped{opacity:.35;pointer-events:none;}
        .sl-item.skipped .si-st{color:var(--side-muted);}

        /* ══ MAIN ══ */
        .sl-main{flex:1;padding:28px 36px 72px;max-width:800px;min-width:0;}
        .sp-lbl{font-size:11px;font-weight:700;color:var(--ink3);display:block;margin-bottom:5px;letter-spacing:.04em;text-transform:uppercase;}
        .sp-title{font-size:22px;font-weight:800;color:var(--ink);margin:0 0 3px;letter-spacing:-.02em;line-height:1.2;}
        .sp-sub{font-size:12px;color:var(--ink3);margin:0 0 22px;}
        .sp-sub i{color:var(--gr);font-size:8px;margin-right:3px;}
        .sl-pane{display:none;animation:pIn .28s cubic-bezier(.16,1,.3,1);}
        .sl-pane.active{display:block;}
        @keyframes pIn{from{opacity:0;transform:translateY(10px);}to{opacity:1;transform:none;}}

        /* ══ HERO CAROUSEL ══ */
        .hero-carousel{
            width:100%;height:300px;
            border-radius:var(--r-xl);overflow:hidden;
            position:relative;margin-bottom:26px;
            background:transparent;
        }
        .hero-slide{position:absolute;inset:0;opacity:0;transition:opacity .7s ease;display:flex;align-items:center;justify-content:center;background:transparent;}
        .hero-slide.visible{opacity:1;}
        .hero-slide img{width:100%;height:100%;object-fit:contain;display:block;}
        .hero-dots{position:absolute;bottom:10px;left:50%;transform:translateX(-50%);display:flex;gap:6px;z-index:4;}
        .hero-dot{width:6px;height:6px;border-radius:50%;background:rgba(22,163,74,.25);cursor:pointer;transition:all .3s;border:none;padding:0;}
        .hero-dot.active{width:20px;border-radius:3px;background:var(--gr);}

        /* ══ SECTION BOX ══ */
        .s-box{background:var(--white);border:1px solid var(--bord);border-radius:var(--r-xl);padding:20px 22px;margin-bottom:14px;transition:border-color .2s,box-shadow .2s;box-shadow:var(--sh);}
        .s-box:focus-within{border-color:var(--gr-b);box-shadow:0 0 0 3px var(--gr-glow);}
        .s-box-title{font-size:10.5px;font-weight:800;color:var(--ink);text-transform:uppercase;letter-spacing:.1em;margin-bottom:16px;display:flex;align-items:center;gap:7px;}
        .s-box-title .bt-ico{width:24px;height:24px;border-radius:7px;background:var(--gr-lt);color:var(--gr);display:inline-flex;align-items:center;justify-content:center;font-size:10px;flex-shrink:0;border:1px solid var(--gr-b);}
        .s-box-title::after{content:'';flex:1;height:1px;background:var(--bord2);margin-left:7px;}

        /* ══ OPTION CARDS ══ */
        .oc-row{display:flex;gap:7px;flex-wrap:wrap;}
        .oc{flex:1;min-width:80px;max-width:150px;border-radius:var(--r-lg);border:1.5px solid var(--bord);background:var(--white);padding:12px 6px 10px;text-align:center;cursor:pointer;position:relative;transition:all .2s;}
        .oc:hover{border-color:var(--gr-mid);transform:translateY(-1px);}
        .oc.s{border-color:var(--gr);background:var(--gr-lt);box-shadow:0 0 0 1px var(--gr);}
        .oc input{display:none;}
        .oc i{font-size:18px;color:var(--ink3);display:block;margin-bottom:6px;transition:color .2s;}
        .oc.s i{color:var(--gr);}
        .oc span{font-size:11px;font-weight:700;color:var(--ink2);display:block;line-height:1.3;}
        .oc .oc-short{display:none;font-size:11px;font-weight:700;color:var(--ink2);}
        .oc.s span{color:var(--gr-dk);}
        .oc-tick{position:absolute;top:6px;right:6px;width:14px;height:14px;border-radius:4px;border:1.5px solid var(--bord2);background:var(--white);transition:all .18s;}
        .oc.s .oc-tick{background:var(--gr);border-color:var(--gr);}
        .oc.s .oc-tick::after{content:'\f00c';font-family:'FontAwesome';font-size:7px;color:#fff;display:block;text-align:center;line-height:11px;}

        /* ══ FORM FIELDS ══ */
        .fg{margin-bottom:0;}
        .fg + .fg{margin-top:14px;}
        .fg label{display:block;font-size:12px;font-weight:600;color:var(--ink2);margin-bottom:5px;}
        .fg .f-hint{font-size:11px;color:var(--ink3);margin-bottom:5px;display:block;}
        .fg input[type="text"],
        .fg input[type="number"],
        .fg input[type="date"],
        .fg select,
        .fg textarea{
            display:block;width:100%;padding:10px 14px;border-radius:var(--r);
            border:1.5px solid var(--bord);background:#FAFBFC;
            font-size:13px;font-family:sans-serif;color:var(--ink);
            outline:none;-webkit-appearance:none;
            transition:border-color .2s,background .2s,box-shadow .2s;
        }
        .fg input:focus,.fg select:focus,.fg textarea:focus{border-color:var(--gr);background:var(--white);box-shadow:0 0 0 3px var(--gr-glow);}
        .fg textarea{min-height:120px;resize:vertical;}
        .fg .ferr{font-size:11px;color:var(--red);margin-top:4px;display:none;}
        .fg.err input,.fg.err select{border-color:var(--red);}
        .fg.err .ferr{display:block;}
        .fi{position:relative;}
        .fi input{padding-right:52px;}
        .fi-sfx{position:absolute;top:50%;right:12px;transform:translateY(-50%);font-size:12px;font-weight:700;color:var(--ink3);}

        /* ══ SURFACE GRID ══ */
        .surface-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(125px,1fr));gap:9px;margin-bottom:14px;}
        .surf-card{background:#FAFBFC;border:1.5px solid var(--bord);border-radius:var(--r-lg);padding:12px 13px;transition:border-color .2s,background .2s;}
        .surf-card:focus-within{border-color:var(--gr);background:var(--white);}
        .surf-card-lbl{font-size:9.5px;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:var(--ink3);margin-bottom:6px;display:flex;align-items:center;gap:4px;}
        .surf-card-lbl i{font-size:10px;color:var(--gr);}
        .surf-card input[type="number"]{width:100%;border:none;background:transparent;font-size:16px;font-weight:800;color:var(--ink);outline:none;padding:0;-webkit-appearance:none;}
        .surf-card input[type="number"]::placeholder{color:#D1D5DB;}
        .surf-card-unit{font-size:10px;font-weight:600;color:var(--ink3);margin-top:2px;}

        /* ══ COMPTEURS +/- ══ */
        .ctr{display:inline-flex;align-items:center;border:1.5px solid var(--bord);border-radius:var(--r);overflow:hidden;background:#FAFBFC;}
        .cb{width:36px;height:40px;border:none;background:none;font-size:17px;font-weight:300;color:var(--ink2);cursor:pointer;display:flex;align-items:center;justify-content:center;transition:background .15s,color .15s;}
        .cb:hover:not(:disabled){background:var(--gr-lt);color:var(--gr);}
        .cb:disabled{opacity:.25;cursor:not-allowed;}
        .cv{width:44px;text-align:center;border:none;border-left:1px solid var(--bord);border-right:1px solid var(--bord);background:none;font-size:14px;font-weight:700;color:var(--ink);padding:0;height:40px;-webkit-appearance:none;outline:none;}

        /* ══ PIÈCES GRID ══ */
        .pieces-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(125px,1fr));gap:9px;margin-bottom:12px;}
        .piece-card{background:#FAFBFC;border:1.5px solid var(--bord);border-radius:var(--r-lg);padding:12px 9px;text-align:center;transition:border-color .2s,background .2s;}
        .piece-card.has-value{border-color:var(--gr-b);background:var(--gr-lt);}
        .piece-card-ico{width:28px;height:28px;border-radius:8px;background:var(--gr-lt);display:flex;align-items:center;justify-content:center;font-size:12px;color:var(--gr);margin:0 auto 6px;border:1px solid var(--gr-b);}
        .piece-card.has-value .piece-card-ico{background:rgba(22,163,74,.15);}
        .piece-card-lbl{font-size:10px;font-weight:600;color:var(--ink3);margin-bottom:6px;}
        .piece-card.has-value .piece-card-lbl{color:var(--gr-dk);}
        .piece-card .ctr{margin:0 auto;}
        .pieces-total-badge{display:inline-flex;align-items:center;gap:6px;background:var(--gr-lt);border:1.5px solid var(--gr-b);border-radius:8px;padding:6px 12px;margin-top:9px;font-size:12px;font-weight:700;color:var(--gr-dk);}

        /* ══ COMPTEURS EAU/ELEC ══ */
        .compteur-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(145px,1fr));gap:7px;margin-top:9px;}
        .compt-opt{border:1.5px solid var(--bord);border-radius:var(--r-lg);padding:12px 13px;cursor:pointer;transition:all .2s;display:flex;align-items:center;gap:8px;background:var(--white);user-select:none;}
        .compt-opt:hover{border-color:var(--gr-mid);}
        .compt-opt.s{border-color:var(--gr);box-shadow:0 0 0 1px var(--gr);background:var(--gr-lt);}
        .compt-opt input{display:none;}
        .compt-opt-ico{width:30px;height:30px;border-radius:7px;display:flex;align-items:center;justify-content:center;font-size:12px;flex-shrink:0;background:var(--gr-lt);color:var(--gr);transition:background .2s,color .2s;border:1px solid var(--gr-b);}
        .compt-opt.s .compt-opt-ico{background:var(--gr);color:#fff;border-color:var(--gr);}
        .compt-opt-txt{flex:1;}
        .compt-opt-name{font-size:11.5px;font-weight:700;color:var(--ink2);display:block;}
        .compt-opt.s .compt-opt-name{color:var(--gr-dk);}
        .compt-opt-sub{font-size:10px;color:var(--ink3);}
        .compt-tick{width:14px;height:14px;border-radius:4px;border:1.5px solid var(--bord2);flex-shrink:0;transition:all .18s;}
        .compt-opt.s .compt-tick{background:var(--gr);border-color:var(--gr);}
        .compt-opt.s .compt-tick::after{content:'\f00c';font-family:'FontAwesome';font-size:7px;color:#fff;display:block;text-align:center;line-height:11px;}

        /* ══ OUI / NON ══ */
        .yn{display:flex;gap:6px;flex-wrap:wrap;}
        .yn-b{padding:8px 20px;border-radius:28px;border:1.5px solid var(--bord);background:var(--white);font-size:12.5px;font-weight:700;color:var(--ink2);cursor:pointer;transition:all .2s;font-family:'Sora',sans-serif;}
        .yn-b:hover{border-color:var(--gr-mid);}
        .yn-b.s{background:var(--gr);border-color:var(--gr);color:#fff;}

        /* ══ ÉQUIPEMENTS ══ */
        .eq-row{display:flex;gap:7px;flex-wrap:wrap;}
        .eq{min-width:105px;border-radius:var(--r-lg);border:1.5px solid var(--bord);background:var(--white);padding:12px 9px 10px;text-align:center;cursor:pointer;position:relative;transition:all .2s;}
        .eq:hover{border-color:var(--gr-mid);transform:translateY(-1px);}
        .eq.s{border-color:var(--gr);background:var(--gr-lt);box-shadow:0 0 0 1px var(--gr);}
        .eq input{display:none;}
        .eq i{font-size:18px;color:var(--ink3);display:block;margin-bottom:6px;transition:color .2s;}
        .eq.s i{color:var(--gr);}
        .eq span{font-size:11px;font-weight:600;color:var(--ink2);display:block;}
        .eq.s span{color:var(--gr-dk);}
        .eq-tick{position:absolute;top:6px;right:6px;width:14px;height:14px;border-radius:4px;border:1.5px solid var(--bord2);background:var(--white);}
        .eq.s .eq-tick{background:var(--gr);border-color:var(--gr);}
        .eq.s .eq-tick::after{content:'\f00c';font-family:'FontAwesome';font-size:7px;color:#fff;display:block;text-align:center;line-height:11px;}

        /* ══ GÉOLOCALISATION ══ */
        .geo-box{background:var(--blue-lt);border:1.5px solid rgba(27,94,190,.12);border-radius:var(--r-lg);padding:14px 16px;margin-top:12px;}
        .geo-box-title{font-size:11.5px;font-weight:700;color:var(--blue);display:flex;align-items:center;gap:6px;margin-bottom:11px;}
        .geo-coords{display:flex;gap:9px;flex-wrap:wrap;}
        .geo-coords .fg{flex:1;min-width:110px;margin-top:0;}
        .btn-geo{display:inline-flex;align-items:center;gap:7px;padding:9px 16px;border-radius:9px;border:2px solid var(--blue);background:var(--blue);color:#fff;font-size:12px;font-weight:700;font-family:sans-serif;cursor:pointer;transition:all .2s;}
        .btn-geo:hover{background:#1348A0;}
        .btn-geo:disabled{opacity:.5;cursor:not-allowed;}
        .geo-status{font-size:11.5px;font-weight:600;display:flex;align-items:center;gap:6px;margin-top:7px;}
        .geo-status.ok{color:var(--gr);}
        .geo-status.err{color:var(--red);}
        .geo-status.loading{color:var(--blue);}

        /* ══ UPLOAD ══ */
        .upz{border:2px dashed var(--bord);border-radius:var(--r-xl);background:#FAFBFC;padding:36px 20px;text-align:center;cursor:pointer;transition:border-color .2s,background .2s;}
        .upz:hover,.upz.dz{border-color:var(--gr);background:var(--gr-lt);}
        .upz i{font-size:30px;color:var(--ink3);display:block;margin-bottom:9px;}
        .upz:hover i,.upz.dz i{color:var(--gr);}
        .upz p{font-size:13px;font-weight:600;color:var(--ink2);margin:0 0 3px;}
        .upz small{font-size:11px;color:var(--ink3);}
        .prev-g{display:flex;gap:8px;flex-wrap:wrap;margin-top:12px;}
        .pv{width:80px;height:80px;border-radius:9px;overflow:hidden;position:relative;border:1.5px solid var(--bord);}
        .pv img{width:100%;height:100%;object-fit:cover;display:block;}
        .pv-del{position:absolute;top:3px;right:3px;width:18px;height:18px;border-radius:50%;background:rgba(20,21,25,.75);color:#fff;border:none;font-size:9px;cursor:pointer;display:flex;align-items:center;justify-content:center;}
        .vid-upz{border:2px dashed rgba(27,94,190,.2);border-radius:var(--r-xl);background:var(--blue-lt);padding:26px 20px;text-align:center;cursor:pointer;transition:border-color .2s;margin-top:12px;}
        .vid-upz:hover,.vid-upz.dz{border-color:var(--blue);}
        .vid-upz i{font-size:26px;color:var(--blue);display:block;margin-bottom:8px;}
        .vid-upz p{font-size:13px;font-weight:600;color:var(--blue);margin:0 0 3px;}
        .vid-upz small{font-size:11px;color:#3b82f6;}
        .vid-preview{margin-top:11px;display:none;}
        .vid-preview video{width:100%;max-height:180px;border-radius:11px;border:1.5px solid var(--bord);}
        .vid-info{display:flex;align-items:center;justify-content:space-between;margin-top:6px;font-size:11.5px;color:var(--ink3);}
        .vid-del{background:none;border:none;color:var(--red);font-size:11.5px;font-weight:700;cursor:pointer;padding:4px 9px;border-radius:7px;border:1.5px solid rgba(201,48,48,.18);font-family:sans-serif;}

        /* ══ RÉCAPITULATIF ══ */
        .rc-blk{background:var(--white);border:1px solid var(--bord);border-radius:var(--r-xl);margin-bottom:12px;overflow:hidden;box-shadow:var(--sh);}
        .rc-hd{padding:11px 18px;border-bottom:1px solid var(--bord2);display:flex;align-items:center;gap:8px;background:var(--gr-lt);}
        .rc-hd i{color:var(--gr);font-size:12px;}
        .rc-hd span{font-size:12.5px;font-weight:700;color:var(--gr-dk);}
        .rc-bd{padding:10px 18px;}
        .rc-row{display:flex;justify-content:space-between;align-items:center;padding:6px 0;border-bottom:1px dashed var(--bord2);font-size:12.5px;}
        .rc-row:last-child{border-bottom:none;}
        .rk{color:var(--ink3);font-weight:500;}
        .rv{font-weight:700;color:var(--ink);}
        .rv.price{color:var(--gr);font-size:15px;}
        .rc-alert{background:var(--gr-lt);border:1px solid var(--gr-b);border-radius:var(--r);padding:12px 14px;font-size:12px;color:var(--ink2);display:flex;gap:9px;align-items:flex-start;margin-bottom:16px;}
        .rc-alert i{color:var(--gr);flex-shrink:0;margin-top:1px;}

        /* ══ NAVIGATION ══ */
        .sl-nav{display:flex;justify-content:space-between;align-items:center;margin-top:24px;padding-top:20px;border-top:1px solid var(--bord2);}
        .btn-prev{display:inline-flex;align-items:center;gap:6px;padding:10px 20px;border-radius:9px;border:1.5px solid var(--bord);background:var(--white);color:var(--ink2);font-size:12.5px;font-weight:600;font-family:sans-serif;cursor:pointer;transition:all .2s;}
        .btn-prev:hover{border-color:var(--gr-mid);color:var(--gr-dk);}
        .btn-prev:disabled{opacity:.3;cursor:not-allowed;}
        .btn-next{display:inline-flex;align-items:center;gap:7px;padding:11px 26px;border-radius:9px;border:none;background:var(--gr);color:#fff;font-size:12.5px;font-weight:700;font-family:sans-serif;cursor:pointer;transition:all .22s;box-shadow:0 4px 14px var(--gr-glow);}
        .btn-next:hover{background:var(--gr-dk);transform:translateY(-1px);box-shadow:0 6px 20px rgba(22,163,74,.28);}

        /* ══ MODAL ══ */
        .modal-content{border:none;border-radius:16px;box-shadow:0 18px 50px rgba(0,0,0,.12);overflow:hidden;font-family:sans-serif;}
        .modal-header{background:var(--ink);border-bottom:none;padding:16px 20px;}
        .modal-header h3{color:#fff;font-size:14px;font-weight:700;margin:0;}
        .modal-body{padding:20px;}
        .modal-footer{padding:12px 20px;border-top:1px solid var(--bord2);display:flex;gap:9px;justify-content:flex-end;}
        .f-row{display:flex;justify-content:space-between;align-items:center;padding:10px 0;border-bottom:1px dashed var(--bord2);font-size:13px;}
        .f-row:last-child{border-bottom:none;}
        .fk{color:var(--ink3);}
        .fv{font-weight:700;color:var(--ink);}
        .fv.p{color:var(--gr);font-size:16px;font-weight:800;}
        .f-warn{background:var(--red-lt);border:1px solid rgba(201,48,48,.15);border-radius:var(--r);padding:9px 12px;font-size:11.5px;color:var(--red);font-weight:600;margin-top:11px;display:flex;gap:7px;align-items:center;}
        .btn-ann{padding:9px 18px;border-radius:9px;border:1.5px solid var(--bord);background:var(--white);color:var(--ink2);font-size:12px;font-weight:600;font-family:sans-serif;cursor:pointer;}

        /* ══ AUTOCOMPLETE ══ */
        #quartierSuggestions{position:absolute;top:100%;left:0;right:0;max-height:160px;overflow-y:auto;z-index:999;background:var(--white);border-radius:var(--r);border:1px solid var(--bord);box-shadow:0 7px 20px rgba(0,0,0,.07);display:none;margin-top:3px;list-style:none;padding:4px;}
        #quartierSuggestions li{padding:8px 10px;font-size:12.5px;cursor:pointer;border-radius:6px;transition:background .12s;}
        #quartierSuggestions li:hover{background:var(--gr-lt);}

        /* ══ HELPERS ══ */
        .d-none{display:none!important;}
        .row-gap{display:flex;gap:14px;flex-wrap:wrap;}
        .row-gap>.fg{flex:1;min-width:110px;margin-top:0;}
        .section-sep{height:1px;background:var(--bord2);margin:16px 0;}
        .sub-section-title{font-size:10px;font-weight:700;color:var(--ink3);text-transform:uppercase;letter-spacing:.09em;margin-bottom:10px;}

        /* ══ MOBILE PROGRESS ══ */
        .mobile-progress{display:none;background:var(--white);border-bottom:1px solid var(--bord);padding:11px 14px;position:sticky;top:0;z-index:50;}
        @media(max-width:991px){.mobile-progress{display:block;}}
        .mp-label{font-size:11px;color:var(--ink3);font-weight:600;margin-bottom:5px;display:flex;justify-content:space-between;}
        .mp-bar{height:3px;background:var(--bord2);border-radius:4px;overflow:hidden;}
        .mp-fill{height:100%;background:var(--gr);border-radius:4px;transition:width .4s var(--ease);}

        /* ══ RESPONSIVE ══ */
        @media(max-width:991px){
            .sl-side{display:none;}
            .sl-main{padding:18px 14px 56px;max-width:100%;}
            .hero-carousel{height:160px;}
            .sp-title{font-size:19px;}
        }
        @media(max-width:767px){
            .sl-main{padding:14px 11px 46px;}
            .hero-carousel{height:130px;}
            .oc{min-width:65px;max-width:none;flex:1 1 calc(50% - 7px);}
            .oc .oc-long{display:none;}
            .oc .oc-short{display:block;}
            .eq{min-width:calc(50% - 5px);flex:1 1 calc(50% - 5px);}
            .surface-grid,.pieces-grid{grid-template-columns:repeat(2,1fr);}
            .compteur-grid{grid-template-columns:1fr;}
            .s-box{padding:14px 12px;}
            .sl-nav{flex-direction:column-reverse;gap:8px;}
            .btn-next,.btn-prev{width:100%;justify-content:center;}
            .geo-coords,.row-gap{flex-direction:column;gap:10px;}
            .geo-coords .fg,.row-gap>.fg{min-width:100%;}
        }
        @media(max-width:480px){
            .hero-carousel{height:110px;}
            .oc{flex:1 1 calc(50% - 5px);padding:10px 4px 8px;}
            .surface-grid,.pieces-grid{grid-template-columns:repeat(2,1fr);}
        }
    </style>

{{-- Mobile progress --}}
<div class="mobile-progress">
    <div class="mp-label">
        <span id="mpStepLabel">Étape 1 — Type de bien</span>
        <span id="mpStepNum">1 / 7</span>
    </div>
    <div class="mp-bar"><div class="mp-fill" id="mpFill" style="width:14.28%"></div></div>
</div>

<div class="sl-wrap">

    {{-- SIDEBAR --}}
    <aside class="sl-side">
        <div class="sl-side-ttl">Étapes de création</div>
        <ul class="sl-list" id="slList">
            <li class="sl-item active" data-step="1"><div class="si-dot"><span class="si-num">1</span></div><div class="si-txt"><span class="si-name">Type de bien</span><span class="si-st">En cours</span></div></li>
            <li class="sl-item" data-step="2"><div class="si-dot"><span class="si-num">2</span></div><div class="si-txt"><span class="si-name">Adresse</span><span class="si-st">À compléter</span></div></li>
            <li class="sl-item" data-step="3"><div class="si-dot"><span class="si-num">3</span></div><div class="si-txt"><span class="si-name">Caractéristiques</span><span class="si-st">À compléter</span></div></li>
            <li class="sl-item" data-step="4"><div class="si-dot"><span class="si-num">4</span></div><div class="si-txt"><span class="si-name">Photos &amp; Vidéo</span><span class="si-st">À compléter</span></div></li>
            <li class="sl-item" id="sideStep5" data-step="5"><div class="si-dot"><span class="si-num">5</span></div><div class="si-txt"><span class="si-name">Description</span><span class="si-st">À compléter</span></div></li>
            <li class="sl-item" data-step="6"><div class="si-dot"><span class="si-num">6</span></div><div class="si-txt"><span class="si-name">Prix</span><span class="si-st">À compléter</span></div></li>
            <li class="sl-item" data-step="7"><div class="si-dot"><span class="si-num">7</span></div><div class="si-txt"><span class="si-name">Récapitulatif</span><span class="si-st">À compléter</span></div></li>
        </ul>
    </aside>

    {{-- MAIN --}}
    <main class="sl-main">
        <form id="form" enctype="multipart/form-data" novalidate>
            @csrf

            {{-- CAROUSEL --}}
            <div class="hero-carousel" id="heroCarousel">
                <div class="hero-slide visible"><img src="{{ asset('1.png') }}" alt="Maison"></div>
                <div class="hero-slide"><img src="{{ asset('2.png') }}" alt="Appartement"></div>
                <div class="hero-slide"><img src="{{ asset('3.png') }}" alt="Terrain"></div>
                <div class="hero-slide"><img src="{{ asset('4.png') }}" alt="Bureau"></div>
                <div class="hero-dots">
                    <button class="hero-dot active" data-slide="0" type="button"></button>
                    <button class="hero-dot" data-slide="1" type="button"></button>
                    <button class="hero-dot" data-slide="2" type="button"></button>
                    <button class="hero-dot" data-slide="3" type="button"></button>
                </div>
            </div>

            {{-- ═══ ÉTAPE 1 ═══ --}}
            <div class="sl-pane active" id="pane1">
                <span class="sp-lbl">Étape 1 sur 7</span>
                <h1 class="sp-title">Type de bien et transaction</h1>
                <p class="sp-sub"><i class="fa fa-asterisk"></i> Information obligatoire</p>

                <div class="s-box">
                    <div class="s-box-title"><div class="bt-ico"><i class="fa fa-home"></i></div> Type de bien</div>
                    <div class="oc-row" id="typeGrid">
                        <label class="oc s" data-v="Maison"><input type="radio" name="type" value="Maison" checked><div class="oc-tick"></div><i class="fa fa-home"></i><span>Maison</span></label>
                        <label class="oc" data-v="Appartement"><input type="radio" name="type" value="Appartement"><div class="oc-tick"></div><i class="fa fa-building"></i><span>Appartement</span></label>
                        <label class="oc" data-v="Terrain"><input type="radio" name="type" value="Terrain"><div class="oc-tick"></div><i class="fa fa-map"></i><span>Terrain</span></label>
                        <label class="oc" data-v="Bureaux"><input type="radio" name="type" value="Bureaux"><div class="oc-tick"></div><i class="fa fa-briefcase"></i><span>Bureau</span></label>
                        <label class="oc" data-v="Boutique"><input type="radio" name="type" value="Boutique"><div class="oc-tick"></div><i class="fa fa-shopping-bag"></i><span>Boutique</span></label>
                    </div>
                </div>

                <div class="s-box">
                    <div class="s-box-title"><div class="bt-ico"><i class="fa fa-tag"></i></div> Vous souhaitez</div>
                    <div class="oc-row" id="catGrid" style="max-width:280px;">
                        <label class="oc s" data-v="louer"><input type="radio" name="categorie" value="louer" checked><div class="oc-tick"></div><i class="fa fa-key"></i><span>Louer</span></label>
                        <label class="oc" data-v="vendre"><input type="radio" name="categorie" value="vendre"><div class="oc-tick"></div><i class="fa fa-tag"></i><span>Vendre</span></label>
                    </div>
                </div>

                <div class="s-box" hidden>
                    <div class="s-box-title"><div class="bt-ico"><i class="fa fa-calendar"></i></div> Durée de publication</div>
                    <div class="fg" style="max-width:200px;">
                        <select name="duree" id="duree"><option value="7 Jours">7 jours</option></select>
                    </div>
                </div>
            </div>

            {{-- ═══ ÉTAPE 2 ═══ --}}
            <div class="sl-pane" id="pane2">
                <span class="sp-lbl">Étape 2 sur 7</span>
                <h1 class="sp-title">Où se situe votre bien ?</h1>
                <p class="sp-sub"><i class="fa fa-asterisk"></i> Information obligatoire</p>

                <div class="s-box">
                    <div class="s-box-title"><div class="bt-ico"><i class="fa fa-map"></i></div> Département &amp; commune</div>
                    <div class="row-gap">
                        <div class="fg"><label>Département <span style="color:var(--red)">*</span></label><select id="departementSelect" name="departement"><option value="">Sélectionner</option></select></div>
                        <div class="fg"><label>Commune</label><select id="communeSelect" name="commune" disabled><option value="">Sélectionner d'abord</option></select></div>
                    </div>
                </div>

                <div class="s-box">
                    <div class="s-box-title"><div class="bt-ico"><i class="fa fa-map-marker"></i></div> Quartier / Adresse</div>
                    <div class="fg" style="position:relative;">
                        <label>Quartier / Adresse précise <span style="color:var(--red)">*</span></label>
                        <input type="text" id="quartierInput" name="quartier" placeholder="Ex: Akpakpa, Fidjrossè, Godomey…" autocomplete="off">
                        <ul id="quartierSuggestions"></ul>
                    </div>
                </div>

                <div class="s-box">
                    <div class="s-box-title"><div class="bt-ico" style="background:var(--blue-lt);color:var(--blue);border-color:var(--blue-b);"><i class="fa fa-crosshairs"></i></div> Géolocalisation <span style="font-size:11px;font-weight:400;color:var(--ink3);margin-left:5px;text-transform:none;">(facultatif)</span></div>
                    <p style="font-size:12px;color:var(--ink3);margin:0 0 11px;">Localisez précisément votre bien pour faciliter les recherches.</p>
                    <button type="button" class="btn-geo" id="btnGeo"><i class="fa fa-location-arrow"></i> Obtenir ma position</button>
                    <div class="geo-status" id="geoStatus" style="display:none;"></div>
                    <div class="geo-box" id="geoBox" style="display:none;">
                        <div class="geo-box-title"><i class="fa fa-map-pin"></i> Coordonnées détectées</div>
                        <div class="geo-coords">
                            <div class="fg"><label>Latitude</label><input type="text" name="latitude" id="geoLat" readonly placeholder="—"></div>
                            <div class="fg"><label>Longitude</label><input type="text" name="longitude" id="geoLng" readonly placeholder="—"></div>
                        </div>
                        <div style="margin-top:7px;"><span style="font-size:11px;color:var(--ink3);" id="geoAddr"></span></div>
                        <button type="button" id="btnGeoReset" style="margin-top:8px;background:none;border:none;color:var(--red);font-size:11.5px;font-weight:600;cursor:pointer;font-family:sans-serif;padding:0;"><i class="fa fa-times"></i> Supprimer la géolocalisation</button>
                    </div>
                </div>
            </div>

            {{-- ═══ ÉTAPE 3 ═══ --}}
            <div class="sl-pane" id="pane3">
                <span class="sp-lbl">Étape 3 sur 7</span>
                <h1 class="sp-title">Précisez les caractéristiques</h1>
                <p class="sp-sub"><i class="fa fa-asterisk"></i> Les champs correspondent au type de bien sélectionné</p>

                {{-- MAISON / APPARTEMENT --}}
                <div class="s-box type-block" data-types="Maison,Appartement">
                    <div class="s-box-title"><div class="bt-ico"><i class="fa fa-th"></i></div> Répartition des pièces</div>
                    <div class="pieces-grid">
                        <div class="piece-card" id="pcSalon"><div class="piece-card-ico"><i class="fa fa-tv"></i></div><div class="piece-card-lbl">Salon(s)</div><div class="ctr"><button type="button" class="cb" data-t="nombreSalon" data-a="-">−</button><input type="number" name="nombreSalon" id="nombreSalon" class="cv" value="0" min="0" readonly><button type="button" class="cb" data-t="nombreSalon" data-a="+">+</button></div></div>
                        <div class="piece-card" id="pcCuisine"><div class="piece-card-ico"><i class="fa fa-cutlery"></i></div><div class="piece-card-lbl">Cuisine(s)</div><div class="ctr"><button type="button" class="cb" data-t="nombreCuisine" data-a="-">−</button><input type="number" name="nombreCuisine" id="nombreCuisine" class="cv" value="0" min="0" readonly><button type="button" class="cb" data-t="nombreCuisine" data-a="+">+</button></div></div>
                        <div class="piece-card" id="pcChambre"><div class="piece-card-ico"><i class="fa fa-bed"></i></div><div class="piece-card-lbl">Chambre(s)</div><div class="ctr"><button type="button" class="cb" data-t="nombreChambre" data-a="-">−</button><input type="number" name="nombreChambre" id="nombreChambre" class="cv" value="0" min="0" readonly><button type="button" class="cb" data-t="nombreChambre" data-a="+">+</button></div></div>
                        <div class="piece-card" id="pcSdb"><div class="piece-card-ico"><i class="fa fa-shower"></i></div><div class="piece-card-lbl">Salle(s) de bain</div><div class="ctr"><button type="button" class="cb" data-t="nombreSalleBain" data-a="-">−</button><input type="number" name="nombreSalleBain" id="nombreSalleBain" class="cv" value="0" min="0" readonly><button type="button" class="cb" data-t="nombreSalleBain" data-a="+">+</button></div></div>
                    </div>
                    <div class="pieces-total-badge"><i class="fa fa-calculator"></i> Total : <strong id="piecesTotalDisplay">0</strong> pièce(s)</div>
                    <input type="hidden" name="nombrePieces" id="nombrePieces" value="0">
                </div>

                <div class="s-box type-block" data-types="Maison,Appartement">
                    <div class="s-box-title"><div class="bt-ico"><i class="fa fa-th-large"></i></div> Surface par pièce</div>
                    <div class="surface-grid">
                        <div class="surf-card"><div class="surf-card-lbl"><i class="fa fa-home"></i> Salon</div><input type="number" name="surface_salon" id="surfSalon" placeholder="0" min="0"><div class="surf-card-unit">m²</div></div>
                        <div class="surf-card"><div class="surf-card-lbl"><i class="fa fa-cutlery"></i> Cuisine</div><input type="number" name="surface_cuisine" id="surfCuisine" placeholder="0" min="0"><div class="surf-card-unit">m²</div></div>
                        <div class="surf-card"><div class="surf-card-lbl"><i class="fa fa-bed"></i> Chambre</div><input type="number" name="surface_chambre" id="surfChambre" placeholder="0" min="0"><div class="surf-card-unit">m²/ch.</div></div>
                        <div class="surf-card"><div class="surf-card-lbl"><i class="fa fa-shower"></i> Salle de bain</div><input type="number" name="surface_sdb" id="surfSdb" placeholder="0" min="0"><div class="surf-card-unit">m²</div></div>
                        <div class="surf-card"><div class="surf-card-lbl" style="color:var(--gr-dk);"><i class="fa fa-calculator"></i> Totale</div><input type="number" name="surface" id="surface" placeholder="0" min="1" style="color:var(--gr);"><div class="surf-card-unit" style="color:var(--gr);">m² (auto)</div></div>
                    </div>
                </div>

                {{-- Disponibilité --}}
                <div class="s-box type-block" data-types="Maison,Appartement,Bureaux,Boutique">
                    <div class="s-box-title"><div class="bt-ico"><i class="fa fa-calendar-check-o"></i></div> Disponibilité</div>
                    <div class="fg" style="max-width:200px;"><label>Disponible à partir de</label><input type="date" name="disponible_date" id="dispoDate"></div>
                </div>

                <div class="s-box type-block" data-types="Maison,Appartement">
                    <div class="s-box-title"><div class="bt-ico"><i class="fa fa-check-circle-o"></i></div> Options résidentielles</div>
                    <div class="fg"><label>Colocation possible ?</label><div class="yn"><button type="button" class="yn-b" data-v="Oui" data-t="collocation">Oui</button><button type="button" class="yn-b s" data-v="Non" data-t="collocation">Non</button><input type="hidden" name="collocation" id="collocation" value="Non"></div></div>
                    <div class="fg" style="margin-top:12px;"><label>Parking / Stationnement ?</label><div class="yn"><button type="button" class="yn-b" data-v="Oui" data-t="packing">Oui</button><button type="button" class="yn-b s" data-v="Non" data-t="packing">Non</button><input type="hidden" name="packing" id="packing" value="Non"></div></div>
                    <div class="fg" style="margin-top:12px;"><label>Sanitaire (WC) ?</label><div class="yn"><button type="button" class="yn-b" data-v="Oui" data-t="sanitaire">Oui</button><button type="button" class="yn-b s" data-v="Non" data-t="sanitaire">Non</button><input type="hidden" name="sanitaire" id="sanitaire" value="Non"></div></div>
                    <div class="fg" style="margin-top:12px;"><label>Le propriétaire vit-il dans la maison ?</label><div class="yn"><button type="button" class="yn-b" data-v="Oui" data-t="proprio_vit">Oui</button><button type="button" class="yn-b s" data-v="Non" data-t="proprio_vit">Non</button><input type="hidden" name="proprio_vit" id="proprio_vit" value="Non"></div></div>
                    <div class="section-sep"></div>
                    <div class="sub-section-title"><i class="fa fa-bolt" style="color:var(--gr);margin-right:4px;"></i> Compteurs — Eau &amp; Électricité</div>
                    <div class="fg" style="margin-bottom:10px;"><label>Compteur eau</label>
                        <div class="compteur-grid" id="compteurEauGrid">
                            <label class="compt-opt" data-t="compteur_eau" data-v="Oui"><input type="radio" name="compteur_eau" value="Oui"><div class="compt-opt-ico"><i class="fa fa-tint"></i></div><div class="compt-opt-txt"><span class="compt-opt-name">Oui</span><span class="compt-opt-sub">Compteur personnel</span></div><div class="compt-tick"></div></label>
                            <label class="compt-opt" data-t="compteur_eau" data-v="Non"><input type="radio" name="compteur_eau" value="Non"><div class="compt-opt-ico"><i class="fa fa-times"></i></div><div class="compt-opt-txt"><span class="compt-opt-name">Non</span><span class="compt-opt-sub">Pas de compteur</span></div><div class="compt-tick"></div></label>
                        </div>
                        <input type="hidden" name="compteur_eau_val" id="compteurEauVal" value="">
                    </div>
                    <div class="fg"><label>Compteur électricité</label>
                        <div class="compteur-grid" id="compteurElecGrid">
                            <label class="compt-opt" data-t="compteur_elec" data-v="Standard"><input type="radio" name="compteur_elec" value="Standard"><div class="compt-opt-ico"><i class="fa fa-bolt"></i></div><div class="compt-opt-txt"><span class="compt-opt-name">Standard</span><span class="compt-opt-sub">Classique</span></div><div class="compt-tick"></div></label>
                            <label class="compt-opt" data-t="compteur_elec" data-v="Carte prépayée"><input type="radio" name="compteur_elec" value="Carte prépayée"><div class="compt-opt-ico"><i class="fa fa-credit-card"></i></div><div class="compt-opt-txt"><span class="compt-opt-name">Prépayé</span><span class="compt-opt-sub">Rechargeable</span></div><div class="compt-tick"></div></label>
                            <label class="compt-opt" data-t="compteur_elec" data-v="Non"><input type="radio" name="compteur_elec" value="Non"><div class="compt-opt-ico"><i class="fa fa-times"></i></div><div class="compt-opt-txt"><span class="compt-opt-name">Non</span><span class="compt-opt-sub">Pas de compteur</span></div><div class="compt-tick"></div></label>
                        </div>
                        <input type="hidden" name="compteur_elec_val" id="compteurElecVal" value="">
                    </div>
                </div>

                <div class="s-box type-block" data-types="Maison,Appartement">
                    <div class="s-box-title"><div class="bt-ico"><i class="fa fa-plug"></i></div> Équipements <span style="font-size:10px;font-weight:400;color:var(--ink3);margin-left:4px;">(facultatif)</span></div>
                    <div class="eq-row">
                        <label class="eq" data-n="cuisine_eq" data-v="Oui"><input type="checkbox" name="cuisine_eq" value="Oui"><div class="eq-tick"></div><i class="fa fa-cutlery"></i><span>Cuisine équipée</span></label>
                        <label class="eq" data-n="clime_c" data-v="Climatiseur"><input type="checkbox" name="clime_c" value="Climatiseur"><div class="eq-tick"></div><i class="fa fa-snowflake-o"></i><span>Climatiseur</span></label>
                        <label class="eq" data-n="brasseur" data-v="Oui"><input type="checkbox" name="brasseur" value="Oui"><div class="eq-tick"></div><i class="fa fa-circle-o-notch"></i><span>Brasseur d'air</span></label>
                        <label class="eq" data-n="wifi_c" data-v="Wifi"><input type="checkbox" name="wifi_c" value="Wifi"><div class="eq-tick"></div><i class="fa fa-wifi"></i><span>Wifi</span></label>
                        <label class="eq" data-n="securite_c" data-v="Oui"><input type="checkbox" name="securite_c" value="Oui"><div class="eq-tick"></div><i class="fa fa-shield"></i><span>Sécurité</span></label>
                        <label class="eq" data-n="terasse_c" data-v="Oui"><input type="checkbox" name="terasse_c" value="Oui"><div class="eq-tick"></div><i class="fa fa-sun-o"></i><span>Terrasse</span></label>
                        <label class="eq" data-n="entretien_c" data-v="Oui"><input type="checkbox" name="entretien_c" value="Oui"><div class="eq-tick"></div><i class="fa fa-magic"></i><span>Entretien inclus</span></label>
                    </div>
                </div>

                {{-- TERRAIN --}}
                <div class="s-box type-block" data-types="Terrain">
                    <div class="s-box-title"><div class="bt-ico"><i class="fa fa-map"></i></div> Dimensions du terrain</div>
                    <div class="surface-grid">
                        <div class="surf-card"><div class="surf-card-lbl"><i class="fa fa-arrows-h"></i> Largeur</div><input type="number" name="terrain_largeur" id="terrainLargeur" placeholder="0" min="0"><div class="surf-card-unit">mètres</div></div>
                        <div class="surf-card"><div class="surf-card-lbl"><i class="fa fa-arrows-v"></i> Longueur</div><input type="number" name="terrain_longueur" id="terrainLongueur" placeholder="0" min="0"><div class="surf-card-unit">mètres</div></div>
                        <div class="surf-card"><div class="surf-card-lbl" style="color:var(--gr-dk);"><i class="fa fa-calculator"></i> Superficie</div><input type="number" name="surface" id="surfaceTerrain" placeholder="0" min="1" style="color:var(--gr);"><div class="surf-card-unit" style="color:var(--gr);">m² (auto)</div></div>
                    </div>
                </div>

                <div class="s-box type-block" data-types="Terrain">
                    <div class="s-box-title"><div class="bt-ico"><i class="fa fa-file-text-o"></i></div> Informations légales</div>
                    <div class="fg">
                        <label>Type de titre foncier</label>
                        <select name="titre_foncier" id="titreFoncier">
                            <option value="">Sélectionner</option>
                            <option value="Titre Foncier">Titre Foncier (TF)</option>
                            <option value="Lettre de Réclamation">Lettre de Réclamation (LR)</option>
                            <option value="Convention">Convention</option>
                            <option value="Acte de Cession Définitive">Acte de Cession Définitive (ACD)</option>
                            <option value="Reçu de vente">Reçu de vente</option>
                            <option value="Autre">Autre</option>
                        </select>
                    </div>
                </div>

                <div class="s-box type-block" data-types="Terrain">
                    <div class="s-box-title"><div class="bt-ico"><i class="fa fa-list-alt"></i></div> Autres caractéristiques <span style="font-size:10px;font-weight:400;color:var(--ink3);margin-left:4px;">(facultatif)</span></div>
                    <div class="fg">
                        <span class="f-hint">Clôture, viabilité (eau, électricité), constructibilité, accès route, titre foncier complémentaire, etc.</span>
                        <textarea name="autres_caracteristiques_terrain" id="autresCaracteristiquesTerrain" placeholder="Ex : Terrain clôturé, viabilisé (eau + électricité), constructible, accès route goudronnée, situé dans un quartier résidentiel calme…" style="min-height:130px;"></textarea>
                    </div>
                </div>

                {{-- BUREAUX --}}
                <div class="s-box type-block" data-types="Bureaux">
                    <div class="s-box-title"><div class="bt-ico"><i class="fa fa-th-large"></i></div> Dimensions &amp; pièces</div>
                    <div class="row-gap">
                        <div class="fg"><label>Surface totale (m²) <span style="color:var(--red)">*</span></label><div class="fi"><input type="number" name="surface_bureau" id="surfaceBureau" placeholder="Ex: 60" min="1"><span class="fi-sfx">m²</span></div></div>
                        <div class="fg"><label>Nombre de pièces / postes</label><div class="ctr"><button type="button" class="cb" data-t="nombrePiecesBureaux" data-a="-">−</button><input type="number" name="nombrePiecesBureaux" id="nombrePiecesBureaux" class="cv" value="1" min="1" readonly><button type="button" class="cb" data-t="nombrePiecesBureaux" data-a="+">+</button></div></div>
                    </div>
                </div>

                <div class="s-box type-block" data-types="Bureaux">
                    <div class="s-box-title"><div class="bt-ico"><i class="fa fa-briefcase"></i></div> Options bureau</div>
                    <div class="fg"><label>Parking ?</label><div class="yn"><button type="button" class="yn-b" data-v="Oui" data-t="packing_bureaux">Oui</button><button type="button" class="yn-b s" data-v="Non" data-t="packing_bureaux">Non</button><input type="hidden" name="packing_bureaux" id="packing_bureaux" value="Non"></div></div>
                    <div class="fg" style="margin-top:12px;"><label>Sanitaire (WC) ?</label><div class="yn"><button type="button" class="yn-b" data-v="Oui" data-t="sanitaire_bureaux">Oui</button><button type="button" class="yn-b s" data-v="Non" data-t="sanitaire_bureaux">Non</button><input type="hidden" name="sanitaire_bureaux" id="sanitaire_bureaux" value="Non"></div></div>
                </div>

                <div class="s-box type-block" data-types="Bureaux">
                    <div class="s-box-title"><div class="bt-ico"><i class="fa fa-plug"></i></div> Équipements bureau</div>
                    <div class="eq-row">
                        <label class="eq" data-n="clime_b" data-v="Climatiseur"><input type="checkbox" name="clime_b" value="Climatiseur"><div class="eq-tick"></div><i class="fa fa-snowflake-o"></i><span>Climatiseur</span></label>
                        <label class="eq" data-n="brasseur_b" data-v="Oui"><input type="checkbox" name="brasseur_b" value="Oui"><div class="eq-tick"></div><i class="fa fa-circle-o-notch"></i><span>Brasseur d'air</span></label>
                        <label class="eq" data-n="wifi_b" data-v="Wifi"><input type="checkbox" name="wifi_b" value="Wifi"><div class="eq-tick"></div><i class="fa fa-wifi"></i><span>Wifi</span></label>
                        <label class="eq" data-n="securite_b" data-v="Oui"><input type="checkbox" name="securite_b" value="Oui"><div class="eq-tick"></div><i class="fa fa-shield"></i><span>Sécurité</span></label>
                        <label class="eq" data-n="parking_b" data-v="Oui"><input type="checkbox" name="parking_b" value="Oui"><div class="eq-tick"></div><i class="fa fa-car"></i><span>Parking</span></label>
                        <label class="eq" data-n="salle_conf" data-v="Oui"><input type="checkbox" name="salle_conf" value="Oui"><div class="eq-tick"></div><i class="fa fa-users"></i><span>Salle de conf.</span></label>
                    </div>
                </div>

                {{-- BOUTIQUE --}}
                <div class="s-box type-block" data-types="Boutique">
                    <div class="s-box-title"><div class="bt-ico"><i class="fa fa-arrows-alt"></i></div> Surface</div>
                    <div class="fg" style="max-width:200px;"><label>Surface (m²) <span style="color:var(--red)">*</span></label><div class="fi"><input type="number" name="surface_boutique" id="surfaceBoutique" placeholder="Ex: 30" min="1"><span class="fi-sfx">m²</span></div></div>
                </div>

                <div class="s-box type-block" data-types="Boutique">
                    <div class="s-box-title"><div class="bt-ico"><i class="fa fa-plug"></i></div> Équipements boutique</div>
                    <div class="eq-row">
                        <label class="eq" data-n="clime_bt" data-v="Climatiseur"><input type="checkbox" name="clime_bt" value="Climatiseur"><div class="eq-tick"></div><i class="fa fa-snowflake-o"></i><span>Climatiseur</span></label>
                        <label class="eq" data-n="brasseur_bt" data-v="Oui"><input type="checkbox" name="brasseur_bt" value="Oui"><div class="eq-tick"></div><i class="fa fa-circle-o-notch"></i><span>Brasseur d'air</span></label>
                        <label class="eq" data-n="securite_bt" data-v="Oui"><input type="checkbox" name="securite_bt" value="Oui"><div class="eq-tick"></div><i class="fa fa-shield"></i><span>Sécurité</span></label>
                        <label class="eq" data-n="parking_bt" data-v="Oui"><input type="checkbox" name="parking_bt" value="Oui"><div class="eq-tick"></div><i class="fa fa-car"></i><span>Parking</span></label>
                        <label class="eq" data-n="vitrine_bt" data-v="Oui"><input type="checkbox" name="vitrine_bt" value="Oui"><div class="eq-tick"></div><i class="fa fa-eye"></i><span>Vitrine</span></label>
                        <label class="eq" data-n="toilette_bt" data-v="Oui"><input type="checkbox" name="toilette_bt" value="Oui"><div class="eq-tick"></div><i class="fa fa-female"></i><span>Toilette</span></label>
                    </div>
                </div>

                <input type="hidden" name="surface_totale" id="surfaceTotaleHidden" value="0">
                <input type="hidden" name="clime" id="hClime" value="Non">
                <input type="hidden" name="wifi" id="hWifi" value="Non">
                <input type="hidden" name="securite" id="hSecurite" value="Non">
                <input type="hidden" name="terasse" id="hTerasse" value="Non">
                <input type="hidden" name="entretien" id="hEntretien" value="Non inclus">
                <input type="hidden" name="cuisine" id="hCuisine" value="Non">
                <input type="hidden" name="nombreChambreH" id="hChambre" value="0">
                <input type="hidden" name="nombreSalonH" id="hSalon" value="0">
                <input type="hidden" name="nombreCuisineH" id="hCuisineCount" value="0">
            </div>

            {{-- ═══ ÉTAPE 4 ═══ --}}
            <div class="sl-pane" id="pane4">
                <span class="sp-lbl">Étape 4 sur 7</span>
                <h1 class="sp-title">Ajoutez des photos et une vidéo</h1>
                <p class="sp-sub">Les annonces avec photos reçoivent <strong>5× plus de contacts</strong></p>
                <div class="s-box">
                    <div class="s-box-title"><div class="bt-ico"><i class="fa fa-camera"></i></div> Photos <span style="color:var(--red);margin-left:3px;font-size:10px;">obligatoire</span></div>
                    <div class="upz" id="upz"><i class="fa fa-cloud-upload"></i><p>Cliquez ou glissez vos photos ici</p><small>JPG, PNG — max 10 Mo par photo — <span style="color:var(--red);">au moins 1 photo requise</span></small><input type="file" name="images[]" id="images" accept="image/*" multiple style="display:none;"></div>
                    <span id="imgErr" style="display:none;color:var(--red);font-size:12px;font-weight:600;margin-top:8px;"></span>
                    <div class="prev-g" id="prevG"></div>
                </div>
                <div class="s-box">
                    <div class="s-box-title"><div class="bt-ico" style="background:var(--blue-lt);color:var(--blue);border-color:var(--blue-b);"><i class="fa fa-video-camera"></i></div> Vidéo de présentation <span style="font-size:10px;font-weight:400;color:var(--ink3);margin-left:4px;">(facultatif)</span></div>
                    <div class="vid-upz" id="vidUpz"><i class="fa fa-film"></i><p>Cliquez ou glissez votre vidéo ici</p><small>MP4, MOV, AVI — max 1 min 5 sec</small><input type="file" name="video" id="videoInput" accept="video/*" style="display:none;"></div>
                    <span id="vidErr" style="display:none;color:var(--red);font-size:12px;font-weight:600;margin-top:6px;"></span>
                    <div class="vid-preview" id="vidPreview"><video id="vidPlayer" controls></video><div class="vid-info"><span id="vidName" style="font-weight:600;"></span><button type="button" class="vid-del" id="vidDel"><i class="fa fa-trash"></i> Supprimer</button></div></div>
                </div>
            </div>

            {{-- ═══ ÉTAPE 5 : Description — masquée pour Terrain ═══ --}}
            <div class="sl-pane" id="pane5">
                <span class="sp-lbl">Étape 5 sur 7</span>
                <h1 class="sp-title">Décrivez les atouts de votre bien</h1>
                <p class="sp-sub">Optionnel — Soyez précis : emplacement, accès, points forts, itinéraire…</p>
                <div class="s-box">
                    <div class="s-box-title">
                        <div class="bt-ico"><i class="fa fa-align-left"></i></div>
                        Pourquoi choisir ce bien ?
                        <span style="font-size:10px;font-weight:400;color:var(--ink3);margin-left:4px;text-transform:none;">(facultatif)</span>
                    </div>
                    <div class="fg">
                        <textarea name="description" id="description" placeholder="Décrivez votre bien… (facultatif)"></textarea>
                        <div style="text-align:right;margin-top:3px;"><span id="descCt" style="font-size:11px;color:var(--ink3);">0 / 800</span></div>
                    </div>
                </div>
            </div>

            {{-- ═══ ÉTAPE 6 ═══ --}}
            <div class="sl-pane" id="pane6">
                <span class="sp-lbl">Étape 6 sur 7</span>
                <h1 class="sp-title">Définissez le prix</h1>
                <p class="sp-sub"><i class="fa fa-asterisk"></i> Information obligatoire</p>
                <div class="s-box">
                    <div class="s-box-title"><div class="bt-ico"><i class="fa fa-money"></i></div> Prix</div>
                    <div class="fg" id="fgPrix">
                        <label>Prix (FCFA) <span style="color:var(--red)">*</span></label>
                        <div class="fi" style="max-width:260px;"><input type="text" name="prix" id="prix" placeholder="Ex: 150 000" oninput="this.value=this.value.replace(/[^0-9\s]/g,'')"><span class="fi-sfx">FCFA</span></div>
                        <span class="ferr" id="prixErr"></span>
                    </div>
                    <div class="fg" style="margin-top:14px;"><label>Prix négociable ?</label><div class="yn"><button type="button" class="yn-b" data-v="Oui" data-t="negociable">Oui</button><button type="button" class="yn-b s" data-v="Non" data-t="negociable">Non</button><input type="hidden" name="negociable" id="negociable" value="Non"></div></div>
                </div>
                <div class="s-box" id="cautionBox">
                    <div class="s-box-title"><div class="bt-ico"><i class="fa fa-shield"></i></div> Caution</div>
                    <div class="fg" style="max-width:220px;"><select name="caution" id="caution"><option value="0">Aucune caution</option><option value="1 Mois">1 mois</option><option value="3 Mois" selected>3 mois</option><option value="6 Mois">6 mois</option><option value="A Negocier">À négocier</option></select></div>
                </div>
            </div>

            {{-- ═══ ÉTAPE 7 ═══ --}}
            <div class="sl-pane" id="pane7">
                <span class="sp-lbl">Étape 7 sur 7</span>
                <h1 class="sp-title">Vérifiez votre annonce</h1>
                <p class="sp-sub">Relisez toutes les informations avant de publier.</p>

                <div class="rc-blk"><div class="rc-hd"><i class="fa fa-home"></i><span>Type de bien</span></div><div class="rc-bd">
                    <div class="rc-row"><span class="rk">Type</span><span class="rv" id="rc-type">—</span></div>
                    <div class="rc-row"><span class="rk">Catégorie</span><span class="rv" id="rc-cat">—</span></div>
                </div></div>

                <div class="rc-blk"><div class="rc-hd"><i class="fa fa-map-marker"></i><span>Adresse</span></div><div class="rc-bd">
                    <div class="rc-row"><span class="rk">Département</span><span class="rv" id="rc-dep">—</span></div>
                    <div class="rc-row"><span class="rk">Commune</span><span class="rv" id="rc-com">—</span></div>
                    <div class="rc-row"><span class="rk">Quartier</span><span class="rv" id="rc-qrt">—</span></div>
                    <div class="rc-row"><span class="rk">Géolocalisation</span><span class="rv" id="rc-geo">Non renseignée</span></div>
                </div></div>

                <div class="rc-blk"><div class="rc-hd"><i class="fa fa-sliders"></i><span>Caractéristiques</span></div><div class="rc-bd">
                    <div class="rc-row"><span class="rk">Surface totale</span><span class="rv" id="rc-surf">—</span></div>
                    <div class="rc-row rc-resid"><span class="rk">Salon(s)</span><span class="rv" id="rc-salon">—</span></div>
                    <div class="rc-row rc-resid"><span class="rk">Chambre(s)</span><span class="rv" id="rc-chambre">—</span></div>
                    <div class="rc-row rc-resid"><span class="rk">Cuisine(s)</span><span class="rv" id="rc-cuisine">—</span></div>
                    <div class="rc-row rc-resid"><span class="rk">Salle(s) de bain</span><span class="rv" id="rc-sdb">—</span></div>
                    <div class="rc-row rc-resid"><span class="rk">Total pièces</span><span class="rv" id="rc-pieces">—</span></div>
                    <div class="rc-row rc-resid"><span class="rk">Parking</span><span class="rv" id="rc-park">—</span></div>
                    <div class="rc-row rc-resid"><span class="rk">Sanitaire</span><span class="rv" id="rc-sanitaire">—</span></div>
                    <div class="rc-row rc-resid"><span class="rk">Compteur eau</span><span class="rv" id="rc-compteur-eau">—</span></div>
                    <div class="rc-row rc-resid"><span class="rk">Compteur élec.</span><span class="rv" id="rc-compteur-elec">—</span></div>
                    <div class="rc-row rc-terrain"><span class="rk">Titre foncier</span><span class="rv" id="rc-titre">—</span></div>
                    <div class="rc-row rc-terrain"><span class="rk">Superficie</span><span class="rv" id="rc-superficie">—</span></div>
                    <div class="rc-row rc-terrain"><span class="rk">Autres caractéristiques</span><span class="rv" id="rc-autres-carac" style="font-size:11px;max-width:200px;text-align:right;">—</span></div>
                    <div class="rc-row"><span class="rk">Équipements</span><span class="rv" id="rc-eq" style="font-size:11px;">—</span></div>
                </div></div>

                <div class="rc-blk"><div class="rc-hd"><i class="fa fa-money"></i><span>Prix</span></div><div class="rc-bd">
                    <div class="rc-row"><span class="rk">Prix</span><span class="rv price" id="rc-prix">—</span></div>
                    <div class="rc-row"><span class="rk">Négociable</span><span class="rv" id="rc-neg">—</span></div>
                    <div class="rc-row rc-non-terrain"><span class="rk">Caution</span><span class="rv" id="rc-cau">—</span></div>
                </div></div>

                <div id="msg501"></div>
            </div>

            <div class="sl-nav">
                <button type="button" class="btn-prev" id="btnPrev" disabled><i class="fa fa-arrow-left"></i> Précédent</button>
                <button type="button" class="btn-next" id="btnNext">Suivant <i class="fa fa-arrow-right"></i></button>
            </div>
        </form>
    </main>
</div>

{{-- MODAL PAIEMENT --}}
<div class="modal fade" id="staticBackdrop2" data-backdrop="static" data-keyboard="false" tabindex="-1">
    <div class="modal-dialog"><div class="modal-content">
        <div class="modal-header"><h3>Récapitulatif de paiement</h3></div>
        <div class="modal-body">
            <div class="f-row"><span class="fk">Durée de publication</span><span class="fv">7 Jours</span></div>
            <div class="f-row"><span class="fk">Frais de publication</span><span class="fv p">5 000 FCFA</span></div>
            <div class="f-warn"><i class="fa fa-exclamation-triangle"></i> Cette somme est non remboursable.</div>
        </div>
        <div class="modal-footer"><button type="button" class="btn-ann" data-dismiss="modal">Annuler</button><span id="payerContainer"></span></div>
    </div></div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdn.kkiapay.me/k.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@4.22.0/dist/tf.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@tensorflow-models/mobilenet@2.1.1/dist/mobilenet.min.js"></script>
<script>
var saveRoute   = "{{ route('appartement.store') }}";
var retourRoute = "{{ route('entreprise.espace') }}";
var isFirstTime = @json($isFirstTime ?? false);
</script>
<script>
(function () {

/* ══════════════════════════════════════
   CAROUSEL
══════════════════════════════════════ */
(function () {
    var slides = document.querySelectorAll('.hero-slide');
    var dots   = document.querySelectorAll('.hero-dot');
    var cur = 0, timer = null;
    function showSlide(n) {
        slides.forEach(function(s){ s.classList.remove('visible'); });
        dots.forEach(function(d){ d.classList.remove('active'); });
        slides[n].classList.add('visible');
        dots[n].classList.add('active');
        cur = n;
    }
    dots.forEach(function(d){
        d.addEventListener('click', function(){
            clearInterval(timer);
            showSlide(parseInt(d.getAttribute('data-slide')));
            timer = setInterval(function(){ showSlide((cur + 1) % slides.length); }, 4500);
        });
    });
    showSlide(0);
    timer = setInterval(function(){ showSlide((cur + 1) % slides.length); }, 4500);
})();

/* ══════════════════════════════════════
   UTILITAIRES ERREURS
══════════════════════════════════════ */
function setErr(el, msg) {
    el.style.borderColor = 'var(--red)';
    el.style.boxShadow   = '0 0 0 3px rgba(220,38,38,.07)';
    var e = el.parentNode.querySelector('.ferr-inline');
    if (!e) {
        e = document.createElement('span');
        e.className = 'ferr-inline';
        e.style.cssText = 'display:block;font-size:11px;color:var(--red);margin-top:4px;font-weight:600;';
        el.parentNode.appendChild(e);
    }
    e.textContent = msg;
    el.scrollIntoView({ behavior: 'smooth', block: 'center' });
}
function clearErr(el) {
    el.style.borderColor = '';
    el.style.boxShadow   = '';
    var e = el.parentNode.querySelector('.ferr-inline');
    if (e) e.textContent = '';
}

/* ══════════════════════════════════════
   IA — ANALYSE IMAGES
══════════════════════════════════════ */
var mobileNetPromise = null, mobileNetLoadFailed = false, isAnalyzingImages = false;
var REAL_ESTATE_HINTS = ['house','home','building','palace','mosque','church','monastery','library','barn','boathouse','greenhouse','patio','porch','restaurant','office','warehouse','shop','tile roof','window','window shade','sliding door','wardrobe','bookcase','studio couch','desk','dining table','table lamp','refrigerator','bathtub','shower curtain','toilet seat','stove','microwave','washer','dishwasher'];
var NON_REAL_ESTATE_HINTS = ['person','man','woman','boy','girl','bridegroom','groom','dog','cat','bird','snake','spider','insect','fish','car','truck','bus','bicycle','motorcycle','scooter','train','airplane','boat','ship','pizza','burger','sandwich','plate','banana','orange','apple','ice cream','cake','beer','wine','coffee','cup','bottle','flower','plant','tree','forest','mountain','valley','beach','volcano','cliff','jersey','suit','shirt','dress','shoe','sneaker','handbag','backpack','laptop','phone'];

function setImgErrorMessage(msg){ imgErr.textContent=msg; imgErr.style.display='block'; upz.style.borderColor='var(--red)'; }
function clearImgErrorMessage(){ imgErr.textContent=''; imgErr.style.display='none'; upz.style.borderColor=''; }

function hasHint(label, hints){
    return hints.some(function(hint){ return label.indexOf(hint) !== -1; });
}
async function getMobileNetModel(){
    if(mobileNetLoadFailed || typeof mobilenet === 'undefined' || typeof tf === 'undefined') return null;
    if(!mobileNetPromise){ mobileNetPromise = mobilenet.load({version:2,alpha:1}); }
    try{ return await mobileNetPromise; } catch(e){ mobileNetLoadFailed=true; return null; }
}
function fileToImageEl(file){
    return new Promise(function(resolve, reject){
        var url = URL.createObjectURL(file);
        var img = new Image();
        img.onload  = function(){ resolve({img:img, url:url}); };
        img.onerror = function(){ URL.revokeObjectURL(url); reject(new Error('Image illisible')); };
        img.src = url;
    });
}
function evaluatePredictions(predictions){
    var realEstateScore = 0, nonRealEstateScore = 0;
    predictions.slice(0,3).forEach(function(pred){
        var label = (pred.className || '').toLowerCase();
        var prob  = pred.probability || 0;
        if(hasHint(label, REAL_ESTATE_HINTS))     realEstateScore    += prob * 2;
        if(hasHint(label, NON_REAL_ESTATE_HINTS)) nonRealEstateScore += prob * 2.5;
    });
    var topLabel = ((predictions[0] && predictions[0].className) || '').toLowerCase();
    var topProb  = (predictions[0] && predictions[0].probability) || 0;
    if(hasHint(topLabel, NON_REAL_ESTATE_HINTS) && topProb >= 0.35 && realEstateScore === 0){
        return {accepted:false, reason:'Image refusée : photo non liée à l\'immobilier ('+topLabel+').'};
    }
    if(nonRealEstateScore > realEstateScore + 0.2){
        return {accepted:false, reason:'Image refusée : contenu probablement hors immobilier.'};
    }
    return {accepted:true, reason:''};
}
async function validateImageWithMobileNet(file){
    var model = await getMobileNetModel();
    if(!model) return {accepted:true, reason:''};
    try{
        var loaded = await fileToImageEl(file);
        var preds  = await model.classify(loaded.img);
        URL.revokeObjectURL(loaded.url);
        return evaluatePredictions(preds || []);
    } catch(e){ return {accepted:true, reason:''}; }
}
getMobileNetModel();

/* ══════════════════════════════════════
   DATE MIN
══════════════════════════════════════ */
(function(){
    var dd = document.getElementById('dispoDate');
    if(!dd) return;
    var t = new Date();
    dd.min = dd.value = t.getFullYear()+'-'+String(t.getMonth()+1).padStart(2,'0')+'-'+String(t.getDate()).padStart(2,'0');
})();

/* ══════════════════════════════════════
   DONNÉES BÉNIN
══════════════════════════════════════ */
var bd = {
    "Alibori":["Banikoara","Gogounou","Kandi","Karimama","Malanville","Ségbana"],
    "Atacora":["Boukoumbé","Cobly","Kérou","Kouandé","Matéri","Natitingou","Péhunco","Tanguiéta","Toucountouna"],
    "Atlantique":["Abomey-Calavi","Allada","Kpomassè","Ouidah","So-Ava","Toffo","Tori-Bossito","Zè"],
    "Borgou":["Bembèrèkè","Kalalé","N'Dali","Nikki","Parakou","Pèrèrè","Sinendé","Tchaourou"],
    "Collines":["Bantè","Dassa-Zoumè","Glazoué","Ouèssè","Savalou","Savè"],
    "Couffo":["Aplahoué","Djakotomey","Dogbo","Klouékanmè","Lalo","Toviklin"],
    "Donga":["Bassila","Copargo","Djougou","Ouaké"],
    "Littoral":["Cotonou"],
    "Mono":["Athiémé","Bopa","Comè","Grand-Popo","Houéyogbé","Lokossa"],
    "Ouémé":["Adjarra","Adjohoun","Aguegues","Akpro-Missérété","Avrankou","Bonou","Dangbo","Porto-Novo","Sèmè-Podji"],
    "Plateau":["Adja-Ouèrè","Ifangni","Kétou","Pobè","Sakété"],
    "Zou":["Abomey","Agbangnizoun","Bohicon","Covè","Djidja","Ouinhi","Zagnanado"]
};
var qb = ["Akpakpa","Fidjrossè","Cadjehoun","Ganhi","Zogbo","Houéyiho","Godomey","Ste Rita","Agla","Vêdoko","Gbégamey","Wologuèdè","Jéricho","Hindé","Mènontin","Togoudo","Tankpè","Zopa","Calavi Kpota","Zogbadjè","Aitchedji","Dota","Oganla","Djassin","Kouhounou","Guéma","Kpébié","Zongo","Agongointo","Saclo","Sodohomey","Pahou","Savi","Dantokpa","Houinta","Akassato","Agori","Onigbolo"];

var dSel = document.getElementById('departementSelect');
var cSel = document.getElementById('communeSelect');

Object.keys(bd).forEach(function(d){
    var o = document.createElement('option'); o.value = d; o.textContent = d;
    dSel.appendChild(o);
});
dSel.addEventListener('change', function(){
    cSel.innerHTML = '<option value="">Sélectionner</option>';
    cSel.disabled  = true;
    var a = bd[this.value];
    if(a && a.length){
        a.forEach(function(c){ var o=document.createElement('option'); o.value=c; o.textContent=c; cSel.appendChild(o); });
        cSel.disabled = false;
    }
    clearErr(dSel);
});
cSel.addEventListener('change', function(){ if(this.value) clearErr(this); });

/* ── Autocomplete quartier ── */
var qIn = document.getElementById('quartierInput');
var qBx = document.getElementById('quartierSuggestions');
qIn.addEventListener('input', function(){
    var v = this.value.toLowerCase(); qBx.innerHTML = '';
    if(v.length < 1){ qBx.style.display='none'; return; }
    if(this.value.trim().length >= 2) clearErr(this);
    var r = qb.filter(function(q){ return q.toLowerCase().indexOf(v) !== -1; }).slice(0,8);
    if(!r.length){ qBx.style.display='none'; return; }
    r.forEach(function(q){
        var li = document.createElement('li');
        li.textContent = q;
        li.addEventListener('click', function(){ qIn.value=q; qBx.style.display='none'; clearErr(qIn); });
        qBx.appendChild(li);
    });
    qBx.style.display = 'block';
});
document.addEventListener('click', function(e){ if(!qIn.contains(e.target)) qBx.style.display='none'; });

/* ══════════════════════════════════════
   GÉOLOCALISATION
══════════════════════════════════════ */
var geoLat     = document.getElementById('geoLat');
var geoLng     = document.getElementById('geoLng');
var geoBox     = document.getElementById('geoBox');
var geoStatus  = document.getElementById('geoStatus');
var geoAddr    = document.getElementById('geoAddr');
var btnGeo     = document.getElementById('btnGeo');
var btnGeoReset= document.getElementById('btnGeoReset');

function showGeoStatus(t, m){ geoStatus.className='geo-status '+t; geoStatus.innerHTML=m; geoStatus.style.display='flex'; }

btnGeo.addEventListener('click', function(){
    if(!navigator.geolocation){ showGeoStatus('err','<i class="fa fa-times-circle"></i> Non supporté.'); return; }
    btnGeo.disabled = true;
    showGeoStatus('loading','<i class="fa fa-spinner fa-spin"></i> Localisation en cours…');
    navigator.geolocation.getCurrentPosition(
        function(p){
            var lat = p.coords.latitude.toFixed(6);
            var lng = p.coords.longitude.toFixed(6);
            geoLat.value = lat; geoLng.value = lng;
            geoBox.style.display = 'block'; btnGeo.style.display = 'none';
            showGeoStatus('ok','<i class="fa fa-check-circle"></i> Position détectée.');
            fetch('https://nominatim.openstreetmap.org/reverse?lat='+lat+'&lon='+lng+'&format=json')
                .then(function(r){ return r.json(); })
                .then(function(d){ if(d && d.display_name) geoAddr.textContent = '📍 '+d.display_name; })
                .catch(function(){});
        },
        function(err){
            btnGeo.disabled = false;
            showGeoStatus('err', err.code===1 ? '<i class="fa fa-ban"></i> Accès refusé.' : '<i class="fa fa-exclamation-circle"></i> Impossible de localiser.');
        },
        { enableHighAccuracy:true, timeout:10000 }
    );
});
btnGeoReset.addEventListener('click', function(){
    geoLat.value=''; geoLng.value=''; geoAddr.textContent='';
    geoBox.style.display='none'; btnGeo.style.display=''; btnGeo.disabled=false; geoStatus.style.display='none';
});

/* ══════════════════════════════════════
   TYPE DE BIEN — AFFICHAGE DYNAMIQUE
══════════════════════════════════════ */
var currentType = 'Maison';

function applyTypeBlocks(){
    document.querySelectorAll('.type-block').forEach(function(b){
        var types = b.getAttribute('data-types').split(',');
        b.classList.toggle('d-none', types.indexOf(currentType) === -1);
    });
    var isTerrain  = (currentType === 'Terrain');
    var cautionBox = document.getElementById('cautionBox');
    if(cautionBox) cautionBox.style.display = isTerrain ? 'none' : '';

    /* ── Masquer / afficher l'étape 5 (description) pour Terrain ── */
    var sideStep5 = document.getElementById('sideStep5');
    if(sideStep5){
        if(isTerrain){ sideStep5.classList.add('skipped'); }
        else          { sideStep5.classList.remove('skipped'); }
    }

    updatePiecesTotal();
    syncSurfaceTotale();
}
applyTypeBlocks();

function initOcGrid(gridId, onChange){
    var g = document.getElementById(gridId);
    if(!g) return;
    g.querySelectorAll('.oc').forEach(function(c){
        c.addEventListener('click', function(){
            g.querySelectorAll('.oc').forEach(function(x){ x.classList.remove('s'); });
            c.classList.add('s');
            if(onChange) onChange(c.getAttribute('data-v'));
        });
    });
}
initOcGrid('typeGrid', function(v){ currentType = v; applyTypeBlocks(); });
initOcGrid('catGrid', null);

/* ── Compteurs eau / élec ── */
function initCompteurGrid(gridId, hiddenId){
    var g = document.getElementById(gridId);
    if(!g) return;
    g.querySelectorAll('.compt-opt').forEach(function(opt){
        opt.addEventListener('click', function(){
            g.querySelectorAll('.compt-opt').forEach(function(x){ x.classList.remove('s'); });
            opt.classList.add('s');
            var inp = opt.querySelector('input[type="radio"]');
            if(inp) inp.checked = true;
            var h = document.getElementById(hiddenId);
            if(h) h.value = opt.getAttribute('data-v');
        });
    });
}
initCompteurGrid('compteurEauGrid','compteurEauVal');
initCompteurGrid('compteurElecGrid','compteurElecVal');

/* ── Équipements (checkbox) ── */
document.querySelectorAll('.eq').forEach(function(item){
    item.addEventListener('click', function(){
        item.classList.toggle('s');
        var inp = item.querySelector('input');
        if(inp) inp.checked = item.classList.contains('s');
    });
});

/* ══════════════════════════════════════
   TERRAIN — superficie auto
══════════════════════════════════════ */
function updateTerrainSurface(){
    var l  = parseFloat(document.getElementById('terrainLargeur') ? document.getElementById('terrainLargeur').value : 0) || 0;
    var lo = parseFloat(document.getElementById('terrainLongueur') ? document.getElementById('terrainLongueur').value : 0) || 0;
    var st = document.getElementById('surfaceTerrain');
    if(st && l > 0 && lo > 0){ st.value = Math.round(l * lo); syncSurfaceTotale(); }
}
var tL  = document.getElementById('terrainLargeur');
var tLo = document.getElementById('terrainLongueur');
if(tL)  tL.addEventListener('input', updateTerrainSurface);
if(tLo) tLo.addEventListener('input', updateTerrainSurface);

/* ══════════════════════════════════════
   SURFACE TOTALE
══════════════════════════════════════ */
function syncSurfaceTotale(){
    var h = document.getElementById('surfaceTotaleHidden');
    if(!h) return;
    var map = { 'Maison':'surface', 'Appartement':'surface', 'Terrain':'surfaceTerrain', 'Bureaux':'surfaceBureau', 'Boutique':'surfaceBoutique' };
    var id  = map[currentType];
    if(!id) return;
    var el  = document.getElementById(id);
    h.value = (el && el.value) ? el.value : '0';
}

function updateSurfaceTotale(){
    var s  = parseFloat(document.getElementById('surfSalon')   ? document.getElementById('surfSalon').value   : 0) || 0;
    var c  = parseFloat(document.getElementById('surfCuisine') ? document.getElementById('surfCuisine').value : 0) || 0;
    var ch = parseFloat(document.getElementById('surfChambre') ? document.getElementById('surfChambre').value : 0) || 0;
    var b  = parseFloat(document.getElementById('surfSdb')     ? document.getElementById('surfSdb').value     : 0) || 0;
    var t  = s + c + ch + b;
    var surfEl = document.getElementById('surface');
    if(surfEl && t > 0) surfEl.value = t;
    syncSurfaceTotale();
}

['surfSalon','surfCuisine','surfChambre','surfSdb'].forEach(function(id){
    var el = document.getElementById(id);
    if(el) el.addEventListener('input', updateSurfaceTotale);
});
['surface','surfaceBureau','surfaceBoutique','surfaceTerrain'].forEach(function(id){
    var el = document.getElementById(id);
    if(el) el.addEventListener('input', syncSurfaceTotale);
});

/* ══════════════════════════════════════
   PIÈCES +/-
══════════════════════════════════════ */
function updatePiecesTotal(){
    var salon   = parseInt(document.getElementById('nombreSalon')     ? document.getElementById('nombreSalon').value     : 0) || 0;
    var cuisine = parseInt(document.getElementById('nombreCuisine')   ? document.getElementById('nombreCuisine').value   : 0) || 0;
    var chambre = parseInt(document.getElementById('nombreChambre')   ? document.getElementById('nombreChambre').value   : 0) || 0;
    var sdb     = parseInt(document.getElementById('nombreSalleBain') ? document.getElementById('nombreSalleBain').value : 0) || 0;
    var total   = salon + cuisine + chambre + sdb;
    var npEl    = document.getElementById('nombrePieces');   if(npEl) npEl.value  = total;
    var pdEl    = document.getElementById('piecesTotalDisplay'); if(pdEl) pdEl.textContent = total;
    if(document.getElementById('hSalon'))      document.getElementById('hSalon').value      = salon;
    if(document.getElementById('hChambre'))    document.getElementById('hChambre').value    = chambre;
    if(document.getElementById('hCuisineCount')) document.getElementById('hCuisineCount').value = cuisine;
    var cards = { 'nombreSalon':'pcSalon', 'nombreCuisine':'pcCuisine', 'nombreChambre':'pcChambre', 'nombreSalleBain':'pcSdb' };
    Object.keys(cards).forEach(function(fid){
        var inp  = document.getElementById(fid);
        var card = document.getElementById(cards[fid]);
        if(inp && card) card.classList.toggle('has-value', parseInt(inp.value) > 0);
    });
}

document.querySelectorAll('.cb').forEach(function(b){
    b.addEventListener('click', function(){
        var tid = b.getAttribute('data-t');
        var el  = document.getElementById(tid);
        if(!el) return;
        var v  = parseInt(el.value) || 0;
        var mn = parseInt(el.min) || 0;
        if(b.getAttribute('data-a') === '+') v++;
        else if(v > mn) v--;
        el.value = v;
        if(['nombreSalon','nombreCuisine','nombreChambre','nombreSalleBain'].indexOf(tid) !== -1) updatePiecesTotal();
    });
});

/* ══════════════════════════════════════
   OUI / NON
══════════════════════════════════════ */
document.querySelectorAll('.yn-b[data-t]').forEach(function(b){
    b.addEventListener('click', function(){
        var p = b.parentElement;
        p.querySelectorAll('.yn-b').forEach(function(x){ x.classList.remove('s'); });
        b.classList.add('s');
        var el = document.getElementById(b.getAttribute('data-t'));
        if(el) el.value = b.getAttribute('data-v');
    });
});

/* ══════════════════════════════════════
   PHOTOS
══════════════════════════════════════ */
var upz    = document.getElementById('upz');
var fInp   = document.getElementById('images');
var prG    = document.getElementById('prevG');
var imgErr = document.getElementById('imgErr');
var aFiles = [], MAX_IMG = 10 * 1024 * 1024;

upz.addEventListener('click', function(){ fInp.click(); });
upz.addEventListener('dragover', function(e){ e.preventDefault(); upz.classList.add('dz'); });
upz.addEventListener('dragleave', function(){ upz.classList.remove('dz'); });
upz.addEventListener('drop', function(e){ e.preventDefault(); upz.classList.remove('dz'); addF(e.dataTransfer.files); });
fInp.addEventListener('change', function(){ addF(this.files); this.value=''; });

async function addF(files){
    var refused  = [];
    var incoming = Array.prototype.slice.call(files || []);
    if(!incoming.length) return;
    imgErr.textContent = 'Analyse IA des images en cours…'; imgErr.style.display='block'; upz.style.borderColor='var(--amber)';
    isAnalyzingImages = true;
    for(var i=0; i<incoming.length; i++){
        var f = incoming[i];
        if(!f.type.startsWith('image/')){ refused.push('"'+f.name+'"'); continue; }
        if(f.size > MAX_IMG){ refused.push('"'+f.name+'" > 10 Mo'); continue; }
        var aiCheck = await validateImageWithMobileNet(f);
        if(!aiCheck.accepted){ refused.push('"'+f.name+'" : hors immobilier'); continue; }
        aFiles.push(f);
        (function(fileRef){
            var r = new FileReader();
            r.onload = function(ev){
                var d   = document.createElement('div'); d.className='pv';
                var img = document.createElement('img'); img.src=ev.target.result;
                var dl  = document.createElement('button'); dl.className='pv-del'; dl.type='button'; dl.innerHTML='&times;';
                dl.addEventListener('click', function(){
                    var idx = aFiles.indexOf(fileRef);
                    if(idx !== -1) aFiles.splice(idx,1);
                    d.remove(); checkImgErr();
                });
                d.appendChild(img); d.appendChild(dl); prG.appendChild(d);
            };
            r.readAsDataURL(f);
        })(f);
    }
    isAnalyzingImages = false;
    if(refused.length) setImgErrorMessage('Refusé(s) : '+refused.join(', '));
    else checkImgErr();
}

function checkImgErr(){
    if(isAnalyzingImages) return;
    if(aFiles.length === 0) setImgErrorMessage('Au moins une photo est obligatoire.');
    else clearImgErrorMessage();
}

/* ══════════════════════════════════════
   VIDÉO
══════════════════════════════════════ */
var vidUpz     = document.getElementById('vidUpz');
var vidInput   = document.getElementById('videoInput');
var vidPreview = document.getElementById('vidPreview');
var vidPlayer  = document.getElementById('vidPlayer');
var vidName    = document.getElementById('vidName');
var vidErr     = document.getElementById('vidErr');
var vidDel     = document.getElementById('vidDel');
var vidFile    = null;
var MAX_VID    = 100 * 1024 * 1024, MAX_VID_DUR = 65;

vidUpz.addEventListener('click', function(){ vidInput.click(); });
vidUpz.addEventListener('dragover', function(e){ e.preventDefault(); vidUpz.classList.add('dz'); });
vidUpz.addEventListener('dragleave', function(){ vidUpz.classList.remove('dz'); });
vidUpz.addEventListener('drop', function(e){ e.preventDefault(); vidUpz.classList.remove('dz'); if(e.dataTransfer.files.length) handleVideo(e.dataTransfer.files[0]); });
vidInput.addEventListener('change', function(){ if(this.files.length) handleVideo(this.files[0]); this.value=''; });

function handleVideo(f){
    vidErr.style.display = 'none';
    if(!f.type.startsWith('video/')){ vidErr.textContent='Ce n\'est pas une vidéo.'; vidErr.style.display='block'; return; }
    if(f.size > MAX_VID){ vidErr.textContent='La vidéo dépasse 100 Mo.'; vidErr.style.display='block'; return; }
    var url = URL.createObjectURL(f);
    var tmp = document.createElement('video'); tmp.preload='metadata'; tmp.src=url;
    tmp.onloadedmetadata = function(){
        URL.revokeObjectURL(url);
        if(tmp.duration > MAX_VID_DUR){ vidErr.textContent='Durée dépassée (max 1 min 5 sec).'; vidErr.style.display='block'; vidFile=null; return; }
        vidFile = f;
        vidPlayer.src = URL.createObjectURL(f);
        vidName.textContent = f.name+' ('+Math.round(f.size/1024/1024*10)/10+' Mo)';
        vidPreview.style.display = 'block'; vidUpz.style.display = 'none';
    };
    tmp.onerror = function(){ vidErr.textContent='Impossible de lire ce fichier.'; vidErr.style.display='block'; };
}
vidDel.addEventListener('click', function(){ vidFile=null; vidPlayer.src=''; vidPreview.style.display='none'; vidUpz.style.display=''; });

/* ══════════════════════════════════════
   DESCRIPTION — compteur caractères
══════════════════════════════════════ */
var dTa = document.getElementById('description');
var dCt = document.getElementById('descCt');
dTa.addEventListener('input', function(){
    var len = this.value.length;
    dCt.textContent = len+' / 800';
    dCt.style.color = len > 700 ? 'var(--red)' : 'var(--ink3)';
});

/* ── Prix ── */
document.getElementById('prix').addEventListener('input', function(){
    var p = this.value.replace(/\s/g,'');
    if(p && !isNaN(parseFloat(p)) && parseFloat(p) > 0){
        clearErr(this);
        document.getElementById('prixErr').style.display = 'none';
        document.getElementById('fgPrix').classList.remove('err');
    }
});

/* ══════════════════════════════════════
   MOBILE PROGRESS
══════════════════════════════════════ */
var stepLabels = ['Type de bien','Adresse','Caractéristiques','Photos & Vidéo','Description','Prix','Récapitulatif'];
function updateMobileProgress(n){
    var lbl  = document.getElementById('mpStepLabel');
    var num  = document.getElementById('mpStepNum');
    var fill = document.getElementById('mpFill');
    if(lbl)  lbl.textContent  = 'Étape '+n+' — '+stepLabels[n-1];
    if(num)  num.textContent  = n+' / 7';
    if(fill) fill.style.width = ((n/7)*100).toFixed(1)+'%';
}

/* ══════════════════════════════════════
   NAVIGATION ÉTAPES
   — L'étape 5 est sautée si Terrain
══════════════════════════════════════ */
var currentStep = 1, tot = 7;

/* Calcule l'étape suivante en tenant compte du saut Terrain */
function nextStepFor(n){
    if(n === 4 && currentType === 'Terrain') return 6;
    return n < tot ? n + 1 : n;
}
/* Calcule l'étape précédente en tenant compte du saut Terrain */
function prevStepFor(n){
    if(n === 6 && currentType === 'Terrain') return 4;
    return n > 1 ? n - 1 : n;
}

function goTo(n){
    document.querySelectorAll('.sl-pane').forEach(function(p){ p.classList.remove('active'); });
    document.getElementById('pane'+n).classList.add('active');
    document.querySelectorAll('.sl-item').forEach(function(s){
        var sn = parseInt(s.getAttribute('data-step'));
        s.classList.remove('active','done');
        /* Pour Terrain : l'étape 5 reste skipped, jamais done ni active */
        if(currentType === 'Terrain' && sn === 5){
            s.querySelector('.si-st').textContent = 'Non applicable';
            return;
        }
        if(sn === n){ s.classList.add('active'); s.querySelector('.si-st').textContent = 'En cours'; }
        else if(sn < n){ s.classList.add('done'); s.querySelector('.si-st').textContent = 'Complété ✓'; }
        else{ s.querySelector('.si-st').textContent = 'À compléter'; }
    });
    document.getElementById('btnPrev').disabled = (n === 1);
    var nBtn = document.getElementById('btnNext');
    if(n === tot){ nBtn.innerHTML = '<i class="fa fa-check" style="margin-right:6px;"></i>Soumettre l\'annonce'; }
    else         { nBtn.innerHTML = 'Suivant <i class="fa fa-arrow-right" style="margin-left:6px;"></i>'; }
    currentStep = n;
    updateMobileProgress(n);
    window.scrollTo({top:0, behavior:'smooth'});
    if(n === 7) fillRecap();
}

document.getElementById('btnNext').addEventListener('click', function(){
    if(!validate(currentStep)) return;
    var next = nextStepFor(currentStep);
    if(next !== currentStep) goTo(next);
    else submitForm();
});
document.getElementById('btnPrev').addEventListener('click', function(){
    var prev = prevStepFor(currentStep);
    if(prev !== currentStep) goTo(prev);
});

/* ══════════════════════════════════════
   VALIDATION PAR ÉTAPE
══════════════════════════════════════ */
function validate(n){
    if(n === 2){
        var ok = true;
        if(!dSel.value){ setErr(dSel,'Veuillez sélectionner un département.'); ok=false; }
        if(!cSel.value){ setErr(cSel,'Veuillez sélectionner une commune.'); ok=false; }
        if(qIn.value.trim().length < 2){ setErr(qIn,'Le quartier doit comporter au moins 2 caractères.'); ok=false; }
        return ok;
    }
    if(n === 3){
        if(currentType==='Maison' || currentType==='Appartement'){
            var s = document.getElementById('surface');
            if(!s.value || parseInt(s.value) <= 0){ setErr(s,'Indiquez la surface totale.'); return false; }
            clearErr(s);
        }
        if(currentType === 'Terrain'){
            var st = document.getElementById('surfaceTerrain');
            if(!st.value || parseInt(st.value) <= 0){ setErr(st,'Indiquez la superficie du terrain.'); return false; }
            clearErr(st);
        }
        if(currentType === 'Bureaux'){
            var sb = document.getElementById('surfaceBureau');
            if(!sb.value || parseInt(sb.value) <= 0){ setErr(sb,'Indiquez la surface.'); return false; }
            clearErr(sb);
        }
        if(currentType === 'Boutique'){
            var sbo = document.getElementById('surfaceBoutique');
            if(!sbo.value || parseInt(sbo.value) <= 0){ setErr(sbo,'Indiquez la surface.'); return false; }
            clearErr(sbo);
        }
        syncSurfaceTotale();
        return true;
    }
    if(n === 4){
        if(isAnalyzingImages){ setImgErrorMessage('Analyse IA des images en cours…'); upz.scrollIntoView({behavior:'smooth',block:'center'}); return false; }
        if(aFiles.length === 0){ setImgErrorMessage('Au moins une photo est obligatoire.'); upz.scrollIntoView({behavior:'smooth',block:'center'}); return false; }
        return true;
    }
    /* Étape 5 : description toujours facultative */
    if(n === 5){ return true; }

    if(n === 6){
        var pEl = document.getElementById('prix');
        var pv  = pEl.value.replace(/\s/g,'');
        if(!pv || isNaN(parseFloat(pv)) || parseFloat(pv) <= 0){
            setErr(pEl,'Veuillez saisir un prix valide.');
            document.getElementById('prixErr').style.display='block';
            document.getElementById('fgPrix').classList.add('err');
            return false;
        }
        clearErr(pEl);
        document.getElementById('prixErr').style.display='none';
        document.getElementById('fgPrix').classList.remove('err');
        return true;
    }
    return true;
}

/* ══════════════════════════════════════
   RÉCAPITULATIF
══════════════════════════════════════ */
function fillRecap(){
    syncSurfaceTotale();
    var g  = function(id){ var e=document.getElementById(id); return e?e.value:'—'; };
    var oc = function(gid){ var c=document.querySelector('#'+gid+' .oc.s input'); return c?c.value:'—'; };
    var isResid   = (currentType==='Maison' || currentType==='Appartement');
    var isTerrain = (currentType==='Terrain');

    document.getElementById('rc-type').textContent = oc('typeGrid');
    document.getElementById('rc-cat').textContent  = (oc('catGrid')==='louer')?'À louer':'À vendre';
    document.getElementById('rc-dep').textContent  = dSel.selectedIndex>0 ? dSel.options[dSel.selectedIndex].text : '—';
    document.getElementById('rc-com').textContent  = cSel.selectedIndex>0 ? cSel.options[cSel.selectedIndex].text : '—';
    document.getElementById('rc-qrt').textContent  = qIn.value || '—';

    var lat = geoLat.value; var lng = geoLng.value;
    document.getElementById('rc-geo').textContent = (lat && lng) ? lat+', '+lng : 'Non renseignée';

    var sv = '—';
    if(isResid && g('surface') && g('surface')!=='0')                                    sv = g('surface')+' m²';
    if(isTerrain && g('surfaceTerrain') && g('surfaceTerrain')!=='0')                     sv = g('surfaceTerrain')+' m²';
    if(currentType==='Bureaux' && g('surfaceBureau') && g('surfaceBureau')!=='0')         sv = g('surfaceBureau')+' m²';
    if(currentType==='Boutique' && g('surfaceBoutique') && g('surfaceBoutique')!=='0')    sv = g('surfaceBoutique')+' m²';
    document.getElementById('rc-surf').textContent = sv;

    document.querySelectorAll('.rc-resid').forEach(function(r){ r.style.display=isResid?'':'none'; });
    document.querySelectorAll('.rc-terrain').forEach(function(r){ r.style.display=isTerrain?'':'none'; });
    document.querySelectorAll('.rc-non-terrain').forEach(function(r){ r.style.display=isTerrain?'none':''; });

    if(isResid){
        document.getElementById('rc-salon').textContent        = g('nombreSalon');
        document.getElementById('rc-chambre').textContent      = g('nombreChambre');
        document.getElementById('rc-cuisine').textContent      = g('nombreCuisine');
        document.getElementById('rc-sdb').textContent          = g('nombreSalleBain');
        document.getElementById('rc-pieces').textContent       = g('nombrePieces');
        document.getElementById('rc-park').textContent         = g('packing') || '—';
        document.getElementById('rc-sanitaire').textContent    = g('sanitaire') || '—';
        document.getElementById('rc-compteur-eau').textContent = g('compteurEauVal') || '—';
        document.getElementById('rc-compteur-elec').textContent= g('compteurElecVal') || '—';
    }
    if(isTerrain){
        document.getElementById('rc-titre').textContent       = g('titre_foncier') || '—';
        document.getElementById('rc-superficie').textContent  = g('surfaceTerrain') ? g('surfaceTerrain')+' m²' : '—';
        var autresEl = document.getElementById('autresCaracteristiquesTerrain');
        var autresTxt = autresEl && autresEl.value.trim() ? autresEl.value.trim() : '—';
        document.getElementById('rc-autres-carac').textContent = autresTxt;
    }

    document.getElementById('rc-prix').textContent = g('prix')+' FCFA';
    document.getElementById('rc-neg').textContent  = g('negociable');
    if(!isTerrain) document.getElementById('rc-cau').textContent = g('caution');

    var eqList = [];
    document.querySelectorAll('.eq.s').forEach(function(e){
        var par = e.closest('.type-block');
        if(par && par.classList.contains('d-none')) return;
        var sp = e.querySelector('span'); if(sp) eqList.push(sp.textContent.trim());
    });
    document.getElementById('rc-eq').textContent = eqList.length ? eqList.join(', ') : 'Aucun';
}

/* ══════════════════════════════════════
   SOUMISSION — PAIEMENT 5000 FCFA
══════════════════════════════════════ */
function submitAnnonce(transactionId){
    syncSurfaceTotale();
    var formData = new FormData(document.getElementById('form'));
    if(transactionId) formData.append('transactionId', transactionId);
    formData.delete('images[]');
    aFiles.forEach(function(f){ formData.append('images[]', f); });
    formData.delete('video');
    if(vidFile) formData.append('video', vidFile);

    $.ajax({
        url: saveRoute, method: 'POST',
        data: formData, contentType: false, processData: false,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success: function(res){
            var status = parseInt(res.status !== undefined ? res.status : res);
            if(status === 200){
                typeof showToast === 'function' && showToast('success','Annonce déposée avec succès');
                setTimeout(function(){ window.location.href = retourRoute; }, 4000);
            } else {
                alert('Erreur lors de la soumission. Veuillez réessayer.');
            }
        },
        error: function(xhr){
            var data       = xhr.responseJSON || {};
            var imageError = data.errors && data.errors.images && data.errors.images.length ? data.errors.images[0] : null;
            if(imageError){
                imgErr.textContent = imageError; imgErr.style.display='block'; upz.style.borderColor='var(--red)';
                goTo(4); upz.scrollIntoView({behavior:'smooth',block:'center'});
                return;
            }
            alert('Erreur serveur : '+xhr.status);
        }
    });
}

/* Nouveau flux : on sauvegarde d'abord, puis on lance le paiement (si requis).
   - Première annonce gratuite : on active directement lors de la sauvegarde.
   - Sinon : on crée l'annonce (statut=false) puis on lance Kkiapay ; à la réussite
     on appelle `/paiement-success/{appartmentId}` pour activer et envoyer le mail.
*/
var currentAppartementId = null;

addSuccessListener(function(response){
    $('#staticBackdrop2').modal('hide');
    var txId = response && response.transactionId ? response.transactionId : null;
    if(!currentAppartementId){ alert('Identifiant d\'annonce manquant. Rafraîchissez la page.'); return; }

    $.ajax({
        url: '/paiement-success/' + currentAppartementId,
        method: 'POST',
        data: { transactionId: txId, _token: $('meta[name="csrf-token"]').attr('content') },
        success: function(res){
            showToast && showToast('success','Paiement confirmé, annonce activée');
            setTimeout(function(){ window.location.href = retourRoute; }, 2000);
        },
        error: function(xhr){
            console.error(xhr.responseText);
            alert('Erreur lors de la confirmation de paiement. Contactez le support.');
        }
    });
});
addFailedListener(function(){ alert('Paiement échoué. Veuillez réessayer.'); });

/* submitForm global : sauvegarde initiale */
window.submitForm = function(){
    syncSurfaceTotale();
    var ok  = true;
    if(!dSel.value)                    { setErr(dSel,'Veuillez sélectionner un département.'); ok=false; }
    if(!cSel.value)                    { setErr(cSel,'Veuillez sélectionner une commune.');    ok=false; }
    if(qIn.value.trim().length < 2)    { setErr(qIn,'Quartier requis.');                       ok=false; }
    var pEl = document.getElementById('prix');
    var pv  = pEl ? pEl.value.replace(/\s/g,'') : '';
    if(!pv || isNaN(parseFloat(pv)) || parseFloat(pv) <= 0){ if(pEl) setErr(pEl,'Prix invalide.'); ok=false; }
    if(isAnalyzingImages)              { setImgErrorMessage('Analyse IA des images en cours…'); ok=false; }
    if(aFiles.length === 0)            { setImgErrorMessage('Au moins une photo est obligatoire.'); ok=false; }
    if(!ok) return;

    fillRecap();

    // Préparer les données et sauvegarder l'annonce (statut inactive si paiement requis)
    var formData = new FormData(document.getElementById('form'));
    formData.delete('images[]');
    aFiles.forEach(function(f){ formData.append('images[]', f); });
    // Si première annonce gratuite, demander activation immédiate
    if(isFirstTime === true){ formData.append('activate', '1'); }

    $.ajax({
        url: saveRoute, method: 'POST', data: formData,
        contentType: false, processData: false,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success: function(res){
            var status = parseInt(res.status !== undefined ? res.status : res);
            if(status === 200){
                var appId = res.appartement_id || res.id;
                if(isFirstTime === true){
                    showToast && showToast('success','Annonce déposée et publiée (offre gratuite)');
                    setTimeout(function(){ window.location.href = retourRoute; }, 2000);
                    return;
                }

                // Sauvegarde OK, on lance le widget Kkiapay pour paiement
                currentAppartementId = appId;
                var frais = 5000; // ou calculer selon la durée
                var ctnr = document.getElementById('payerContainer'); ctnr.innerHTML = '';
                var kk = document.createElement('kkiapay-widget');
                kk.setAttribute('amount', String(frais));
                kk.setAttribute('key','a7f1e5c0652811efbf02478c5adba4b8');
                kk.setAttribute('position','center');
                kk.setAttribute('sandbox','true');
                ctnr.appendChild(kk);
                $('#staticBackdrop2').modal('show');
            } else {
                alert('Erreur lors de la sauvegarde. Veuillez réessayer.');
            }
        },
        error: function(xhr){
            console.error(xhr.responseText);
            alert('Erreur serveur : '+xhr.status+'. Veuillez réessayer.');
        }
    });
};

updateMobileProgress(1);
})();
</script>

@endsection
