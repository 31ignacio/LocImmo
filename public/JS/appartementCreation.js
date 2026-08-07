@extends('layouts.master')

@section('content')

    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800&family=Lora:ital,wght@0,600;1,400&family=JetBrains+Mono:wght@500&display=swap" rel="stylesheet">

    <style>
        :root{
            --or:#F57C00;--or-lt:#FFF8F0;--or-mid:#FFE0B2;--or-dk:#D96A00;
            --green:#15803d;--green-lt:#f0fdf4;--green-b:#bbf7d0;
            --red:#dc2626;--red-lt:#fff5f5;
            --bg:#F4F5F9;--white:#FFFFFF;
            --ink:#141519;--ink2:#3E4150;--ink3:#8B90A0;
            --bord:#E2E5EF;--bord2:#ECEEF5;
            --r:12px;--r-lg:18px;--r-xl:24px;
            --sh:0 2px 12px rgba(0,0,0,.06);
            --sh-md:0 4px 20px rgba(0,0,0,.08);
        }
        *{box-sizing:border-box;}
        body{font-family:'Sora',sans-serif;background:var(--bg);color:var(--ink);-webkit-font-smoothing:antialiased;}

        /* ══════════════════════════ LAYOUT ══════════════════════════ */
        .sl-wrap{display:-webkit-box;display:-ms-flexbox;display:flex;min-height:calc(100vh - 72px);}

        /* ══════════════════════════ SIDEBAR ══════════════════════════ */
        .sl-side{
            width:268px;-ms-flex-negative:0;flex-shrink:0;
            background:var(--white);border-right:1px solid var(--bord);
            padding:32px 0 40px;
            position:sticky;top:72px;
            height:calc(100vh - 72px);overflow-y:auto;
        }
        .sl-side-ttl{
            font-size:11.5px;font-weight:800;color:var(--ink3);
            text-transform:uppercase;letter-spacing:.1em;
            padding:0 26px;margin-bottom:20px;
        }
        .sl-list{list-style:none;padding:0;margin:0;position:relative;}
        .sl-list::before{
            content:'';position:absolute;
            left:39px;top:22px;bottom:22px;
            width:2px;background:var(--bord2);z-index:0;
        }
        .sl-item{
            display:-webkit-box;display:-ms-flexbox;display:flex;
            -webkit-box-align:center;-ms-flex-align:center;align-items:center;
            gap:13px;padding:11px 24px;cursor:pointer;
            position:relative;z-index:1;
            border-right:3px solid transparent;
            -webkit-transition:background .15s;transition:background .15s;
        }
        .sl-item:hover{background:var(--bg);}
        .sl-item.active{background:var(--or-lt);border-right-color:var(--or);}

        .si-dot{
            width:28px;height:28px;border-radius:50%;-ms-flex-negative:0;flex-shrink:0;
            border:2px solid var(--bord2);background:var(--white);
            display:-webkit-box;display:-ms-flexbox;display:flex;
            -webkit-box-align:center;-ms-flex-align:center;align-items:center;
            -webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;
            font-size:11px;font-weight:700;color:var(--ink3);
            font-family:'JetBrains Mono',monospace;
            position:relative;z-index:2;
            -webkit-transition:all .25s;transition:all .25s;
        }
        .sl-item.active .si-dot{background:var(--ink);border-color:var(--ink);color:#fff;}
        .sl-item.done  .si-dot{background:var(--green);border-color:var(--green);color:#fff;}
        .sl-item.done  .si-dot::after{content:'\f00c';font-family:'FontAwesome';font-size:10px;}
        .sl-item.done  .si-num{display:none;}

        .si-txt{-webkit-box-flex:1;-ms-flex:1;flex:1;}
        .si-name{font-size:13.5px;font-weight:600;color:var(--ink2);display:block;-webkit-transition:color .15s;transition:color .15s;}
        .sl-item.active .si-name{color:var(--or);font-weight:700;}
        .sl-item.done   .si-name{color:var(--green);}
        .si-st{font-size:11px;color:var(--ink3);display:block;margin-top:1px;}
        .sl-item.done  .si-st{color:var(--green);}

        .si-arr{color:var(--bord);font-size:10px;-ms-flex-negative:0;flex-shrink:0;-webkit-transition:color .15s;transition:color .15s;}
        .sl-item.active .si-arr{color:var(--or);}
        .sl-item.done   .si-arr{color:var(--green);}

        /* ══════════════════════════ MAIN ══════════════════════════ */
        .sl-main{
            -webkit-box-flex:1;-ms-flex:1;flex:1;
            padding:40px 52px 80px;
            max-width:820px;min-width:0;
        }
        .sp-lbl{font-size:12.5px;font-weight:600;color:var(--ink3);display:block;margin-bottom:8px;}
        .sp-title{font-family:'Lora',serif;font-size:26px;font-weight:600;color:var(--ink);margin:0 0 5px;letter-spacing:-.025em;line-height:1.22;}
        .sp-sub{font-size:13px;color:var(--ink3);margin:0 0 30px;}
        .sp-sub i{color:var(--or);font-size:9px;margin-right:3px;}

        .sl-pane{display:none;-webkit-animation:pIn .3s ease;animation:pIn .3s ease;}
        .sl-pane.active{display:block;}
        @-webkit-keyframes pIn{from{opacity:0;-webkit-transform:translateX(10px);transform:translateX(10px);}to{opacity:1;-webkit-transform:none;transform:none;}}
        @keyframes pIn{from{opacity:0;transform:translateX(10px);}to{opacity:1;transform:none;}}

        /* ══════════════════════════ RECTANGLE SECTION ══════════════════════════ */
        .s-box{
            background:var(--white);
            border:1.5px solid var(--bord);
            border-radius:var(--r-xl);
            padding:26px 28px;
            margin-bottom:20px;
            -webkit-transition:border-color .2s,box-shadow .2s;
            transition:border-color .2s,box-shadow .2s;
            box-shadow:var(--sh);
        }
        .s-box:focus-within{border-color:rgba(245,124,0,.35);box-shadow:0 0 0 3px rgba(245,124,0,.06);}
        .s-box-title{
            font-size:13px;font-weight:800;color:var(--ink);
            text-transform:uppercase;letter-spacing:.08em;
            margin-bottom:20px;
            display:-webkit-box;display:-ms-flexbox;display:flex;
            -webkit-box-align:center;-ms-flex-align:center;align-items:center;
            gap:8px;
        }
        .s-box-title .bt-ico{
            width:28px;height:28px;border-radius:8px;
            background:var(--or-lt);color:var(--or);
            display:-webkit-inline-box;display:-ms-inline-flexbox;display:inline-flex;
            -webkit-box-align:center;-ms-flex-align:center;align-items:center;
            -webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;
            font-size:12px;-ms-flex-negative:0;flex-shrink:0;
        }
        .s-box-title::after{content:'';-webkit-box-flex:1;-ms-flex:1;flex:1;height:1px;background:var(--bord2);margin-left:10px;}

        /* ══════════════════════════ OPTION CARDS ══════════════════════════ */
        .oc-row{display:-webkit-box;display:-ms-flexbox;display:flex;gap:10px;-ms-flex-wrap:wrap;flex-wrap:wrap;}
        .oc{
            -webkit-box-flex:1;-ms-flex:1;flex:1;min-width:90px;max-width:160px;
            border-radius:var(--r-lg);border:2px solid var(--bord);background:var(--white);
            padding:18px 10px 14px;text-align:center;cursor:pointer;
            position:relative;-webkit-transition:all .22s;transition:all .22s;
        }
        .oc:hover{border-color:var(--ink3);}
        .oc.s{border-color:var(--ink);box-shadow:0 0 0 1px var(--ink);}
        .oc input{display:none;}
        .oc i{font-size:24px;color:var(--ink3);display:block;margin-bottom:9px;-webkit-transition:color .2s;transition:color .2s;}
        .oc.s i{color:var(--ink);}
        .oc span{font-size:12.5px;font-weight:700;color:var(--ink2);display:block;}
        .oc.s span{color:var(--ink);}
        .oc-tick{
            position:absolute;top:8px;right:8px;
            width:16px;height:16px;border-radius:4px;
            border:2px solid var(--bord2);background:var(--white);
            -webkit-transition:all .18s;transition:all .18s;
        }
        .oc.s .oc-tick{background:var(--ink);border-color:var(--ink);}
        .oc.s .oc-tick::after{content:'\f00c';font-family:'FontAwesome';font-size:8px;color:#fff;display:block;text-align:center;line-height:12px;}

        /* ══════════════════════════ FORM FIELDS ══════════════════════════ */
        .fg{margin-bottom:0;}
        .fg + .fg{margin-top:18px;}
        .fg label{
            display:block;font-size:13px;font-weight:600;
            color:var(--ink2);margin-bottom:6px;
        }
        .fg .f-hint{font-size:11.5px;color:var(--ink3);margin-bottom:6px;display:block;}
        .fg input[type="text"],
        .fg input[type="number"],
        .fg input[type="date"],
        .fg select,
        .fg textarea{
            display:block;width:100%;
            padding:12px 16px;
            border-radius:var(--r);
            border:1.5px solid var(--bord);
            background:#FAFBFC;
            font-size:14px;font-family:'Sora',sans-serif;color:var(--ink);
            outline:none;height:auto;-webkit-appearance:none;-moz-appearance:none;
            -webkit-transition:border-color .2s,background .2s,box-shadow .2s;
            transition:border-color .2s,background .2s,box-shadow .2s;
            box-shadow:none;
        }
        .fg input:focus,.fg select:focus,.fg textarea:focus{
            border-color:var(--or);background:var(--white);
            box-shadow:0 0 0 3px rgba(245,124,0,.1);
        }
        .fg textarea{min-height:130px;resize:vertical;}
        .fg .ferr{font-size:12px;color:var(--red);margin-top:5px;display:none;}
        .fg.err input,.fg.err select{border-color:var(--red);}
        .fg.err .ferr{display:block;}

        /* Suffix input */
        .fi{position:relative;}
        .fi input{padding-right:52px;}
        .fi-sfx{position:absolute;top:50%;right:14px;-webkit-transform:translateY(-50%);transform:translateY(-50%);font-size:13px;font-weight:600;color:var(--ink3);}

        /* ══════════════════════════ COMPTEURS ══════════════════════════ */
        .ctr{
            display:-webkit-inline-box;display:-ms-inline-flexbox;display:inline-flex;
            -webkit-box-align:center;-ms-flex-align:center;align-items:center;
            border:1.5px solid var(--bord);border-radius:var(--r);overflow:hidden;
            background:#FAFBFC;
        }
        .cb{
            width:42px;height:46px;border:none;background:none;
            font-size:20px;font-weight:300;color:var(--ink2);cursor:pointer;
            display:-webkit-box;display:-ms-flexbox;display:flex;
            -webkit-box-align:center;-ms-flex-align:center;align-items:center;
            -webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;
            -webkit-transition:background .15s,color .15s;transition:background .15s,color .15s;
        }
        .cb:hover:not(:disabled){background:var(--or-lt);color:var(--or);}
        .cb:disabled{opacity:.25;cursor:not-allowed;}
        .cv{
            width:52px;text-align:center;
            border:none;border-left:1px solid var(--bord);border-right:1px solid var(--bord);
            background:none;font-size:16px;font-weight:700;color:var(--ink);
            font-family:'JetBrains Mono',monospace;padding:0;height:46px;
            -webkit-appearance:none;outline:none;
        }

        /* ══════════════════════════ OUI / NON ══════════════════════════ */
        .yn{display:-webkit-box;display:-ms-flexbox;display:flex;gap:8px;}
        .yn-b{
            padding:10px 24px;border-radius:30px;
            border:2px solid var(--bord);background:var(--white);
            font-size:13.5px;font-weight:700;color:var(--ink2);
            cursor:pointer;-webkit-transition:all .2s;transition:all .2s;
            font-family:'Sora',sans-serif;
        }
        .yn-b:hover{border-color:var(--ink3);}
        .yn-b.s{background:var(--ink);border-color:var(--ink);color:#fff;}

        /* ══════════════════════════ ÉQUIPEMENT CARDS ══════════════════════════ */
        .eq-row{display:-webkit-box;display:-ms-flexbox;display:flex;gap:10px;-ms-flex-wrap:wrap;flex-wrap:wrap;}
        .eq{
            width:140px;border-radius:var(--r-lg);border:2px solid var(--bord);
            background:var(--white);padding:18px 12px 14px;
            text-align:center;cursor:pointer;position:relative;
            -webkit-transition:all .22s;transition:all .22s;
        }
        .eq:hover{border-color:var(--ink3);}
        .eq.s{border-color:var(--ink);box-shadow:0 0 0 1px var(--ink);}
        .eq input{display:none;}
        .eq i{font-size:22px;color:var(--ink3);display:block;margin-bottom:8px;-webkit-transition:color .2s;transition:color .2s;}
        .eq.s i{color:var(--ink);}
        .eq span{font-size:12px;font-weight:600;color:var(--ink2);display:block;}
        .eq-tick{position:absolute;top:8px;right:8px;width:16px;height:16px;border-radius:4px;border:2px solid var(--bord2);background:var(--white);}
        .eq.s .eq-tick{background:var(--ink);border-color:var(--ink);}
        .eq.s .eq-tick::after{content:'\f00c';font-family:'FontAwesome';font-size:8px;color:#fff;display:block;text-align:center;line-height:12px;}

        /* ══════════════════════════ DISPO CHECKBOX ══════════════════════════ */
        .dispo-row{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center;gap:14px;-ms-flex-wrap:wrap;flex-wrap:wrap;}
        .dispo-lbl{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center;gap:8px;cursor:pointer;}
        .dispo-lbl input{display:none;}
        .d-box{width:20px;height:20px;border-radius:5px;border:2px solid var(--bord);background:var(--white);display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;-webkit-transition:all .18s;transition:all .18s;-ms-flex-negative:0;flex-shrink:0;}
        .dispo-lbl.on .d-box{background:var(--ink);border-color:var(--ink);}
        .dispo-lbl.on .d-box::after{content:'\f00c';font-family:'FontAwesome';font-size:10px;color:#fff;}
        .dispo-lbl .d-txt{font-size:13.5px;font-weight:600;color:var(--ink2);}

        /* ══════════════════════════ UPLOAD ══════════════════════════ */
        .upz{
            border:2px dashed var(--bord);border-radius:var(--r-xl);
            background:#FAFBFC;padding:46px 20px;text-align:center;cursor:pointer;
            -webkit-transition:border-color .2s,background .2s;transition:border-color .2s,background .2s;
        }
        .upz:hover,.upz.dz{border-color:var(--or);background:var(--or-lt);}
        .upz i{font-size:38px;color:var(--ink3);display:block;margin-bottom:12px;}
        .upz p{font-size:14.5px;font-weight:600;color:var(--ink2);margin:0 0 4px;}
        .upz small{font-size:12px;color:var(--ink3);}
        .prev-g{display:-webkit-box;display:-ms-flexbox;display:flex;gap:10px;-ms-flex-wrap:wrap;flex-wrap:wrap;margin-top:16px;}
        .pv{width:96px;height:96px;border-radius:10px;overflow:hidden;position:relative;border:1.5px solid var(--bord);}
        .pv img{width:100%;height:100%;object-fit:cover;display:block;}
        .pv-del{position:absolute;top:4px;right:4px;width:20px;height:20px;border-radius:50%;background:rgba(20,21,25,.75);color:#fff;border:none;font-size:10px;cursor:pointer;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;}

        /* ══════════════════════════ RÉCAPITULATIF ══════════════════════════ */
        .rc-blk{background:var(--white);border:1.5px solid var(--bord);border-radius:var(--r-xl);margin-bottom:16px;overflow:hidden;box-shadow:var(--sh);}
        .rc-hd{padding:14px 22px;border-bottom:1px solid var(--bord2);display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center;gap:9px;background:#FAFBFC;}
        .rc-hd i{color:var(--or);font-size:14px;}
        .rc-hd span{font-size:13.5px;font-weight:700;color:var(--ink);}
        .rc-bd{padding:14px 22px;}
        .rc-row{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between;-webkit-box-align:center;-ms-flex-align:center;align-items:center;padding:8px 0;border-bottom:1px dashed var(--bord2);font-size:13.5px;}
        .rc-row:last-child{border-bottom:none;}
        .rk{color:var(--ink3);font-weight:500;}
        .rv{font-weight:700;color:var(--ink);}
        .rv.price{color:var(--or);font-family:'JetBrains Mono',monospace;}

        /* Alerte recap */
        .rc-alert{background:var(--or-lt);border:1px solid var(--or-mid);border-radius:var(--r);padding:14px 16px;font-size:13px;color:var(--ink2);display:-webkit-box;display:-ms-flexbox;display:flex;gap:10px;-webkit-box-align:flex-start;-ms-flex-align:flex-start;align-items:flex-start;margin-bottom:20px;}
        .rc-alert i{color:var(--or);-ms-flex-negative:0;flex-shrink:0;margin-top:1px;}

        /* ══════════════════════════ NAVIGATION ══════════════════════════ */
        .sl-nav{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between;-webkit-box-align:center;-ms-flex-align:center;align-items:center;margin-top:32px;padding-top:24px;border-top:1px solid var(--bord2);}
        .btn-prev{display:-webkit-inline-box;display:-ms-inline-flexbox;display:inline-flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center;gap:7px;padding:12px 24px;border-radius:10px;border:2px solid var(--bord);background:var(--white);color:var(--ink2);font-size:13.5px;font-weight:600;font-family:'Sora',sans-serif;cursor:pointer;-webkit-transition:all .2s;transition:all .2s;}
        .btn-prev:hover{border-color:var(--ink);color:var(--ink);}
        .btn-prev:disabled{opacity:.3;cursor:not-allowed;}
        .btn-next{display:-webkit-inline-box;display:-ms-inline-flexbox;display:inline-flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center;gap:8px;padding:13px 30px;border-radius:10px;border:none;background:var(--ink);color:#fff;font-size:13.5px;font-weight:700;font-family:'Sora',sans-serif;cursor:pointer;-webkit-transition:all .22s;transition:all .22s;}
        .btn-next:hover{background:var(--or);-webkit-transform:translateY(-1px);transform:translateY(-1px);box-shadow:0 6px 18px rgba(245,124,0,.3);}

        /* ══════════════════════════ MODAL ══════════════════════════ */
        .modal-content{border:none;border-radius:18px;box-shadow:0 20px 60px rgba(0,0,0,.15);overflow:hidden;font-family:'Sora',sans-serif;}
        .modal-header{background:var(--ink);border-bottom:none;padding:20px 24px;}
        .modal-header h3{color:#fff;font-size:15px;font-weight:700;margin:0;}
        .modal-body{padding:24px;}
        .modal-footer{padding:14px 24px;border-top:1px solid var(--bord2);display:-webkit-box;display:-ms-flexbox;display:flex;gap:10px;-webkit-box-pack:end;-ms-flex-pack:end;justify-content:flex-end;}
        .f-row{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between;-webkit-box-align:center;-ms-flex-align:center;align-items:center;padding:12px 0;border-bottom:1px dashed var(--bord2);font-size:14px;}
        .f-row:last-child{border-bottom:none;}
        .fk{color:var(--ink3);}
        .fv{font-weight:700;color:var(--ink);}
        .fv.p{color:var(--or);font-family:'JetBrains Mono',monospace;font-size:17px;}
        .f-warn{background:var(--red-lt);border:1px solid rgba(220,38,38,.2);border-radius:var(--r);padding:11px 14px;font-size:12.5px;color:var(--red);font-weight:600;margin-top:14px;display:-webkit-box;display:-ms-flexbox;display:flex;gap:8px;-webkit-box-align:center;-ms-flex-align:center;align-items:center;}
        .btn-ann{padding:11px 22px;border-radius:10px;border:1.5px solid var(--bord);background:var(--white);color:var(--ink2);font-size:13px;font-weight:600;font-family:'Sora',sans-serif;cursor:pointer;}
        .btn-ann:hover{border-color:var(--red);color:var(--red);}

        /* ══════════════════════════ AUTOCOMPLETE ══════════════════════════ */
        #quartierSuggestions{position:absolute;top:100%;left:0;right:0;max-height:180px;overflow-y:auto;z-index:999;background:var(--white);border-radius:var(--r);border:1px solid var(--bord);box-shadow:0 8px 24px rgba(0,0,0,.1);display:none;margin-top:4px;list-style:none;padding:6px;}
        #quartierSuggestions li{padding:10px 12px;font-size:13.5px;cursor:pointer;border-radius:8px;-webkit-transition:background .12s;transition:background .12s;}
        #quartierSuggestions li:hover{background:var(--bg);}

        /* champ caché pour les non-visibles */
        .d-none{display:none!important;}

        /* ══════════════════════════ RESPONSIVE ══════════════════════════ */
        @media(max-width:991px){.sl-side{display:none;}.sl-main{padding:28px 20px 60px;max-width:100%;}}
        @media(max-width:767px){.sl-main{padding:20px 14px 50px;}.oc{min-width:70px;}.eq{width:120px;}}
    </style>

{{-- ════════════ PAGE ════════════ --}}
<div class="sl-wrap">

    {{-- ── SIDEBAR ── --}}
    <aside class="sl-side">
        <div class="sl-side-ttl">Étapes de création</div>
        <ul class="sl-list" id="slList">
            <li class="sl-item active" data-step="1"><div class="si-dot"><span class="si-num">1</span></div><div class="si-txt"><span class="si-name">Type de bien</span><span class="si-st">En cours</span></div><i class="fa fa-chevron-right si-arr"></i></li>
            <li class="sl-item"        data-step="2"><div class="si-dot"><span class="si-num">2</span></div><div class="si-txt"><span class="si-name">Adresse</span><span class="si-st">À compléter</span></div><i class="fa fa-chevron-right si-arr"></i></li>
            <li class="sl-item"        data-step="3"><div class="si-dot"><span class="si-num">3</span></div><div class="si-txt"><span class="si-name">Caractéristiques</span><span class="si-st">À compléter</span></div><i class="fa fa-chevron-right si-arr"></i></li>
            <li class="sl-item"        data-step="4"><div class="si-dot"><span class="si-num">4</span></div><div class="si-txt"><span class="si-name">Photos</span><span class="si-st">À compléter</span></div><i class="fa fa-chevron-right si-arr"></i></li>
            <li class="sl-item"        data-step="5"><div class="si-dot"><span class="si-num">5</span></div><div class="si-txt"><span class="si-name">Description</span><span class="si-st">À compléter</span></div><i class="fa fa-chevron-right si-arr"></i></li>
            <li class="sl-item"        data-step="6"><div class="si-dot"><span class="si-num">6</span></div><div class="si-txt"><span class="si-name">Prix</span><span class="si-st">À compléter</span></div><i class="fa fa-chevron-right si-arr"></i></li>
            <li class="sl-item"        data-step="7"><div class="si-dot"><span class="si-num">7</span></div><div class="si-txt"><span class="si-name">Récapitulatif</span><span class="si-st">À compléter</span></div><i class="fa fa-chevron-right si-arr"></i></li>
        </ul>
    </aside>

    {{-- ── MAIN ── --}}
    <main class="sl-main">
    <form id="form" enctype="multipart/form-data" novalidate>
    @csrf

    {{-- ═══════ ÉTAPE 1 — Type de bien ═══════ --}}
    <div class="sl-pane active" id="pane1">
        <span class="sp-lbl">Étape 1 sur 7</span>
        <h1 class="sp-title">Quel type de bien souhaitez-vous publier ?</h1>
        <p class="sp-sub"><i class="fa fa-asterisk"></i> Information obligatoire</p>

        <div class="s-box">
            <div class="s-box-title"><div class="bt-ico"><i class="fa fa-home"></i></div> Type de bien</div>
            <div class="oc-row" id="typeGrid">
                <label class="oc s" data-v="Maison"><input type="radio" name="type" value="Maison" checked><div class="oc-tick"></div><i class="fa fa-home"></i><span>Maison</span></label>
                <label class="oc" data-v="Appartement"><input type="radio" name="type" value="Appartement"><div class="oc-tick"></div><i class="fa fa-building"></i><span>Appartement</span></label>
                <label class="oc" data-v="Bureaux"><input type="radio" name="type" value="Bureaux"><div class="oc-tick"></div><i class="fa fa-briefcase"></i><span>Bureau</span></label>
                <label class="oc" data-v="Boutique"><input type="radio" name="type" value="Boutique"><div class="oc-tick"></div><i class="fa fa-shopping-bag"></i><span>Boutique</span></label>
            </div>
        </div>

        <div class="s-box">
            <div class="s-box-title"><div class="bt-ico"><i class="fa fa-tag"></i></div> Vous souhaitez</div>
            <div class="oc-row" id="catGrid" style="max-width:300px;">
                <label class="oc s" data-v="louer"><input type="radio" name="categorie" value="louer" checked><div class="oc-tick"></div><i class="fa fa-key"></i><span>Louer</span></label>
                <label class="oc" data-v="vendre"><input type="radio" name="categorie" value="vendre"><div class="oc-tick"></div><i class="fa fa-tag"></i><span>Vendre</span></label>
            </div>
        </div>

        <div class="s-box">
            <div class="s-box-title"><div class="bt-ico"><i class="fa fa-calendar"></i></div> Durée de publication</div>
            <div class="fg" style="max-width:240px;">
                <select name="duree" id="duree">
                    <option value="30 Jours">30 jours</option>
                    <option value="90 Jours">90 jours</option>
                </select>
            </div>
        </div>
    </div>

    {{-- ═══════ ÉTAPE 2 — Adresse ═══════ --}}
    <div class="sl-pane" id="pane2">
        <span class="sp-lbl">Étape 2 sur 7</span>
        <h1 class="sp-title">Où se situe votre bien ?</h1>
        <p class="sp-sub"><i class="fa fa-asterisk"></i> Information obligatoire</p>

        <div class="s-box">
            <div class="s-box-title"><div class="bt-ico"><i class="fa fa-map"></i></div> Département &amp; commune</div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="fg">
                        <label>Département <span style="color:var(--red)">*</span></label>
                        <select id="departementSelect" name="departement"><option value="">Sélectionner</option></select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="fg">
                        <label>Commune</label>
                        <select id="communeSelect" name="commune" disabled><option value="">Sélectionner d'abord</option></select>
                    </div>
                </div>
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
    </div>

    {{-- ═══════ ÉTAPE 3 — Caractéristiques (dynamique) ═══════ --}}
    
    <div class="sl-pane" id="pane3">
        <span class="sp-lbl">Étape 3 sur 7</span>
        <h1 class="sp-title">Précisez les caractéristiques</h1>
        <p class="sp-sub"><i class="fa fa-asterisk"></i> Les champs affichés correspondent au type de bien sélectionné</p>

        {{-- Bloc : surface + pièces (tous sauf boutique) --}}
        <div class="s-box type-block" data-types="Maison,Appartement,Bureaux">
            <div class="s-box-title"><div class="bt-ico"><i class="fa fa-th-large"></i></div> Dimensions &amp; pièces</div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="fg">
                        <label>Surface habitable <span style="color:var(--red)">*</span></label>
                        <div class="fi">
                            <input type="number" name="surface" id="surface" placeholder="Ex: 60" min="1">
                            <span class="fi-sfx">m²</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="fg">
                        <label>Nombre de pièces <span style="color:var(--red)">*</span></label>
                        <div class="ctr">
                            <button type="button" class="cb" data-t="nombrePieces" data-a="-">−</button>
                            <input type="number" name="nombrePieces" id="nombrePieces" class="cv" value="1" min="1" readonly>
                            <button type="button" class="cb" data-t="nombrePieces" data-a="+">+</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Surface bureaux/boutique --}}
        <div class="s-box type-block" data-types="Boutique">
            <div class="s-box-title"><div class="bt-ico"><i class="fa fa-arrows-alt"></i></div> Surface</div>
            <div class="fg" style="max-width:200px;">
                <label>Surface (m²) <span style="color:var(--red)">*</span></label>
                <div class="fi">
                    <input type="number" name="surface_boutique" id="surfaceBoutique" placeholder="Ex: 30" min="1">
                    <span class="fi-sfx">m²</span>
                </div>
            </div>
        </div>

        {{-- Disponibilité (Maison, Appartement) --}}
        <div class="s-box type-block" data-types="Maison,Appartement">
            <div class="s-box-title"><div class="bt-ico"><i class="fa fa-calendar-check-o"></i></div> Disponibilité</div>
            <div class="fg">
                <label>Disponible à partir de</label>
                <div class="dispo-row">
                    <input type="date" name="disponible_date" id="dispoDate" style="max-width:200px;">
                    <label class="dispo-lbl" id="dispoImmedLbl">
                        <input type="checkbox" id="dispoImmed" name="dispo_immed" value="1">
                        <div class="d-box"></div>
                        <span class="d-txt">Disponible immédiatement</span>
                    </label>
                </div>
            </div>
        </div>

        {{-- Options Résidentiel (Maison, Appartement) --}}
        <div class="s-box type-block" data-types="Maison,Appartement">
            <div class="s-box-title"><div class="bt-ico"><i class="fa fa-home"></i></div> Options résidentielles</div>
            <div class="fg">
                <label>Meublé ?</label>
                <div class="yn" id="meubleSel"><button type="button" class="yn-b s" data-v="Meublé" data-t="meuble">Oui</button><button type="button" class="yn-b" data-v="Non meublé" data-t="meuble">Non</button><input type="hidden" name="meuble" id="meuble" value="Meublé"></div>
            </div>
            <div class="fg" style="margin-top:16px;">
                <label>Colocation possible ?</label>
                <div class="yn" id="collocSel"><button type="button" class="yn-b" data-v="Oui" data-t="collocation">Oui</button><button type="button" class="yn-b s" data-v="Non" data-t="collocation">Non</button><input type="hidden" name="collocation" id="collocation" value="Non"></div>
            </div>
            <div class="fg" style="margin-top:16px;">
                <label>Parking / Stationnement ?</label>
                <div class="yn" id="parkSel"><button type="button" class="yn-b" data-v="Oui" data-t="packing">Oui</button><button type="button" class="yn-b s" data-v="Non" data-t="packing">Non</button><input type="hidden" name="packing" id="packing" value="Non"></div>
            </div>
        </div>

        {{-- Options Bureaux --}}
        <div class="s-box type-block" data-types="Bureaux">
            <div class="s-box-title"><div class="bt-ico"><i class="fa fa-briefcase"></i></div> Options bureau</div>
            <div class="fg">
                <label>Parking / Stationnement ?</label>
                <div class="yn" id="parkBureauxSel"><button type="button" class="yn-b" data-v="Oui" data-t="packing_bureaux">Oui</button><button type="button" class="yn-b s" data-v="Non" data-t="packing_bureaux">Non</button><input type="hidden" name="packing_bureaux" id="packing_bureaux" value="Non"></div>
            </div>
        </div>

        {{-- Équipements Maison / Appartement --}}
        <div class="s-box type-block" data-types="Maison,Appartement">
            <div class="s-box-title"><div class="bt-ico"><i class="fa fa-plug"></i></div> Équipements <span style="font-size:11px;font-weight:400;color:var(--ink3);margin-left:6px;">(facultatif)</span></div>
            <div class="eq-row" id="eqResid">
                <label class="eq" data-n="cuisine" data-v="Oui"><input type="checkbox" name="cuisine" value="Oui"><div class="eq-tick"></div><i class="fa fa-cutlery"></i><span>Cuisine équipée</span></label>
                <label class="eq" data-n="clime_c" data-v="Climatiseur"><input type="checkbox" name="clime_c" value="Climatiseur"><div class="eq-tick"></div><i class="fa fa-snowflake-o"></i><span>Climatiseur</span></label>
                <label class="eq" data-n="brasseur" data-v="Oui"><input type="checkbox" name="brasseur" value="Oui"><div class="eq-tick"></div><i class="fa fa-circle-o-notch"></i><span>Brasseur d'air</span></label>
                <label class="eq" data-n="wifi_c" data-v="Wifi"><input type="checkbox" name="wifi_c" value="Wifi"><div class="eq-tick"></div><i class="fa fa-wifi"></i><span>Wifi</span></label>
                <label class="eq" data-n="securite" data-v="Oui"><input type="checkbox" name="securite_c" value="Oui"><div class="eq-tick"></div><i class="fa fa-shield"></i><span>Sécurité</span></label>
                <label class="eq" data-n="terasse" data-v="Oui"><input type="checkbox" name="terasse_c" value="Oui"><div class="eq-tick"></div><i class="fa fa-sun-o"></i><span>Terrasse</span></label>
                <label class="eq" data-n="entretien" data-v="Oui"><input type="checkbox" name="entretien_c" value="Oui"><div class="eq-tick"></div><i class="fa fa-magic"></i><span>Entretien inclus</span></label>
            </div>
        </div>

        {{-- Équipements Bureaux --}}
        <div class="s-box type-block" data-types="Bureaux">
            <div class="s-box-title"><div class="bt-ico"><i class="fa fa-plug"></i></div> Équipements bureau <span style="font-size:11px;font-weight:400;color:var(--ink3);margin-left:6px;">(facultatif)</span></div>
            <div class="eq-row">
                <label class="eq" data-n="clime_b" data-v="Climatiseur"><input type="checkbox" name="clime_b" value="Climatiseur"><div class="eq-tick"></div><i class="fa fa-snowflake-o"></i><span>Climatiseur</span></label>
                <label class="eq" data-n="wifi_b" data-v="Wifi"><input type="checkbox" name="wifi_b" value="Wifi"><div class="eq-tick"></div><i class="fa fa-wifi"></i><span>Wifi</span></label>
                <label class="eq" data-n="securite_b" data-v="Oui"><input type="checkbox" name="securite_b" value="Oui"><div class="eq-tick"></div><i class="fa fa-shield"></i><span>Sécurité</span></label>
                <label class="eq" data-n="parking_b" data-v="Oui"><input type="checkbox" name="parking_b" value="Oui"><div class="eq-tick"></div><i class="fa fa-car"></i><span>Parking</span></label>
            </div>
        </div>

        {{-- Équipements Boutique --}}
        <div class="s-box type-block" data-types="Boutique">
            <div class="s-box-title"><div class="bt-ico"><i class="fa fa-plug"></i></div> Équipements boutique <span style="font-size:11px;font-weight:400;color:var(--ink3);margin-left:6px;">(facultatif)</span></div>
            <div class="eq-row">
                <label class="eq" data-n="clime_bt" data-v="Climatiseur"><input type="checkbox" name="clime_bt" value="Climatiseur"><div class="eq-tick"></div><i class="fa fa-snowflake-o"></i><span>Climatiseur</span></label>
                <label class="eq" data-n="securite_bt" data-v="Oui"><input type="checkbox" name="securite_bt" value="Oui"><div class="eq-tick"></div><i class="fa fa-shield"></i><span>Sécurité</span></label>
                <label class="eq" data-n="parking_bt" data-v="Oui"><input type="checkbox" name="parking_bt" value="Oui"><div class="eq-tick"></div><i class="fa fa-car"></i><span>Parking</span></label>
            </div>
        </div>

        {{-- Champs hidden pour consolidation — mis à jour par JS au clic des cartes ── --}}
        <input type="hidden" name="clime"     id="hClime"     value="Non">
        <input type="hidden" name="wifi"      id="hWifi"      value="Non">
        <input type="hidden" name="securite"  id="hSecurite"  value="Non">
        <input type="hidden" name="terasse"   id="hTerasse"   value="Non">
        <input type="hidden" name="entretien" id="hEntretien" value="Non inclus">
        <input type="hidden" name="cuisine"   id="hCuisine"   value="Non">
        <input type="hidden" name="packing"   id="hPacking"   value="Non">
        <input type="hidden" name="nombreChambre" id="hChambre" value="0">
        <input type="hidden" name="nombreSalon"   id="hSalon"   value="0">
    </div>

    {{-- ═══════ ÉTAPE 4 — Photos ═══════ --}}
    <div class="sl-pane" id="pane4">
        <span class="sp-lbl">Étape 4 sur 7</span>
        <h1 class="sp-title">Ajoutez des photos de votre bien</h1>
        <p class="sp-sub">Les annonces avec photos reçoivent <strong>5× plus de contacts</strong></p>
        <div class="s-box">
            <div class="s-box-title"><div class="bt-ico"><i class="fa fa-camera"></i></div> Photos</div>
            <div class="upz" id="upz">
                <i class="fa fa-cloud-upload"></i>
                <p>Cliquez ou glissez vos photos ici</p>
                <small>JPG, PNG — <strong>max 5 Mo</strong> par image — <span style="color:var(--red);">obligatoire</span></small>
                <input type="file" name="images[]" id="images" accept="image/*" multiple style="display:none;">
            </div>
            <span class="ferr" id="imgErr" style="display:none;margin-top:10px;font-size:13px;"></span>
            <div class="prev-g" id="prevG"></div>
        </div>
    </div>

    {{-- ═══════ ÉTAPE 5 — Description ═══════ --}}
    <div class="sl-pane" id="pane5">
        <span class="sp-lbl">Étape 5 sur 7</span>
        <h1 class="sp-title">Décrivez votre bien</h1>
        <p class="sp-sub">Soyez précis : emplacement, accès, points forts, itinéraire…</p>
        <div class="s-box">
            <div class="s-box-title"><div class="bt-ico"><i class="fa fa-align-left"></i></div> Description <span style="color:var(--red)">*</span></div>
            <div class="fg">
                <textarea name="description" id="description" placeholder="Décrivez votre bien : emplacement, accès depuis un repère, commodités à proximité, caractéristiques importantes…"></textarea>
                <div style="text-align:right;margin-top:5px;">
                    <span id="descCt" style="font-size:11.5px;color:var(--ink3);">0 / 800</span>
                </div>
            </div>
        </div>
    </div>

    {{-- ═══════ ÉTAPE 6 — Prix ═══════ --}}
    <div class="sl-pane" id="pane6">
        <span class="sp-lbl">Étape 6 sur 7</span>
        <h1 class="sp-title">Définissez le prix</h1>
        <p class="sp-sub"><i class="fa fa-asterisk"></i> Information obligatoire</p>

        <div class="s-box">
            <div class="s-box-title"><div class="bt-ico"><i class="fa fa-money"></i></div> Prix de location / vente</div>
            <div class="fg" id="fgPrix">
                <label>Prix (FCFA) <span style="color:var(--red)">*</span></label>
                <div class="fi" style="max-width:260px;">
                    <input type="text" name="prix" id="prix" placeholder="Ex: 150 000" oninput="this.value=this.value.replace(/[^0-9\s]/g,'')">
                    <span class="fi-sfx">FCFA</span>
                </div>
                <span class="ferr" id="prixErr">Veuillez saisir un prix valide</span>
            </div>
            <div class="fg" style="margin-top:18px;">
                <label>Prix négociable ?</label>
                <div class="yn" id="negocSel">
                    <button type="button" class="yn-b" data-v="Oui" data-t="negociable">Oui</button>
                    <button type="button" class="yn-b s" data-v="Non" data-t="negociable">Non</button>
                    <button type="button" class="yn-b" data-v="Pour long séjour" data-t="negociable">Long séjour</button>
                    <input type="hidden" name="negociable" id="negociable" value="Non">
                </div>
            </div>
        </div>

        <div class="s-box">
            <div class="s-box-title"><div class="bt-ico"><i class="fa fa-shield"></i></div> Caution</div>
            <div class="fg" style="max-width:240px;">
                <select name="caution" id="caution">
                    <option value="0">Aucune caution</option>
                    <option value="1 Mois">1 mois</option>
                    <option value="3 Mois">3 mois</option>
                    <option value="6 Mois">6 mois</option>
                    <option value="A Negocier">À négocier</option>
                </select>
            </div>
        </div>
    </div>

    {{-- ═══════ ÉTAPE 7 — Récapitulatif ═══════ --}}
    <div class="sl-pane" id="pane7">
        <span class="sp-lbl">Étape 7 sur 7</span>
        <h1 class="sp-title">Vérifiez votre annonce</h1>
        <p class="sp-sub">Relisez toutes les informations avant de publier.</p>

        <div class="rc-alert"><i class="fa fa-info-circle fa-lg"></i><span>Une fois soumise, votre annonce sera visible après traitement du paiement.</span></div>

        <div class="rc-blk"><div class="rc-hd"><i class="fa fa-home"></i><span>Type de bien</span></div><div class="rc-bd">
            <div class="rc-row"><span class="rk">Type</span><span class="rv" id="rc-type">—</span></div>
            <div class="rc-row"><span class="rk">Catégorie</span><span class="rv" id="rc-cat">—</span></div>
            <div class="rc-row"><span class="rk">Durée</span><span class="rv" id="rc-duree">—</span></div>
        </div></div>

        <div class="rc-blk"><div class="rc-hd"><i class="fa fa-map-marker"></i><span>Adresse</span></div><div class="rc-bd">
            <div class="rc-row"><span class="rk">Département</span><span class="rv" id="rc-dep">—</span></div>
            <div class="rc-row"><span class="rk">Commune</span><span class="rv" id="rc-com">—</span></div>
            <div class="rc-row"><span class="rk">Quartier</span><span class="rv" id="rc-qrt">—</span></div>
        </div></div>

        <div class="rc-blk"><div class="rc-hd"><i class="fa fa-sliders"></i><span>Caractéristiques</span></div><div class="rc-bd">
            <div class="rc-row"><span class="rk">Surface</span><span class="rv" id="rc-surf">—</span></div>
            <div class="rc-row"><span class="rk">Pièces</span><span class="rv" id="rc-pieces">—</span></div>
            <div class="rc-row"><span class="rk">Meublé</span><span class="rv" id="rc-meu">—</span></div>
            <div class="rc-row"><span class="rk">Parking</span><span class="rv" id="rc-park">—</span></div>
            <div class="rc-row"><span class="rk">Équipements</span><span class="rv" id="rc-eq" style="font-size:12px;">—</span></div>
        </div></div>

        <div class="rc-blk"><div class="rc-hd"><i class="fa fa-money"></i><span>Prix</span></div><div class="rc-bd">
            <div class="rc-row"><span class="rk">Prix</span><span class="rv price" id="rc-prix">—</span></div>
            <div class="rc-row"><span class="rk">Négociable</span><span class="rv" id="rc-neg">—</span></div>
            <div class="rc-row"><span class="rk">Caution</span><span class="rv" id="rc-cau">—</span></div>
        </div></div>

        <div id="msg501"></div>
    </div>

    {{-- Navigation --}}
    <div class="sl-nav">
        <button type="button" class="btn-prev" id="btnPrev" disabled><i class="fa fa-arrow-left"></i> Précédent</button>
        <button type="button" class="btn-next" id="btnNext">Suivant <i class="fa fa-arrow-right"></i></button>
    </div>

    </form>
    </main>
</div>

{{-- MODAL --}}
<div class="modal fade" id="staticBackdrop2" data-backdrop="static" data-keyboard="false" tabindex="-1">
    <div class="modal-dialog"><div class="modal-content">
        <div class="modal-header"><h3>Récapitulatif de paiement</h3></div>
        <div class="modal-body">
            <div class="f-row"><span class="fk">Durée</span><span class="fv" id="showDuree">—</span></div>
            <div class="f-row"><span class="fk">Frais de publication</span><span class="fv p" id="fraisAnnonce">—</span></div>
            <div class="f-warn"><i class="fa fa-exclamation-triangle"></i> Cette somme est non remboursable.</div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-ann" data-dismiss="modal">Annuler</button>
            <span id="payerContainer"></span>
        </div>
    </div></div>
</div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.kkiapay.me/k.js"></script>
    <script>var saveRoute="{{route('appartement.store')}}";var retourRoute="{{route('home')}}";</script>

    <script>
        /* ════ ROUTES & CONFIG ════ */
        var saveRoute   = "{{ route('appartement.store') }}";
        var retourRoute = "{{ route('home') }}";
        var isFirstTime = @json($isFirstTime);

        (function(){

        /* ════════════════════════════════════════
        UTILITAIRES — rouge / reset
        ════════════════════════════════════════ */
        function setErr(el, msg){
            el.style.borderColor = 'var(--red)';
            el.style.boxShadow   = '0 0 0 3px rgba(220,38,38,.1)';
            var err = el.parentNode.querySelector('.ferr-inline');
            if(!err){
                err = document.createElement('span');
                err.className = 'ferr-inline';
                err.style.cssText = 'display:block;font-size:12px;color:var(--red);margin-top:5px;font-weight:600;';
                el.parentNode.appendChild(err);
            }
            err.textContent = msg;
            el.scrollIntoView({behavior:'smooth', block:'center'});
        }
        function clearErr(el){
            el.style.borderColor = '';
            el.style.boxShadow   = '';
            var err = el.parentNode.querySelector('.ferr-inline');
            if(err) err.textContent = '';
        }
        function setBoxErr(boxId, msg){
            var box = document.getElementById(boxId);
            if(!box) return;
            box.style.borderColor = 'var(--red)';
            box.style.boxShadow   = '0 0 0 3px rgba(220,38,38,.1)';
            var err = document.getElementById(boxId+'Err');
            if(err){ err.textContent=msg; err.style.display='block'; }
        }
        function clearBoxErr(boxId){
            var box = document.getElementById(boxId);
            if(!box) return;
            box.style.borderColor = '';
            box.style.boxShadow   = '';
            var err = document.getElementById(boxId+'Err');
            if(err){ err.textContent=''; err.style.display='none'; }
        }

        /* ════════════════════════════════════════
        DONNÉES BÉNIN
        ════════════════════════════════════════ */
        var bd={"Alibori":["Banikoara","Gogounou","Kandi","Karimama","Malanville","Ségbana"],"Atacora":["Boukoumbé","Cobly","Kérou","Kouandé","Matéri","Natitingou","Péhunco","Tanguiéta","Toucountouna"],"Atlantique":["Abomey-Calavi","Allada","Kpomassè","Ouidah","So-Ava","Toffo","Tori-Bossito","Zè"],"Borgou":["Bembèrèkè","Kalalé","N'Dali","Nikki","Parakou","Pèrèrè","Sinendé","Tchaourou"],"Collines":["Bantè","Dassa-Zoumè","Glazoué","Ouèssè","Savalou","Savè"],"Couffo":["Aplahoué","Djakotomey","Dogbo","Klouékanmè","Lalo","Toviklin"],"Donga":["Bassila","Copargo","Djougou","Ouaké"],"Littoral":["Cotonou"],"Mono":["Athiémé","Bopa","Comè","Grand-Popo","Houéyogbé","Lokossa"],"Ouémé":["Adjarra","Adjohoun","Aguegues","Akpro-Missérété","Avrankou","Bonou","Dangbo","Porto-Novo","Sèmè-Podji"],"Plateau":["Adja-Ouèrè","Ifangni","Kétou","Pobè","Sakété"],"Zou":["Abomey","Agbangnizoun","Bohicon","Covè","Djidja","Ouinhi","Zagnanado"]};
        var qb=["Akpakpa","Fidjrossè","Cadjehoun","Ganhi","Zogbo","Houéyiho","Godomey","Ste Rita","Agla","Vêdoko","Gbégamey","Wologuèdè","Jéricho","Hindé","Mènontin","Togoudo","Tankpè","Zopa","Calavi Kpota","Zogbadjè","Aitchedji","Dota","Oganla","Djassin","Kouhounou","Guéma","Kpébié","Zongo","Agongointo","Saclo","Sodohomey","Pahou","Savi","Dantokpa","Houinta","Akassato","Agori","Onigbolo"];

        var dSel = document.getElementById('departementSelect');
        var cSel = document.getElementById('communeSelect');
        Object.keys(bd).forEach(function(d){ var o=document.createElement('option'); o.value=d; o.textContent=d; dSel.appendChild(o); });
        dSel.addEventListener('change', function(){
            cSel.innerHTML='<option value="">Sélectionner</option>'; cSel.disabled=true;
            var a=bd[this.value];
            if(a&&a.length){ a.forEach(function(c){ var o=document.createElement('option'); o.value=c; o.textContent=c; cSel.appendChild(o); }); cSel.disabled=false; }
            clearErr(dSel);
            clearErr(cSel);
        });

        cSel.addEventListener('change', function(){ if(this.value) clearErr(this); });

        var qIn = document.getElementById('quartierInput');
        var qBx = document.getElementById('quartierSuggestions');
        qIn.addEventListener('input', function(){
            var v=this.value.toLowerCase(); qBx.innerHTML='';
            if(v.length < 1){ qBx.style.display='none'; return; }
            if(this.value.trim().length >= 2) clearErr(this);
            var r=qb.filter(function(q){ return q.toLowerCase().indexOf(v)!==-1; }).slice(0,8);
            if(!r.length){ qBx.style.display='none'; return; }
            r.forEach(function(q){ var li=document.createElement('li'); li.textContent=q; li.addEventListener('click',function(){ qIn.value=q; qBx.style.display='none'; clearErr(qIn); }); qBx.appendChild(li); });
            qBx.style.display='block';
        });
        document.addEventListener('click', function(e){ if(!qIn.contains(e.target)) qBx.style.display='none'; });

        /* ════════════════════════════════════════
        TYPE DYNAMIQUE
        ════════════════════════════════════════ */
        var currentType = 'Maison';
        function applyTypeBlocks(){
            document.querySelectorAll('.type-block').forEach(function(b){
                var types = b.getAttribute('data-types').split(',');
                b.classList.toggle('d-none', types.indexOf(currentType) === -1);
            });
        }
        applyTypeBlocks();

        /* ════════════════════════════════════════
        OPTION CARDS radio
        ════════════════════════════════════════ */
        function initOcGrid(gridId, onChange){
            var g = document.getElementById(gridId); if(!g) return;
            g.querySelectorAll('.oc').forEach(function(c){
                c.addEventListener('click', function(){
                    g.querySelectorAll('.oc').forEach(function(x){ x.classList.remove('s'); });
                    c.classList.add('s');
                    if(onChange) onChange(c.getAttribute('data-v'));
                });
            });
        }
        initOcGrid('typeGrid', function(v){ currentType=v; applyTypeBlocks(); });
        initOcGrid('catGrid', null);

        /* ════════════════════════════════════════
        ÉQUIPEMENT CARDS
        Clic → sélection visuelle + sync champ
        hidden → valeur envoyée en BD
        ════════════════════════════════════════ */
        var eqHiddenMap = {
            /* Maison / Appartement */
            'cuisine'    : { id:'hCuisine',   on:'Oui',            off:'Non'        },
            'clime_c'    : { id:'hClime',     on:'Climatiseur',    off:'Non'        },
            'brasseur'   : { id:'hClime',     on:"Brasseur d'air", off:'Non'        },
            'wifi_c'     : { id:'hWifi',      on:'Wifi',           off:'Non'        },
            'securite_c' : { id:'hSecurite',  on:'Oui',            off:'Non'        },
            'terasse_c'  : { id:'hTerasse',   on:'Oui',            off:'Non'        },
            'entretien_c': { id:'hEntretien', on:'Chaque semaine', off:'Non inclus' },
            /* Bureaux */
            'clime_b'    : { id:'hClime',     on:'Climatiseur',    off:'Non'        },
            'wifi_b'     : { id:'hWifi',      on:'Wifi',           off:'Non'        },
            'securite_b' : { id:'hSecurite',  on:'Oui',            off:'Non'        },
            'parking_b'  : { id:'hPacking',   on:'Oui',            off:'Non'        },
            /* Boutique */
            'clime_bt'   : { id:'hClime',     on:'Climatiseur',    off:'Non'        },
            'securite_bt': { id:'hSecurite',  on:'Oui',            off:'Non'        },
            'parking_bt' : { id:'hPacking',   on:'Oui',            off:'Non'        },
        };

        document.querySelectorAll('.eq').forEach(function(item){
            item.addEventListener('click', function(){
                item.classList.toggle('s');
                var inp   = item.querySelector('input');
                var isSel = item.classList.contains('s');
                inp.checked = isSel;

                var map = eqHiddenMap[inp.name];
                if(map){
                    var hEl = document.getElementById(map.id);
                    if(hEl) hEl.value = isSel ? map.on : map.off;
                }
            });
        });

        /* ════════════════════════════════════════
        COMPTEURS +/-
        ════════════════════════════════════════ */
        document.querySelectorAll('.cb').forEach(function(b){
            b.addEventListener('click', function(){
                var el=document.getElementById(b.getAttribute('data-t'));
                var v=parseInt(el.value)||0; var mn=parseInt(el.min)||0;
                if(b.getAttribute('data-a')==='+') v++;
                else if(v>mn) v--;
                el.value=v;
            });
        });

        /* ════════════════════════════════════════
        OUI / NON
        ════════════════════════════════════════ */
        document.querySelectorAll('.yn-b[data-t]').forEach(function(b){
            b.addEventListener('click', function(){
                var p=b.parentElement;
                p.querySelectorAll('.yn-b').forEach(function(x){ x.classList.remove('s'); });
                b.classList.add('s');
                document.getElementById(b.getAttribute('data-t')).value = b.getAttribute('data-v');
            });
        });

        /* ════════════════════════════════════════
        DISPO IMMÉDIATE
        ════════════════════════════════════════ */
        var dLbl = document.getElementById('dispoImmedLbl');
        if(dLbl){
            dLbl.addEventListener('click', function(){
                dLbl.classList.toggle('on');
                document.getElementById('dispoImmed').checked = dLbl.classList.contains('on');
                var dd = document.getElementById('dispoDate');
                dd.disabled = dLbl.classList.contains('on');
                if(dd.disabled) dd.value='';
            });
        }

        /* ════════════════════════════════════════
        UPLOAD PHOTOS — max 5 Mo / image
        Photos obligatoires
        ════════════════════════════════════════ */
        var upz   = document.getElementById('upz');
        var fInp  = document.getElementById('images');
        var prG   = document.getElementById('prevG');
        var imgErr= document.getElementById('imgErr');
        var aFiles= [];
        var MAX_MB= 5 * 1024 * 1024; // 5 Mo

        upz.addEventListener('click', function(){ fInp.click(); });
        upz.addEventListener('dragover', function(e){ e.preventDefault(); upz.classList.add('dz'); });
        upz.addEventListener('dragleave', function(){ upz.classList.remove('dz'); });
        upz.addEventListener('drop', function(e){ e.preventDefault(); upz.classList.remove('dz'); addF(e.dataTransfer.files); });
        fInp.addEventListener('change', function(){ addF(this.files); this.value=''; });

        function addF(files){
            var refused = [];
            Array.prototype.forEach.call(files, function(f){
                if(!f.type.startsWith('image/')){ refused.push('"'+f.name+'" n\'est pas une image'); return; }
                if(f.size > MAX_MB){ refused.push('"'+f.name+'" dépasse 5 Mo ('+Math.round(f.size/1024/1024*10)/10+' Mo)'); return; }
                aFiles.push(f);
                var r=new FileReader();
                r.onload=function(e){
                    var idx = aFiles.length - 1;
                    var d=document.createElement('div'); d.className='pv';
                    var img=document.createElement('img'); img.src=e.target.result;
                    var dl=document.createElement('button'); dl.className='pv-del'; dl.type='button'; dl.innerHTML='&times;';
                    dl.addEventListener('click',function(){ aFiles.splice(idx,1); d.remove(); checkImgErr(); });
                    d.appendChild(img); d.appendChild(dl); prG.appendChild(d);
                };
                r.readAsDataURL(f);
            });
            if(refused.length){
                imgErr.textContent = '⚠ Fichier(s) refusé(s) : ' + refused.join(' | ');
                imgErr.style.display = 'block';
                upz.style.borderColor = 'var(--red)';
            } else {
                checkImgErr();
            }
        }

        function checkImgErr(){
            if(aFiles.length === 0){
                imgErr.textContent = '⚠ Au moins une photo est obligatoire.';
                imgErr.style.display = 'block';
                upz.style.borderColor = 'var(--red)';
            } else {
                imgErr.textContent = '';
                imgErr.style.display = 'none';
                upz.style.borderColor = '';
            }
        }

        /* ════════════════════════════════════════
        DESCRIPTION — compteur + live valid.
        ════════════════════════════════════════ */
        var dTa = document.getElementById('description');
        var dCt = document.getElementById('descCt');
        dTa.addEventListener('input', function(){
            var len = this.value.length;
            dCt.textContent = len + ' / 800';
            dCt.style.color = len > 700 ? 'var(--red)' : 'var(--ink3)';
            if(len >= 10) clearErr(this);
        });

        /* ════════════════════════════════════════
        PRIX — live clear erreur
        ════════════════════════════════════════ */
        document.getElementById('prix').addEventListener('input', function(){
            var p = this.value.replace(/\s/g,'');
            if(p && !isNaN(parseFloat(p)) && parseFloat(p) > 0){
                clearErr(this);
                document.getElementById('prixErr').style.display='none';
                document.getElementById('fgPrix').classList.remove('err');
            }
        });

        /* ════════════════════════════════════════
        NAVIGATION MULTI-STEP
        ════════════════════════════════════════ */
        var cur=1, tot=7;

        function goTo(n){
            document.querySelectorAll('.sl-pane').forEach(function(p){ p.classList.remove('active'); });
            document.getElementById('pane'+n).classList.add('active');
            document.querySelectorAll('.sl-item').forEach(function(s){
                var sn=parseInt(s.getAttribute('data-step'));
                s.classList.remove('active','done');
                if(sn===n){ s.classList.add('active'); s.querySelector('.si-st').textContent='En cours'; }
                else if(sn<n){ s.classList.add('done'); s.querySelector('.si-st').textContent='Complété ✓'; }
                else { s.querySelector('.si-st').textContent='À compléter'; }
            });
            document.getElementById('btnPrev').disabled = (n===1);
            var nBtn = document.getElementById('btnNext');
            if(n===tot){
                nBtn.innerHTML='<i class="fa fa-check" style="margin-right:7px;"></i>Soumettre l\'annonce';
                nBtn.style.background='var(--green)';
                fillRecap();
            } else {
                nBtn.innerHTML='Suivant <i class="fa fa-arrow-right" style="margin-left:7px;"></i>';
                nBtn.style.background='var(--ink)';
            }
            cur=n;
            window.scrollTo({top:0, behavior:'smooth'});
        }

        document.getElementById('btnNext').addEventListener('click', function(){
            if(!validate(cur)) return;
            if(cur < tot) goTo(cur+1);
            else submitForm();
        });
        document.getElementById('btnPrev').addEventListener('click', function(){
            if(cur > 1) goTo(cur-1);
        });

        /* ════════════════════════════════════════
        VALIDATION STRICTE PAR ÉTAPE
        Champ vide → rouge, impossible continuer
        ════════════════════════════════════════ */
        function validate(n){

            /* ── Étape 2 : Adresse ── */
            if(n===2){
                var ok = true;
                if(!dSel.value){
                    setErr(dSel, 'Veuillez sélectionner un département.');
                    ok = false;
                }
                if(!cSel.value){
                    setErr(cSel, 'Veuillez sélectionner une commune.');
                    ok = false;
                }
                if(qIn.value.trim().length < 2){
                    setErr(qIn, 'Le quartier doit comporter au moins 2 caractères.');
                    ok = false;
                }
                return ok;
            }

            /* ── Étape 3 : Surface ── */
            if(n===3){
                /* Surface Maison/Appt/Bureaux */
                var surfEl = document.getElementById('surface');
                if(surfEl && !surfEl.closest('.d-none')){
                    if(!surfEl.value || parseInt(surfEl.value) <= 0){
                        setErr(surfEl, 'Veuillez indiquer la surface habitable.');
                        return false;
                    } else { clearErr(surfEl); }
                }
                /* Surface Boutique */
                var surBt = document.getElementById('surfaceBoutique');
                if(surBt && !surBt.closest('.d-none')){
                    if(!surBt.value || parseInt(surBt.value) <= 0){
                        setErr(surBt, 'Veuillez indiquer la surface du local.');
                        return false;
                    } else { clearErr(surBt); }
                }
                return true;
            }

            /* ── Étape 4 : Photos obligatoires, max 5 Mo ── */
            if(n===4){
                if(aFiles.length === 0){
                    imgErr.textContent = '⚠ Au moins une photo est obligatoire pour continuer.';
                    imgErr.style.display = 'block';
                    upz.style.borderColor = 'var(--red)';
                    upz.scrollIntoView({behavior:'smooth', block:'center'});
                    return false;
                }
                return true;
            }

            /* ── Étape 5 : Description ≥ 10 caractères ── */
            if(n===5){
                if(dTa.value.trim().length < 10){
                    setErr(dTa, 'La description doit comporter au moins 10 caractères.');
                    return false;
                }
                clearErr(dTa);
                return true;
            }

            /* ── Étape 6 : Prix obligatoire ── */
            if(n===6){
                var pEl  = document.getElementById('prix');
                var pVal = pEl.value.replace(/\s/g,'');
                if(!pVal || isNaN(parseFloat(pVal)) || parseFloat(pVal) <= 0){
                    setErr(pEl, 'Veuillez saisir un prix valide.');
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

        /* ════════════════════════════════════════
        RÉCAPITULATIF — avec équipements
        ════════════════════════════════════════ */
        function fillRecap(){
            var g  = function(id){ var e=document.getElementById(id); return e?e.value:'—'; };
            var oc = function(gid){ var c=document.querySelector('#'+gid+' .oc.s input'); return c?c.value:'—'; };

            document.getElementById('rc-type').textContent   = oc('typeGrid');
            document.getElementById('rc-cat').textContent    = oc('catGrid')==='louer'?'À louer':'À vendre';
            document.getElementById('rc-duree').textContent  = g('duree');
            document.getElementById('rc-dep').textContent    = dSel.selectedIndex>0 ? dSel.options[dSel.selectedIndex].text : '—';
            document.getElementById('rc-com').textContent    = cSel.selectedIndex>0 ? cSel.options[cSel.selectedIndex].text : '—';
            document.getElementById('rc-qrt').textContent    = qIn.value||'—';

            var surf = document.getElementById('surface');
            var surBt= document.getElementById('surfaceBoutique');
            var sv   = (surf&&surf.value&&!surf.closest('.d-none')) ? surf.value+' m²'
                    : (surBt&&surBt.value&&!surBt.closest('.d-none')) ? surBt.value+' m²' : '—';
            document.getElementById('rc-surf').textContent   = sv;
            document.getElementById('rc-pieces').textContent = g('nombrePieces');
            document.getElementById('rc-meu').textContent    = g('meuble')||'—';
            document.getElementById('rc-park').textContent   = g('packing')||g('packing_bureaux')||'—';
            document.getElementById('rc-prix').textContent   = g('prix')+' FCFA';
            document.getElementById('rc-neg').textContent    = g('negociable');
            document.getElementById('rc-cau').textContent    = g('caution');

            /* Équipements sélectionnés */
            var eqList = [];
            document.querySelectorAll('.eq.s').forEach(function(e){
                var parent = e.closest('.type-block');
                if(parent && parent.classList.contains('d-none')) return; /* ignore blocs cachés */
                var sp = e.querySelector('span'); if(sp) eqList.push(sp.textContent.trim());
            });
            var rcEq = document.getElementById('rc-eq');
            if(rcEq) rcEq.textContent = eqList.length ? eqList.join(', ') : 'Aucun';
        }

        /* ════════════════════════════════════════
        SUBMIT — syncEquipements + AJAX
        ════════════════════════════════════════ */
        function syncEquipements(){
            document.querySelectorAll('.eq input[type="checkbox"]').forEach(function(cb){ cb.disabled=true; });
        }

        function submitAnnonce(transactionId){
            syncEquipements();
            var formData = new FormData(document.getElementById('form'));
            if(transactionId) formData.append('transactionId', transactionId);
            formData.delete('images[]');
            aFiles.forEach(function(file){ formData.append('images[]', file); });

            $.ajax({
                url: saveRoute, method:'POST', data:formData,
                contentType:false, processData:false,
                headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                success: function(res){
                    var status = parseInt(res.status ?? res);
                    if(status===200){
                        showToast && showToast('success','Annonce déposée avec succès 👍');
                        setTimeout(function(){ window.location.href=retourRoute; },4000);
                    } else {
                        alert('Erreur lors de la soumission. Veuillez réessayer.');
                    }
                },
                error: function(xhr){
                    console.error(xhr.responseText);
                    alert('Erreur serveur : '+xhr.status+'. Veuillez réessayer.');
                }
            });
        }

        /* Nouveau flux : sauvegarder d'abord puis lancer le paiement si nécessaire */
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

        /* submitForm — appelé par btnNext étape 7 : sauvegarde initiale */
        window.submitForm = function(){
            var ok = true;
            if(!dSel.value){ setErr(dSel,'Veuillez sélectionner un département.'); ok=false; }
            if(!cSel.value){ setErr(cSel,'Veuillez sélectionner une commune.'); ok=false; }
            if(qIn.value.trim().length<2){ setErr(qIn,'Le quartier doit comporter au moins 2 caractères.'); ok=false; }
            var pEl=document.getElementById('prix');
            var pv=pEl?pEl.value.replace(/\s/g,''):'';
            if(!pv||isNaN(parseFloat(pv))||parseFloat(pv)<=0){ if(pEl)setErr(pEl,'Veuillez saisir un prix valide.'); ok=false; }
            if(dTa.value.trim().length<10){ setErr(dTa,'La description doit comporter au moins 10 caractères.'); ok=false; }
            if(aFiles.length===0){
                upz.style.borderColor='var(--red)';
                imgErr.textContent='⚠ Au moins une photo est obligatoire.'; imgErr.style.display='block';
                ok=false;
            }
            if(!ok) return;

            // Préparer et sauvegarder l'annonce
            var formData = new FormData(document.getElementById('form'));
            formData.delete('images[]');
            aFiles.forEach(function(file){ formData.append('images[]', file); });
            if(isFirstTime === true){ formData.append('activate','1'); }

            $.ajax({
                url: saveRoute, method:'POST', data:formData,
                contentType:false, processData:false,
                headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                success: function(res){
                    var status = parseInt(res.status ?? res);
                    if(status===200){
                        var appId = res.appartement_id || res.id;
                        if(isFirstTime===true){
                            showToast && showToast('success','Annonce déposée et publiée (offre gratuite)');
                            setTimeout(function(){ window.location.href=retourRoute; },2000);
                            return;
                        }
                        currentAppartementId = appId;
                        var duree=document.getElementById('duree').value;
                        var frais=duree==='90 Jours'?5000:2000;
                        var ctnr=document.getElementById('payerContainer'); ctnr.innerHTML='';
                        var kk=document.createElement('kkiapay-widget');
                        kk.setAttribute('amount',String(frais));
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

        })();
    </script>
@endsection