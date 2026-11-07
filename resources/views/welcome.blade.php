@verbatim
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Reza Pratama — Full-Stack Developer</title>
<link rel="icon" type="image/svg+xml" href="/images/logo/favicon.svg" />
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@600;700;800&family=Barlow:ital,wght@0,400;0,500;0,600;1,400&family=JetBrains+Mono:wght@400;500;600&family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/3.4.38/vue.global.prod.min.js"></script>
<style>
  [v-cloak] { display: none !important; }
  :root{
    --bg:#ffffff; --surface:#ffffff; --surface-2:#f8fafc; --border:#e2e8f0;
    --ink:#0f172a; --body:#334155; --muted:#64748b;
    --navy:#1f4e79; --red:#c2333b; --blue:#1e6fd6;
    --chip:#f1f5f9; --shadow:0 1px 3px rgba(15,23,42,.06),0 10px 25px rgba(15,23,42,.06);
    --ok:#10b981; --ok-bg:#ecfdf5; --warn:#f59e0b; --warn-bg:#fef3c7; --open:#ef4444; --open-bg:#fee2e2;
    /* Section 2-tone alternating backgrounds (White & Light Grey) */
    --tone-base:#ffffff;
    --tone-alt:linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);
    --tone-alt-border:#e2e8f0;
  }
  [data-theme="dark"]{
    --bg:#0b0f17; --surface:#121824; --surface-2:#182030; --border:#1e2638;
    --ink:#f1f5f9; --body:#cbd5e1; --muted:#8294a8;
    --navy:#60a5fa; --red:#f0555b; --blue:#5a9bec;
    --chip:#141b29; --shadow:0 1px 3px rgba(0,0,0,.35),0 14px 34px rgba(0,0,0,.45);
    --ok:#34d399; --ok-bg:#064e3b; --warn:#fbbf24; --warn-bg:#451a03; --open:#f87171; --open-bg:#450a0a;
    /* Slate Charcoal / Dark Graphite: ultra-low contrast, soft on eyes, no blue glare */
    --tone-base:#0b0f17;
    --tone-alt:linear-gradient(180deg, #0f1420 0%, #121826 100%);
    --tone-alt-border:rgba(255,255,255,0.04);
  }
  *{box-sizing:border-box;margin:0;padding:0}
  html{scroll-behavior:smooth}
  body{
    font-family:"Plus Jakarta Sans",system-ui,-apple-system,sans-serif;background:var(--bg);color:var(--body);
    line-height:1.6;-webkit-font-smoothing:antialiased;transition:background .3s ease,color .3s ease;
  }
  ::selection{background:color-mix(in srgb,var(--navy) 20%,transparent);color:var(--ink)}
  [data-theme="dark"] ::selection{background:color-mix(in srgb,var(--blue) 35%,transparent);color:#ffffff}
  :focus-visible{outline:2px solid var(--navy);outline-offset:2px}
  [data-theme="dark"] :focus-visible{outline-color:var(--blue)}
  ::-webkit-scrollbar{width:8px;height:8px}
  ::-webkit-scrollbar-track{background:var(--bg)}
  ::-webkit-scrollbar-thumb{background:color-mix(in srgb,var(--border) 75%,var(--muted));border-radius:999px;border:2px solid var(--bg)}
  ::-webkit-scrollbar-thumb:hover{background:var(--muted)}
  .mono{font-family:"JetBrains Mono",ui-monospace,monospace;font-variant-numeric:tabular-nums}
  .brand-condensed{font-family:"Barlow Condensed",sans-serif}
  .wrap{max-width:1120px;margin:0 auto;padding:0 24px}
  h1,h2,h3{color:var(--ink);line-height:1.15;letter-spacing:-.025em;text-wrap:balance}
  p{text-wrap:pretty}
  a{color:inherit;text-decoration:none}
  button{font-family:inherit;cursor:pointer;border:none;background:none;color:inherit}  /* ---------- top bar ---------- */
  header.bar{position:sticky;top:0;z-index:40;background:color-mix(in srgb,var(--bg) 88%,transparent);
    backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px);border-bottom:1px solid var(--border);
    transition:background .3s ease,border-color .3s ease;width:100%}
  .bar-inner{display:flex;align-items:center;gap:18px;height:66px;width:100%;max-width:100%;padding:0 32px}
  @media (max-width:768px){ .bar-inner{padding:0 16px;gap:10px} }
  .logo{display:flex;align-items:center;gap:12px;font-weight:700;color:var(--ink);letter-spacing:-.015em;flex-shrink:0}
  .logo-mark-img{width:34px;height:34px;border-radius:9px;object-fit:contain;background:var(--surface-2);
    border:1px solid var(--border);padding:3px;transition:transform .2s ease;box-shadow:0 1px 3px rgba(0,0,0,.06)}
  .logo:hover .logo-mark-img{transform:scale(1.08)}
  .logo-text{font-size:16.5px;font-weight:700;color:var(--ink)}

  /* Desktop top navigation (ergonomic, eliminates eye strain, spacious) */
  .top-nav{display:flex;align-items:center;gap:6px;margin-left:14px}
  .top-nav-btn{padding:8px 14px;border-radius:9px;font-size:14px;font-weight:600;color:var(--muted);
    transition:all .18s ease;cursor:pointer;background:transparent;border:none}
  .top-nav-btn:hover{color:var(--ink);background:var(--surface-2)}
  .top-nav-btn.active{color:var(--navy);font-weight:700;background:color-mix(in srgb,var(--navy) 10%,var(--surface-2))}
  [data-theme="dark"] .top-nav-btn.active{color:var(--blue);background:color-mix(in srgb,var(--blue) 14%,var(--surface-2))}

  .spacer{flex:1}

  /* Calmed-down location & clock pill */
  .loc-clock-pill{display:inline-flex;align-items:center;gap:8px;padding:7px 14px;border-radius:20px;
    background:var(--surface-2);border:1px solid var(--border);font-size:12.5px;color:var(--body);
    font-weight:500;letter-spacing:-.01em;transition:all .2s ease;flex-shrink:0}
  .loc-clock-pill:hover{border-color:var(--navy)}
  .loc-pin-dot{width:6px;height:6px;border-radius:50%;background:#10b981;flex-shrink:0}
  .loc-name{color:var(--muted)}
  .loc-sep{opacity:.35}
  .loc-time{font-weight:600;color:var(--ink)}
  .loc-tz{font-size:11px;color:var(--muted);font-weight:500}

  .ctrl{display:flex;align-items:center;border:1px solid var(--border);border-radius:10px;overflow:hidden;background:var(--surface-2);flex-shrink:0}
  .ctrl button{padding:7px 13px;font-size:13px;font-weight:600;color:var(--muted);transition:.15s}
  .ctrl button.on{background:var(--navy);color:#fff}
  .icbtn{width:38px;height:38px;border-radius:10px;border:1px solid var(--border);display:grid;place-items:center;
    color:var(--ink);background:var(--surface-2);transition:.15s;flex-shrink:0}
  .icbtn:hover{border-color:var(--navy);transform:translateY(-1px)}

  /* ---------- sections (shared heading pattern & alternating 2-tone backgrounds) ---------- */
  section{padding:80px 0;position:relative}
  .sec-head{display:flex;flex-direction:column;align-items:flex-start;gap:6px;margin-bottom:34px}
  .sec-badge{display:inline-flex;align-items:center;gap:6px;padding:4px 10px;border-radius:20px;
    background:var(--surface-2);border:1px solid var(--border);font-size:11.5px;font-weight:700;
    color:var(--navy);letter-spacing:.04em;text-transform:uppercase;margin-bottom:2px}
  [data-theme="dark"] .sec-badge{color:var(--blue)}
  .sec-badge-dot{width:6px;height:6px;border-radius:50%;background:var(--red)}
  .sec-head h2{font-size:clamp(26px,3.4vw,34px);font-weight:800;letter-spacing:-.025em;color:var(--ink)}
  .sec-head p{color:var(--muted);font-size:14.5px;max-width:64ch;line-height:1.55}

  /* Section Alternating 2-Tone System */
  .hero{background:var(--tone-base);position:relative;padding:96px 0 60px;overflow:hidden}
  #exp{background:var(--tone-alt);border-top:1px solid var(--tone-alt-border);border-bottom:1px solid var(--tone-alt-border)}
  #skills{background:var(--tone-base)}
  #certifications{background:var(--tone-alt);border-top:1px solid var(--tone-alt-border);border-bottom:1px solid var(--tone-alt-border)}
  #project{background:var(--tone-base)}
  footer#contact{background:var(--tone-alt);border-top:1px solid var(--tone-alt-border);padding:54px 0 60px;margin-top:0}
  .foot{display:flex;flex-wrap:wrap;gap:24px;align-items:center;justify-content:space-between}
  .foot .links{display:flex;gap:10px;flex-wrap:wrap}
  .foot a.link{display:inline-flex;align-items:center;gap:8px;padding:9px 15px;border:1px solid var(--border);border-radius:10px;
    font-size:14px;font-weight:600;color:var(--ink);background:var(--surface);transition:.15s}
  .foot a.link:hover{border-color:var(--navy);transform:translateY(-1px)}
  .foot .stack{font-family:"IBM Plex Mono",monospace;font-size:12px;color:var(--muted);text-align:right}
  .foot .stack b{color:var(--navy)}

  /* ---------- shared button / chip primitives (reused across sections) ---------- */
  .btn{display:inline-flex;align-items:center;gap:8px;padding:12px 22px;border-radius:12px;font-weight:600;font-size:14.5px;transition:all .2s cubic-bezier(.16,1,.3,1);cursor:pointer}
  .btn.primary{background:var(--navy);color:#fff;box-shadow:0 1px 2px rgba(15,23,42,.08),0 4px 14px -3px color-mix(in srgb,var(--navy) 40%,transparent)}
  .btn.primary:hover{transform:translateY(-2px);box-shadow:0 6px 20px -3px color-mix(in srgb,var(--navy) 55%,transparent);filter:brightness(1.05)}
  .btn.primary:active{transform:translateY(0)}
  .btn.ghost{border:1px solid var(--border);color:var(--ink);background:var(--surface);box-shadow:0 1px 2px rgba(0,0,0,.03)}
  .btn.ghost:hover{border-color:color-mix(in srgb,var(--navy) 45%,var(--border));background:var(--surface-2);transform:translateY(-2px);box-shadow:0 4px 12px -2px rgba(0,0,0,.06)}
  .btn.ghost:active{transform:translateY(0)}
  .btn.disabled, .btn[disabled]{background:var(--surface-2);color:var(--muted);border:1px solid var(--border);
    cursor:not-allowed;box-shadow:none;pointer-events:none;opacity:.78}
  .btn.disabled svg, .btn[disabled] svg{opacity:.65}
  .chips{display:flex;flex-wrap:wrap;gap:10px}
  .chip{display:inline-flex;align-items:center;gap:8px;background:var(--chip);border:1px solid var(--border);
    padding:7px 13px;border-radius:20px;font-size:13.5px;font-weight:500;color:var(--body);transition:all .18s ease}
  .chip:hover{border-color:var(--navy);transform:translateY(-1px)}
  .chip .dot{width:7px;height:7px;border-radius:50%}
  .sk{background:var(--chip);border:1px solid var(--border);padding:5px 12px;border-radius:8px;font-size:13px;font-weight:500;color:var(--body);transition:all .18s ease}
  .sk:hover{border-color:color-mix(in srgb,var(--navy) 35%,var(--border));color:var(--ink);transform:translateY(-1px)}

  /* ---------- hero (self/profile) ---------- */
  .hero-glow{position:absolute;top:-80px;right:-40px;width:680px;height:520px;
    background:radial-gradient(circle at 60% 40%, rgba(30,111,214,.1) 0%, rgba(194,51,59,.06) 38%, transparent 70%);
    pointer-events:none;z-index:0;filter:blur(44px)}
  [data-theme="dark"] .hero-glow{
    background:radial-gradient(circle at 60% 40%, rgba(90,155,236,.14) 0%, rgba(240,85,91,.08) 42%, transparent 70%);
  }
  .hero-content{position:relative;z-index:1}

  /* hero grid layout */
  .hero-layout{display:grid;grid-template-columns:1.2fr 0.8fr;gap:48px;align-items:center}
  
  /* status pill */
  .status-pill{display:inline-flex;align-items:center;gap:10px;padding:6px 14px;background:var(--surface-2);
    border:1px solid var(--border);border-radius:999px;font-size:13px;font-weight:500;color:var(--body);
    margin-bottom:18px;box-shadow:0 1px 4px rgba(0,0,0,.03);transition:all .2s ease}
  .status-pill:hover{border-color:color-mix(in srgb,var(--navy) 40%,var(--border));transform:translateY(-1px)}
  .status-dot-wrap{position:relative;display:flex;align-items:center;justify-content:center;width:10px;height:10px}
  .status-dot-ping{position:absolute;width:100%;height:100%;border-radius:50%;background:#10b981;opacity:.75;
    animation:status-ping 2s cubic-bezier(0,0,.2,1) infinite}
  .status-dot-core{position:relative;width:7px;height:7px;border-radius:50%;background:#10b981}
  @keyframes status-ping{75%,100%{transform:scale(2.3);opacity:0}}
  .status-sep{opacity:.35}
  .status-loc{display:inline-flex;align-items:center;gap:4px;color:var(--muted);font-size:12.5px}

  .hero h1{font-size:clamp(40px,5vw,58px);font-weight:800;letter-spacing:-.03em;margin-bottom:6px}
  .hero .role{font-size:clamp(19px,2.2vw,23px);color:var(--navy);font-weight:700;margin-bottom:18px;letter-spacing:-.015em}
  [data-theme="dark"] .hero .role{color:var(--blue)}
  .hero .sum{font-size:16px;color:var(--body);line-height:1.7;margin-bottom:28px;max-width:58ch}
  .hero .sum strong{color:var(--ink);font-weight:600}
  .cta-row{display:flex;flex-wrap:wrap;gap:12px;margin-bottom:28px}

  /* Enterprise experience strip */
  .hero-trust{display:flex;flex-direction:column;gap:9px;padding-top:20px;border-top:1px solid color-mix(in srgb,var(--border) 70%,transparent)}
  .trust-label{font-size:12px;font-weight:600;color:var(--muted);text-transform:uppercase;letter-spacing:.05em}
  .trust-chips{display:flex;flex-wrap:wrap;gap:8px}
  .trust-chip{display:inline-flex;align-items:center;gap:7px;background:var(--surface-2);border:1px solid var(--border);
    padding:6px 12px;border-radius:12px;font-size:12.5px;font-weight:600;color:var(--ink);transition:.18s ease}
  .trust-chip:hover{border-color:color-mix(in srgb,var(--navy) 40%,var(--border));transform:translateY(-1px);background:var(--surface)}
  .trust-chip .chip-dot{width:7px;height:7px;border-radius:50%;flex-shrink:0}
  .trust-chip .chip-dot.dot-infranexia{background:var(--navy)}
  .trust-chip .chip-dot.dot-telkom{background:var(--red)}
  .trust-chip .chip-dot.dot-telkomakses{background:var(--blue)}
  .trust-chip .chip-sub{font-weight:400;color:var(--muted);font-size:12px}

  /* photo & visual showcase */
  .hero-visual{position:relative;display:flex;justify-content:center;align-items:center}
  .hero-card{width:100%;max-width:330px;background:var(--surface);border:1px solid var(--border);
    border-radius:22px;padding:12px;box-shadow:0 12px 36px -10px rgba(15,23,42,.12),0 1px 3px rgba(15,23,42,.04);
    transition:transform .3s cubic-bezier(.16,1,.3,1),box-shadow .3s ease,border-color .3s ease;position:relative}
  .hero-card:hover{transform:translateY(-4px);border-color:color-mix(in srgb,var(--navy) 35%,var(--border));
    box-shadow:0 24px 48px -12px rgba(15,23,42,.18)}
  [data-theme="dark"] .hero-card{box-shadow:0 14px 40px -10px rgba(0,0,0,.6),0 0 0 1px rgba(255,255,255,.05)}
  [data-theme="dark"] .hero-card:hover{box-shadow:0 24px 56px -12px rgba(0,0,0,.75),0 0 0 1px rgba(255,255,255,.1)}
  .hero-photo-wrap{position:relative;width:100%;border-radius:18px;overflow:hidden}
  .hero-photo{width:100%;aspect-ratio:4/5;object-fit:cover;object-position:center 15%;border-radius:18px;display:block;background:var(--surface-2)}
  
  /* Floating badge on profile card */
  .hero-float-badge{position:absolute;bottom:14px;right:14px;display:flex;align-items:center;gap:10px;
    padding:8px 14px;background:color-mix(in srgb,var(--surface) 86%,transparent);backdrop-filter:blur(14px);
    -webkit-backdrop-filter:blur(14px);border:1px solid var(--border);border-radius:14px;
    box-shadow:0 10px 25px -4px rgba(0,0,0,.22);transition:transform .2s ease}
  .hero-card:hover .hero-float-badge{transform:scale(1.03)}
  .hero-float-badge .badge-icon{width:28px;height:28px;border-radius:9px;background:linear-gradient(135deg,var(--navy) 0%,#1e6fd6 100%);color:#fff;
    display:grid;place-items:center;flex-shrink:0;box-shadow:0 2px 6px rgba(30,111,214,.35)}
  .hero-float-badge .badge-num{font-size:12.5px;font-weight:700;color:var(--ink);line-height:1.1}
  .hero-float-badge .badge-txt{font-size:10.5px;color:var(--muted);font-weight:600;white-space:nowrap}
  
  .hero-card-footer{display:flex;align-items:center;gap:9px;padding:12px 6px 4px;font-size:12.5px;color:var(--muted);font-weight:500;line-height:1.35}
  .hero-card-dot{width:7px;height:7px;border-radius:50%;background:var(--red);flex-shrink:0}

  /* ---------- experience (self/experience) ---------- */
  .timeline{display:grid;gap:0;position:relative}
  .tl{display:grid;grid-template-columns:160px 1fr;gap:24px;padding:24px 0;border-top:1px solid var(--border);transition:all .2s ease}
  .tl:first-child{border-top:none}
  .tl:hover .tl-logo-box{transform:translateY(-2px);box-shadow:0 6px 16px rgba(0,0,0,.08)}
  .tl .when{font-family:"JetBrains Mono",monospace;font-size:13px;color:var(--muted);padding-top:4px}
  .tl-head{display:flex;align-items:center;gap:16px;margin-bottom:10px}
  .tl-logo-box{width:48px;height:48px;border-radius:12px;background:#ffffff;border:1px solid var(--border);
    display:grid;place-items:center;padding:6px;box-shadow:0 2px 6px rgba(0,0,0,.04);flex-shrink:0;transition:all .2s ease}
  .tl-logo-img{width:100%;height:100%;object-fit:contain}
  .tl .org{font-size:17px;font-weight:700;color:var(--ink);display:flex;align-items:center;flex-wrap:wrap;gap:8px}
  .tl .rl{font-size:14px;color:var(--navy);font-weight:600;margin-top:2px}
  [data-theme="dark"] .tl .rl{color:var(--blue)}
  .tl .desc{font-size:14px;color:var(--body);max-width:72ch;line-height:1.6}
  .tag{display:inline-block;font-family:"JetBrains Mono",monospace;font-size:11px;color:var(--red);border:1px solid color-mix(in srgb,var(--red) 40%,var(--border));
    background:color-mix(in srgb,var(--red) 8%,transparent);padding:2px 8px;border-radius:6px;font-weight:600}

  /* ---------- skills & edu (self/skills) ---------- */
  .grid2{display:grid;grid-template-columns:1.35fr 1fr;gap:44px;align-items:start}
  .skillset{display:flex;flex-direction:column;gap:20px}
  .skillrow .k{font-size:12.5px;color:var(--muted);font-weight:700;letter-spacing:.04em;text-transform:uppercase;margin-bottom:10px}
  .skillrow .v{display:flex;flex-wrap:wrap;gap:8px}
  .edu{background:var(--surface);border:1px solid var(--border);border-radius:18px;padding:24px;box-shadow:var(--shadow);transition:transform .2s ease}
  .edu:hover{transform:translateY(-2px);border-color:color-mix(in srgb,var(--navy) 40%,var(--border))}
  .edu h3{font-size:17px;font-weight:700;margin-bottom:4px;color:var(--ink)}
  .edu .uni{color:var(--navy);font-weight:600;font-size:14px;margin-bottom:10px}
  [data-theme="dark"] .edu .uni{color:var(--blue)}
  .edu .gpa{font-family:"JetBrains Mono",monospace;font-size:13px;color:var(--muted);background:var(--surface-2);border:1px solid var(--border);padding:4px 10px;border-radius:6px;width:fit-content}
  .edu .paper{margin-top:16px;padding-top:16px;border-top:1px solid var(--border);font-size:13.5px;color:var(--body);line-height:1.6}

  /* ---------- Horizontal Architectural Showcase (Real-Estate / Property UX) ---------- */
  .proj-header-wrap{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:16px;margin-bottom:24px}
  .proj-header-wrap .sec-head{margin-bottom:0}
  
  .proj-toolbar{display:flex;align-items:center;flex-shrink:0}
  .proj-tab-nav{display:inline-flex;align-items:center;gap:3px;background:var(--surface-2);border:1px solid var(--border);
    padding:3px;border-radius:12px;box-shadow:inset 0 1px 2px rgba(0,0,0,.03);max-width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch}
  .proj-tab-item{display:inline-flex;align-items:center;gap:6px;padding:6px 12px;border-radius:9px;font-size:12px;
    font-weight:600;color:var(--muted);background:transparent;border:none;cursor:pointer;transition:all .18s ease;white-space:nowrap}
  .proj-tab-item:hover{color:var(--ink);background:var(--surface)}
  .proj-tab-item.active{background:var(--surface);color:var(--ink);box-shadow:0 1px 4px rgba(0,0,0,.08);font-weight:700}
  .tab-idx{font-size:11px;opacity:.7}
  .tab-status-dot{width:6px;height:6px;border-radius:50%;background:var(--muted)}
  .tab-status-dot.dot-tifreg{background:var(--navy)}
  .tab-status-dot.dot-dalapareg{background:var(--red)}
  .tab-status-dot.dot-tomman{background:#0088cc}
  [data-theme="dark"] .tab-status-dot.dot-tifreg{background:var(--blue)}

  /* Expansive horizontal reel container with butter-smooth scrolling */
  .proj-reel-outer{position:relative;width:100%;overflow:hidden;margin-bottom:28px}
  .proj-reel{
    display:flex;gap:28px;overflow-x:auto;scroll-snap-type:x mandatory;
    scroll-padding:0 max(24px, calc((100vw - 1140px)/2 + 20px));
    -webkit-overflow-scrolling:touch;scroll-behavior:smooth;scrollbar-width:none;
    padding:16px max(24px, calc((100vw - 1140px)/2 + 20px)) 24px;
    cursor:grab;touch-action:pan-y;
  }
  .proj-reel::-webkit-scrollbar{display:none}
  .proj-reel.is-dragging{cursor:grabbing;user-select:none;scroll-behavior:auto;scroll-snap-type:none}

  /* Wide Architectural Card */
  .proj-wide-card{
    flex:0 0 clamp(320px, 86vw, 960px);scroll-snap-align:center;scroll-snap-stop:always;
    background:var(--surface);border:1px solid var(--border);border-radius:24px;box-shadow:var(--shadow);
    display:flex;flex-direction:column;overflow:hidden;
    contain:content;
    transform:translateZ(0);
    -webkit-backface-visibility:hidden;
    backface-visibility:hidden;
    will-change:transform;
    transition:transform .38s cubic-bezier(.16,1,.3,1),box-shadow .38s ease,border-color .28s ease;
  }
  .proj-wide-card:hover{border-color:color-mix(in srgb,var(--navy) 35%,var(--border));transform:translateY(-2px);
    box-shadow:0 18px 45px -10px rgba(15,23,42,.14)}
  .proj-wide-card.active{border-color:color-mix(in srgb,var(--navy) 45%,var(--border));box-shadow:0 20px 48px -10px rgba(15,23,42,.16)}
  [data-theme="dark"] .proj-wide-card.active{border-color:color-mix(in srgb,var(--blue) 50%,var(--border));box-shadow:0 22px 50px -10px rgba(0,0,0,.5)}

  /* Card Ribbon */
  .card-ribbon{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:11px 22px;
    background:var(--surface-2);border-bottom:1px solid var(--border);font-size:11.5px;font-weight:700}
  .ribbon-project{color:var(--navy);letter-spacing:.05em}
  [data-theme="dark"] .ribbon-project{color:var(--blue)}
  .ribbon-status{padding:3px 9px;border-radius:6px;font-size:10.5px;font-weight:700;letter-spacing:.04em}
  .ribbon-status.status-tifreg{background:rgba(16,185,129,.14);color:#059669}
  .ribbon-status.status-dalapareg{background:rgba(30,111,214,.14);color:#1e6fd6}
  .ribbon-status.status-tomman{background:rgba(245,158,11,.14);color:#d97706}
  .ribbon-scale{color:var(--muted);font-size:11px}

  /* Split layout body */
  .card-split-body{display:grid;grid-template-columns:1.15fr 1fr;gap:24px;padding:22px}

  /* Left Column: Mockup Window & Simulation */
  .card-mockup-col{display:flex;flex-direction:column}
  .mockup-window{background:#0b1120;border:1px solid rgba(255,255,255,.1);border-radius:18px;overflow:hidden;
    display:flex;flex-direction:column;box-shadow:0 12px 30px rgba(0,0,0,.35)}
  .mockup-bar{display:flex;align-items:center;gap:10px;padding:10px 14px;background:#141d30;border-bottom:1px solid rgba(255,255,255,.08)}
  .mockup-dots{display:flex;gap:6px}
  .mockup-dots span{width:9px;height:9px;border-radius:50%}
  .dot-red{background:#ef4444} .dot-yellow{background:#f59e0b} .dot-green{background:#10b981}
  .mockup-url{display:inline-flex;align-items:center;gap:6px;flex:1;background:rgba(0,0,0,.28);padding:4px 10px;
    border-radius:6px;font-size:11px;color:#94a3b8;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
  .mockup-live-badge{font-size:9.5px;font-weight:700;padding:2px 6px;border-radius:4px;background:#059669;color:#fff;letter-spacing:.05em}

  .mockup-viewport{height:265px;position:relative;background:#070d18;color:#f8fafc;padding:14px;overflow:hidden;display:flex;flex-direction:column}
  .mock-canvas{width:100%;height:100%;position:relative;display:flex;flex-direction:column;justify-content:space-between}

  /* Authentic DALAPA Mini-App Mockup (Mirrors tifreg/feature/dashboard) */
  .canvas-gis-dalapa{position:absolute;inset:0;width:100%;height:100%;display:flex;background:#090f1b;overflow:hidden;user-select:none}
  
  /* Mini Sidebar */
  .mini-dash-sidebar{width:84px;background:#0c1424;border-right:1px solid rgba(255,255,255,.08);display:flex;flex-direction:column;flex-shrink:0;padding:8px 6px;z-index:15}
  .mini-sidebar-brand{display:flex;align-items:center;gap:5px;padding:2px 4px 6px;border-bottom:1px solid rgba(255,255,255,.06);margin-bottom:6px}
  .mini-brand-img{width:14px;height:14px;object-fit:contain}
  .mini-brand-title{font-size:10px;font-weight:700;color:#f8fafc;letter-spacing:.02em}
  .mini-sidebar-label{font-size:7.5px;font-weight:700;color:#64748b;letter-spacing:.08em;padding:0 4px;margin-bottom:3px}
  .mini-sidebar-nav{display:flex;flex-direction:column;gap:2px}
  .mini-nav-item{display:flex;align-items:center;gap:5px;padding:4px 6px;border-radius:5px;font-size:9px;font-weight:500;color:#94a3b8}
  .mini-nav-item.active{background:rgba(59,130,246,.2);color:#60a5fa;font-weight:600}
  
  /* Mini Main & Topbar */
  .mini-dash-main{flex:1;display:flex;flex-direction:column;overflow:hidden;position:relative}
  .mini-dash-topbar{height:25px;background:#0d1627;border-bottom:1px solid rgba(255,255,255,.08);display:flex;align-items:center;justify-content:space-between;padding:0 8px;flex-shrink:0;z-index:15}
  .mini-topbar-left{display:flex;align-items:center;gap:6px}
  .mini-topbar-icon{font-size:10px;color:#64748b}
  .mini-topbar-title{font-size:9.5px;font-weight:600;color:#cbd5e1;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:180px}
  .mini-topbar-right{display:flex;align-items:center;gap:6px}
  .mini-topbar-clock{font-size:8px;color:#94a3b8;background:rgba(255,255,255,.04);padding:1px 5px;border-radius:4px;border:1px solid rgba(255,255,255,.06)}
  .mini-topbar-user{display:flex;align-items:center;gap:4px}
  .mini-user-avatar{width:14px;height:14px;border-radius:50%;background:#2563eb;color:#fff;font-size:8px;font-weight:700;display:grid;place-items:center}
  .mini-user-name{font-size:8.5px;color:#94a3b8}
  
  /* Mini Map Viewport */
  .mini-map-viewport{flex:1;position:relative;overflow:hidden;background:#08101d}
  .mini-carto-svg{position:absolute;inset:0;width:100%;height:100%;pointer-events:none}
  
  /* Floating Sync Badge (Top Left) */
  .mini-sync-badge{position:absolute;top:6px;left:6px;z-index:10;background:rgba(15,23,42,.9);border:1px solid rgba(255,255,255,.12);border-radius:6px;padding:3px 7px;box-shadow:0 4px 10px rgba(0,0,0,.3)}
  .sync-head-line{display:flex;align-items:center;gap:4px;font-size:8px;color:#94a3b8}
  .sync-pulsing-dot{width:5px;height:5px;border-radius:50%;background:#10b981;box-shadow:0 0 6px #10b981}
  .sync-val{font-weight:700;color:#38bdf8;font-size:9px;margin-left:auto}
  .sync-data-line{display:flex;align-items:center;gap:4px;font-size:8px;color:#cbd5e1;margin-top:1px}
  .sync-data-line .sep{opacity:.4}
  
  /* Floating Toolbar (Top Right) */
  .mini-map-toolbar{position:absolute;top:6px;right:6px;z-index:10;display:flex;align-items:center;gap:4px}
  .mini-layer-pill{display:flex;background:rgba(15,23,42,.9);border:1px solid rgba(255,255,255,.12);border-radius:5px;overflow:hidden;font-size:8px;font-weight:600}
  .mini-layer-pill span{padding:2px 5px;color:#94a3b8}
  .mini-layer-pill span.active{background:#2563eb;color:#fff}
  .mini-filter-pill{background:rgba(15,23,42,.9);border:1px solid rgba(255,255,255,.12);border-radius:5px;padding:2px 6px;font-size:8px;font-weight:600;color:#cbd5e1}
  
  /* STO / OLT POIs */
  .map-node{position:absolute;display:flex;flex-direction:column;align-items:center;transform:translate(-50%,-50%);z-index:5}
  .sto-dot{width:8px;height:8px;border-radius:50%;background:#f43f5e;box-shadow:0 0 8px #f43f5e;position:relative;z-index:2}
  .sto-dot.secondary{background:#38bdf8;box-shadow:0 0 8px #38bdf8}
  .radar-ping{position:absolute;width:18px;height:18px;border-radius:50%;border:1px solid rgba(244,63,94,.7);top:-5px;left:-5px;animation:sto-radar 2s cubic-bezier(0,0,.2,1) infinite}
  @keyframes sto-radar{0%{transform:scale(.5);opacity:1}100%{transform:scale(2.2);opacity:0}}
  .sto-badge{margin-top:2px;background:rgba(11,18,32,.92);border:1px solid rgba(255,255,255,.12);padding:1px 5px;border-radius:4px;display:flex;flex-direction:column;align-items:center;white-space:nowrap}
  .sto-name{font-size:7.5px;color:#f8fafc;font-weight:700}
  .sto-code{font-size:6.5px;color:#94a3b8}
  
  /* ODP Pins */
  .odp-pin{position:absolute;transform:translate(-50%,-50%);z-index:4;display:flex;align-items:center;gap:3px}
  .odp-color-dot{width:6px;height:6px;border-radius:50%;flex-shrink:0}
  .odp-red .odp-color-dot{background:#dc2626;box-shadow:0 0 6px rgba(220,38,38,.8)}
  .odp-amber .odp-color-dot{background:#f59e0b;box-shadow:0 0 6px rgba(245,158,11,.8)}
  .odp-green .odp-color-dot{background:#10b981;box-shadow:0 0 6px rgba(16,185,129,.8)}
  .odp-tag{font-size:6.5px;background:rgba(15,23,42,.9);border:1px solid rgba(255,255,255,.1);color:#e2e8f0;padding:1px 3px;border-radius:3px;white-space:nowrap}
  
  /* Mini Legend */
  .mini-leaflet-legend{position:absolute;bottom:6px;left:6px;z-index:10;background:rgba(15,23,42,.9);border:1px solid rgba(255,255,255,.1);border-radius:5px;padding:3px 6px;display:flex;flex-direction:column;gap:1.5px;font-size:7px;color:#94a3b8}
  .mini-leaflet-legend .lg-row{display:flex;align-items:center;gap:4px}
  .mini-leaflet-legend .sw{width:5px;height:5px;border-radius:2px;flex-shrink:0}
  .mini-leaflet-legend .bg-red{background:#dc2626}
  .mini-leaflet-legend .bg-amber{background:#f59e0b}
  .mini-leaflet-legend .bg-green{background:#10b981}
  
  /* Mini Zoom Controls */
  .mini-leaflet-zoom{position:absolute;bottom:6px;right:6px;z-index:10;display:flex;flex-direction:column;background:rgba(15,23,42,.9);border:1px solid rgba(255,255,255,.12);border-radius:4px;overflow:hidden}
  .mini-leaflet-zoom span{width:16px;height:14px;display:grid;place-items:center;font-size:9px;font-weight:700;color:#cbd5e1;cursor:default}
  .mini-leaflet-zoom span:first-child{border-bottom:1px solid rgba(255,255,255,.08)}
  
  /* Bottom City Indicator */
  .mini-city-pill{position:absolute;bottom:6px;left:50%;transform:translateX(-50%);z-index:10;background:rgba(15,23,42,.94);border:1px solid rgba(59,130,246,.3);border-radius:12px;padding:2px 8px;font-size:8px;color:#cbd5e1;display:flex;align-items:center;gap:4px;white-space:nowrap}
  .mini-city-pill .city-dot{width:4px;height:4px;border-radius:50%;background:#38bdf8}

  /* GCU Telemetry Simulation */
  .canvas-gcu{display:flex;flex-direction:column;gap:10px;height:100%}
  .gcu-readings{display:grid;grid-template-columns:repeat(3,1fr);gap:8px}
  .gcu-card{background:#0e1726;border:1px solid rgba(255,255,255,.08);border-radius:8px;padding:8px 10px}
  .gcu-lbl{font-size:10px;color:#94a3b8;margin-bottom:2px}
  .gcu-val{font-size:16px;font-weight:700;color:#38bdf8}
  .gcu-val small{font-size:10px;color:#94a3b8}
  .gcu-stat{display:block;font-size:9px;font-weight:700;color:#10b981;margin-top:2px}
  .gcu-evidence-strip{display:flex;gap:10px;flex:1}
  .gcu-thumb-box{flex:1;background:#0e1726;border:1px solid rgba(255,255,255,.08);border-radius:8px;overflow:hidden;position:relative;display:flex;align-items:center;justify-content:center}
  .evidence-img{width:100%;height:100%;object-fit:cover;opacity:.85}
  .evidence-lbl{position:absolute;bottom:4px;left:6px;font-size:9.5px;background:rgba(0,0,0,.75);padding:2px 6px;border-radius:4px;color:#cbd5e1}

  /* BOQ Flow Simulation */
  .canvas-boq{display:flex;flex-direction:column;gap:12px;height:100%;justify-content:center}
  .boq-stepper{display:flex;align-items:center;gap:6px;background:#0e1726;padding:10px;border-radius:8px;border:1px solid rgba(255,255,255,.08)}
  .boq-step{display:flex;align-items:center;gap:8px;flex:1}
  .boq-step .step-num{width:20px;height:20px;border-radius:50%;background:#1e293b;color:#94a3b8;font-size:10px;font-weight:700;display:grid;place-items:center}
  .boq-step.done .step-num{background:#10b981;color:#fff}
  .boq-step.active .step-num{background:#38bdf8;color:#0f172a}
  .step-info{display:flex;flex-direction:column}
  .step-title{font-size:11px;color:#f8fafc}
  .step-meta{font-size:9px;color:#94a3b8}
  .boq-step-line{width:16px;height:2px;background:#1e293b}
  .boq-step-line.done{background:#10b981}
  .boq-summary-card{background:#0e1726;border:1px solid rgba(255,255,255,.08);padding:10px 12px;border-radius:8px;display:flex;flex-direction:column;gap:4px;font-size:11.5px}
  .boq-row{display:flex;justify-content:space-between;color:#cbd5e1}
  .badge-approved{color:#10b981;font-weight:600;font-size:11px}

  /* Rekon Simulation */
  .canvas-rekon{display:flex;flex-direction:column;gap:6px;height:100%}
  .rekon-table-header{display:grid;grid-template-columns:1.2fr 1.8fr 1fr 1.2fr;font-size:10px;font-weight:700;color:#94a3b8;padding:4px 6px;border-bottom:1px solid rgba(255,255,255,.1)}
  .rekon-row{display:grid;grid-template-columns:1.2fr 1.8fr 1fr 1.2fr;align-items:center;font-size:11px;padding:5px 6px;border-radius:6px;background:#0e1726;border:1px solid rgba(255,255,255,.05);color:#cbd5e1}
  .rekon-chip{font-size:9px;font-weight:700;padding:2px 6px;border-radius:4px;text-align:center;width:fit-content}
  .rekon-chip.match{background:rgba(16,185,129,.2);color:#34d399}
  .rekon-chip.verified{background:rgba(56,189,248,.2);color:#38bdf8}

  /* Wallboard Simulation */
  .canvas-wallboard{display:flex;flex-direction:column;gap:10px;height:100%}
  .wallboard-metric-row{display:grid;grid-template-columns:repeat(3,1fr);gap:8px}
  .wb-metric{background:#0e1726;border:1px solid rgba(255,255,255,.08);border-radius:8px;padding:6px 8px}
  .wb-lbl{font-size:9.5px;color:#94a3b8;display:block}
  .wb-num{font-size:15px;font-weight:700;color:#f8fafc}
  .wb-chart-bar{display:flex;align-items:flex-end;gap:10px;height:120px;background:#0e1726;border-radius:8px;padding:10px 14px;border:1px solid rgba(255,255,255,.08)}
  .chart-col{flex:1;background:linear-gradient(180deg,#38bdf8 0%,#1e40af 100%);border-radius:4px 4px 0 0;position:relative;display:flex;justify-content:center}
  .chart-col span{position:absolute;bottom:-18px;font-size:8.5px;color:#94a3b8;white-space:nowrap}

  /* NTE Simulation */
  .canvas-nte{display:flex;flex-direction:column;height:100%}
  .nte-card{background:#0e1726;border:1px solid rgba(255,255,255,.08);border-radius:8px;padding:10px}
  .nte-top{display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;padding-bottom:6px;border-bottom:1px solid rgba(255,255,255,.08)}
  .nte-title{font-size:11.5px;font-weight:700;color:#f8fafc}
  .nte-badge{font-size:9.5px;color:#38bdf8;background:rgba(56,189,248,.15);padding:2px 6px;border-radius:4px}
  .nte-list{display:flex;flex-direction:column;gap:6px}
  .nte-item{display:flex;justify-content:space-between;font-size:11px;color:#cbd5e1;padding:4px 0;border-bottom:1px dashed rgba(255,255,255,.05)}

  /* Telegram Bot Simulation */
  .canvas-telegram{display:flex;flex-direction:column;gap:10px;height:100%;justify-content:center}
  .tg-header{display:flex;align-items:center;gap:8px;background:#0e1726;padding:8px 10px;border-radius:8px;border:1px solid rgba(255,255,255,.08)}
  .tg-icon{width:26px;height:26px;border-radius:50%;background:#0088cc;color:#fff;display:grid;place-items:center}
  .tg-title-box{display:flex;flex-direction:column}
  .tg-title{font-size:11px;font-weight:700;color:#f8fafc}
  .tg-sub{font-size:9px;color:#94a3b8}
  .tg-bubble{background:#182538;border:1px solid rgba(0,136,204,.3);border-radius:12px;padding:10px 12px;display:flex;flex-direction:column;gap:6px}
  .tg-badge{font-size:9.5px;font-weight:700;color:#f87171}
  .tg-msg{font-size:11px;color:#cbd5e1;line-height:1.4}
  .tg-time{font-size:9.5px;color:#94a3b8;align-self:flex-end}

  /* Mockup Tab Strip (interactive preview switcher) */
  .mockup-tab-strip{display:flex;align-items:center;gap:10px;padding:9px 12px;background:#101827;border-top:1px solid rgba(255,255,255,.08);flex-wrap:wrap}
  .tab-strip-lbl{font-size:11px;font-weight:600;color:#94a3b8}
  .tab-strip-btns{display:flex;gap:6px;flex-wrap:wrap}
  .mockup-sub-tab{background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.1);padding:3px 9px;border-radius:6px;
    color:#cbd5e1;font-size:11px;font-weight:600;cursor:pointer;transition:all .15s ease}
  .mockup-sub-tab:hover{background:rgba(255,255,255,.14);color:#fff}
  .mockup-sub-tab.active{background:#1e6fd6;border-color:#1e6fd6;color:#fff;box-shadow:0 2px 6px rgba(30,111,214,.4)}

  /* Right Column: Architectural Specs & Details */
  .card-specs-col{display:flex;flex-direction:column}
  .specs-head{margin-bottom:12px}
  .proj-brand-row{display:flex;align-items:center;gap:12px;margin-bottom:8px}
  .proj-logo-box{width:42px;height:42px;border-radius:11px;background:#ffffff;border:1px solid var(--border);
    display:grid;place-items:center;padding:5px;box-shadow:0 2px 6px rgba(0,0,0,.04);flex-shrink:0}
  .proj-logo-img{width:100%;height:100%;object-fit:contain}
  .proj-title{font-size:19px;font-weight:800;color:var(--ink);letter-spacing:-.015em;line-height:1.2}
  .proj-sub{font-size:13px;color:var(--navy);font-weight:600}
  [data-theme="dark"] .proj-sub{color:var(--blue)}

  .proj-author-tag{display:inline-flex;align-items:center;gap:8px;font-size:11.5px;color:var(--muted);background:var(--surface-2);
    border:1px solid var(--border);padding:3px 9px;border-radius:6px;width:fit-content}
  .proj-author-tag .role-badge{font-weight:700;color:var(--ink)}

  .proj-desc{font-size:13.5px;color:var(--body);line-height:1.55;margin-bottom:14px}

  /* Property Spec Matrix (2x2 Grid) */
  .proj-spec-matrix{display:grid;grid-template-columns:1fr 1fr;gap:10px;background:var(--surface-2);border:1px solid var(--border);
    border-radius:14px;padding:12px 14px;margin-bottom:16px}
  .spec-cell{display:flex;flex-direction:column;gap:2px}
  .spec-lbl{display:inline-flex;align-items:center;gap:5px;font-size:11px;font-weight:600;color:var(--muted)}
  .spec-lbl svg{color:var(--navy);flex-shrink:0}
  [data-theme="dark"] .spec-lbl svg{color:var(--blue)}
  .spec-val{font-size:12px;font-weight:600;color:var(--ink);line-height:1.3}

  .proj-stack-chips{display:flex;flex-wrap:wrap;gap:6px;margin-bottom:18px}
  .proj-stack-chips .sk{font-size:11.5px;padding:3px 9px}

  .proj-card-actions{display:flex;align-items:center;gap:10px;margin-top:auto}
  .proj-detail-btn{font-size:13px;padding:10px 16px}

  /* Bottom Progress Bar & Jump Dots */
  .proj-bottom-nav{display:flex;flex-direction:column;align-items:center;gap:14px;margin-top:8px;padding:0 24px}
  .proj-progress-track{width:100%;max-width:320px;height:4px;background:var(--border);border-radius:4px;overflow:hidden;
    cursor:pointer;position:relative}
  .proj-progress-fill{height:100%;background:var(--navy);border-radius:4px;transition:width .25s ease}
  [data-theme="dark"] .proj-progress-fill{background:var(--blue)}
  

  .proj-note{margin-top:4px;font-size:12.5px;color:var(--muted);text-align:center;max-width:68ch}



  /* Modal Lightbox for Project Full Specs */
  .proj-specs-modal{max-width:660px}
  .modal-specs-content{display:flex;flex-direction:column;gap:18px;max-height:68vh;overflow-y:auto;padding-right:6px}
  .modal-spec-block{display:flex;flex-direction:column;gap:8px}
  .modal-spec-head{font-size:12px;font-weight:700;color:var(--navy);text-transform:uppercase;letter-spacing:.06em}
  [data-theme="dark"] .modal-spec-head{color:var(--blue)}
  .modal-spec-text{font-size:13.5px;color:var(--body);line-height:1.65}
  
  /* Parameter & Spesifikasi Sistem Matrix */
  .modal-spec-grid{display:grid;grid-template-columns:1fr 1fr;gap:10px;background:var(--surface-2);border:1px solid var(--border);border-radius:12px;padding:12px 14px}
  .modal-grid-cell{display:flex;flex-direction:column;gap:2px}
  .modal-grid-cell .cell-label{font-size:11px;font-weight:600;color:var(--muted)}
  .modal-grid-cell .cell-val{font-size:12.5px;font-weight:700;color:var(--ink);line-height:1.35}

  .modal-module-list{display:flex;flex-direction:column;gap:10px}
  .modal-module-item{display:flex;align-items:flex-start;gap:12px;background:var(--surface-2);border:1px solid var(--border);
    padding:12px 14px;border-radius:12px}
  .feat-bullet{color:var(--navy);font-size:13px;margin-top:2px}
  [data-theme="dark"] .feat-bullet{color:var(--blue)}
  .feat-name{font-size:13.5px;color:var(--ink);display:block;margin-bottom:3px}
  .feat-desc{font-size:12px;color:var(--body);line-height:1.55}
  .modal-specs-footer{display:flex;align-items:center;justify-content:flex-end;gap:10px;margin-top:20px;padding-top:14px;border-top:1px solid var(--border)}

  @media (max-width:960px){
    .card-split-body{grid-template-columns:1fr;gap:18px}
    .proj-wide-card{flex:0 0 calc(100vw - 48px)}
    .proj-toolbar{width:100%;justify-content:space-between}
    .proj-cluster-tabs{overflow-x:auto;max-width:100%}
  }

  /* ---------- certificates (self/certificates) ---------- */
  .cert-filters{display:flex;align-items:center;gap:10px;margin-bottom:28px;flex-wrap:wrap}
  .cert-filter-btn{display:inline-flex;align-items:center;gap:8px;padding:8px 16px;border-radius:20px;
    font-size:13.5px;font-weight:600;color:var(--muted);background:var(--surface-2);border:1px solid var(--border);
    transition:.18s ease;cursor:pointer}
  .cert-filter-btn:hover{color:var(--ink);border-color:var(--navy)}
  .cert-filter-btn.active{background:var(--navy);color:#fff;border-color:var(--navy);box-shadow:var(--shadow)}
  .cert-filter-btn .count{font-size:11px;padding:2px 7px;border-radius:10px;background:rgba(255,255,255,.18);color:inherit}
  .cert-filter-btn:not(.active) .count{background:var(--chip);color:var(--muted)}
  
  .cert-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(330px,1fr));gap:24px}
  .cert-card{background:var(--surface);border:1px solid var(--border);border-radius:18px;overflow:hidden;
    box-shadow:var(--shadow);display:flex;flex-direction:column;transition:transform .25s ease,box-shadow .25s ease}
  .cert-card:hover{transform:translateY(-4px);box-shadow:0 16px 36px -10px rgba(0,0,0,.14)}
  .cert-card.cert-featured{border-color:color-mix(in srgb,var(--navy) 40%,var(--border));
    box-shadow:0 4px 20px -4px rgba(31,78,121,.15)}
  
  .cert-thumb-box{position:relative;width:100%;aspect-ratio:16/10.8;background:#0d141e;overflow:hidden;
    cursor:pointer;border-bottom:1px solid var(--border)}
  .cert-thumb-img{width:100%;height:100%;object-fit:cover;object-position:top center;transition:transform .35s ease}
  .cert-thumb-box:hover .cert-thumb-img{transform:scale(1.05)}
  .cert-thumb-overlay{position:absolute;inset:0;background:rgba(15,23,42,.35);display:flex;align-items:center;
    justify-content:center;opacity:0;transition:opacity .2s ease;backdrop-filter:blur(2px)}
  .cert-thumb-box:hover .cert-thumb-overlay{opacity:1}
  .cert-view-badge{display:inline-flex;align-items:center;gap:6px;padding:6px 13px;border-radius:20px;
    background:rgba(255,255,255,.92);color:#0f172a;font-size:12px;font-weight:700;box-shadow:0 4px 12px rgba(0,0,0,.25)}
  .cert-type-pill{position:absolute;bottom:10px;left:10px;padding:4px 10px;border-radius:7px;
    font-size:11px;font-weight:700;background:rgba(15,23,42,.85);color:#fff;backdrop-filter:blur(6px);
    border:1px solid rgba(255,255,255,.15);letter-spacing:.02em}
  .cert-type-pill.pill-python{background:rgba(30,111,214,.88)}
  .cert-type-pill.pill-marketing{background:rgba(234,67,53,.88)}
  .cert-type-pill.pill-professional{background:rgba(31,78,121,.88)}

  .cert-body{padding:20px 20px 18px;display:flex;flex-direction:column;flex:1}
  .cert-meta-top{display:flex;align-items:center;justify-content:space-between;gap:10px;font-size:12px;color:var(--muted);margin-bottom:8px}
  .cert-issuer{display:inline-flex;align-items:center;gap:6px;color:var(--navy);font-weight:600}
  .cert-date{color:var(--muted)}
  .cert-title{font-size:16px;font-weight:700;color:var(--ink);line-height:1.35;margin-bottom:8px;
    display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;min-height:43px}
  .cert-credential{font-size:11.5px;color:var(--muted);margin-bottom:12px;background:var(--surface-2);
    border:1px solid var(--border);padding:3px 8px;border-radius:6px;display:inline-flex;align-items:center;gap:6px;width:fit-content}
  .cert-credential .lbl{font-weight:600;color:var(--ink)}
  .cert-skills{margin-top:auto;margin-bottom:16px;gap:6px}
  .cert-skills .sk{font-size:11.5px;padding:3px 8px;border-radius:6px}

  .cert-actions{display:flex;align-items:center;gap:8px;padding-top:14px;border-top:1px solid var(--border);margin-top:auto}
  .cert-btn{display:inline-flex;align-items:center;gap:6px;padding:7px 12px;border-radius:8px;
    font-size:12.5px;font-weight:600;text-decoration:none;transition:.18s ease;cursor:pointer}
  .cert-btn.pdf-btn{background:var(--navy);color:#fff}
  .cert-btn.pdf-btn:hover{filter:brightness(1.08);transform:translateY(-1px)}
  .cert-btn.verify-btn{border:1px solid var(--border);color:var(--ink);background:var(--surface-2)}
  .cert-btn.verify-btn:hover{border-color:var(--navy);transform:translateY(-1px)}
  .cert-btn.ghost-btn{border:1px solid var(--border);color:var(--muted);background:var(--surface-2);padding:7px 9px}
  .cert-btn.ghost-btn:hover{color:var(--ink);border-color:var(--navy)}

  /* Lightbox modal for certificate full preview */
  .cert-modal-backdrop{position:fixed;inset:0;z-index:1300;background:rgba(15,23,42,.75);
    backdrop-filter:blur(8px);-webkit-backdrop-filter:blur(8px);display:grid;place-items:center;padding:20px;overflow-y:auto}
  .cert-modal-dialog{width:100%;max-width:880px;background:var(--surface);border:1px solid var(--border);
    border-radius:20px;box-shadow:0 24px 60px -12px rgba(0,0,0,.45);overflow:hidden;display:flex;flex-direction:column;
    max-height:92vh;animation:modalScale .24s cubic-bezier(.2,.8,.2,1)}
  .cert-modal-header{padding:18px 24px;border-bottom:1px solid var(--border);display:flex;align-items:flex-start;
    justify-content:space-between;gap:16px;background:var(--surface-2)}
  .cert-modal-title-group{flex:1}
  .cert-modal-badge{display:inline-block;padding:2px 8px;border-radius:5px;background:var(--chip);
    border:1px solid var(--border);font-size:11px;font-weight:700;color:var(--navy);margin-bottom:4px}
  .cert-modal-title{font-size:18px;font-weight:700;color:var(--ink);line-height:1.25}
  .cert-modal-meta{font-size:12.5px;color:var(--muted);margin-top:4px}
  .cert-modal-body{padding:16px;overflow-y:auto;display:flex;justify-content:center;align-items:center;background:#0d141e}
  .cert-modal-img-wrap{width:100%;display:flex;justify-content:center}
  .cert-modal-full-img{max-width:100%;max-height:64vh;object-fit:contain;border-radius:8px;box-shadow:0 6px 20px rgba(0,0,0,.35)}
  .cert-modal-footer{padding:14px 24px;border-top:1px solid var(--border);display:flex;flex-wrap:wrap;
    align-items:center;gap:10px;justify-content:flex-end;background:var(--surface)}

  /* Read more / collapse toggle */
  .cert-more-wrap{display:flex;justify-content:center;margin-top:32px}
  .cert-more-btn{display:inline-flex;align-items:center;gap:10px;padding:12px 24px;border-radius:12px;
    font-size:14px;font-weight:600;background:var(--surface);border:1px solid var(--border);
    color:var(--ink);box-shadow:var(--shadow);transition:.2s ease;cursor:pointer}
  .cert-more-btn:hover{border-color:var(--navy);transform:translateY(-2px);color:var(--navy)}
  .cert-more-btn svg{color:var(--navy);transition:transform .2s ease}

  /* ---------- scroll reveal ---------- */
  .reveal{opacity:0;transition:opacity .7s ease, transform .7s cubic-bezier(.2,.7,.2,1)}
  .reveal.from-left{transform:translateX(-36px)}
  .reveal.from-right{transform:translateX(36px)}
  .reveal.from-up{transform:translateY(22px)}
  .reveal.in{opacity:1;transform:translate(0,0)}

  @media (max-width:960px){
    .top-nav{display:none}
    .loc-clock-pill{display:none}
    .hero{padding:84px 0 40px}
    .hero-layout{grid-template-columns:1fr;gap:36px}
    .hero-visual{order:-1}
    .hero-card{max-width:280px}
    .tl{grid-template-columns:1fr;gap:6px}
    .grid2{grid-template-columns:1fr;gap:28px}
  }
  /* ---------- floating auto-maximizing sidebar ---------- */
  .nav-rail{
    position:fixed;left:18px;top:50%;transform:translateY(-50%);z-index:90;
    width:50px;background:color-mix(in srgb,var(--surface) 88%,transparent);
    backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px);
    border:1px solid var(--border);border-radius:18px;padding:8px 5px;
    box-shadow:0 12px 32px -8px rgba(0,0,0,.15);
    transition:width .32s cubic-bezier(.2,.8,.2,1),padding .32s ease,box-shadow .32s ease,background .32s ease;
    overflow:hidden;
  }
  .nav-rail:hover{
    width:200px;padding:12px 10px;background:var(--surface);
    box-shadow:0 20px 45px -10px rgba(0,0,0,.24),0 0 0 1px var(--border);
  }
  .nav-rail-header{
    display:flex;align-items:center;gap:8px;padding:2px 8px 10px;
    border-bottom:1px solid var(--border);margin-bottom:6px;
    opacity:0;transform:translateX(-8px);transition:opacity .22s ease,transform .22s ease;
    pointer-events:none;
  }
  .nav-rail:hover .nav-rail-header{
    opacity:1;transform:translateX(0);
  }
  .nav-rail-header .dot{width:7px;height:7px;border-radius:50%;background:var(--red);flex-shrink:0}
  .nav-rail-header .title{
    font-family:"JetBrains Mono",monospace;font-size:10.5px;font-weight:700;
    letter-spacing:.08em;color:var(--muted);text-transform:uppercase;white-space:nowrap;
  }
  .nav-rail-list{list-style:none;display:flex;flex-direction:column;gap:4px;margin:0;padding:0}
  .nav-rail-btn{
    position:relative;display:flex;align-items:center;width:100%;height:38px;padding:0 8px;
    border-radius:10px;background:transparent;border:none;color:var(--muted);
    cursor:pointer;font-size:13px;font-weight:500;transition:background .18s ease,color .18s ease;text-align:left;
  }
  .nav-rail-btn:hover{background:var(--surface-2);color:var(--ink)}
  .nav-rail-btn.active{background:color-mix(in srgb,var(--navy) 12%,var(--surface-2));color:var(--ink);font-weight:600}
  .nav-rail-btn.active .nav-icon{color:var(--red)}
  .nav-rail-btn.active::before{
    content:"";position:absolute;left:2px;top:50%;transform:translateY(-50%);
    width:3px;height:18px;border-radius:2px;background:var(--red);
  }
  .nav-icon{width:20px;height:20px;display:grid;place-items:center;flex-shrink:0;transition:color .18s ease}
  .nav-label{
    display:flex;align-items:center;gap:8px;margin-left:10px;white-space:nowrap;
    opacity:0;transform:translateX(-8px);transition:opacity .22s ease,transform .22s ease;
  }
  .nav-rail:hover .nav-label{opacity:1;transform:translateX(0)}
  .nav-num{font-family:"JetBrains Mono",monospace;font-size:11px;color:var(--red);font-weight:600}
  .nav-text{font-size:13px;color:var(--ink);font-weight:500}
  .nav-rail-btn.active .nav-text{font-weight:700}

  @media (max-width:960px){
    .nav-rail{display:none}
  }

  /* ---------- contact popup modal ---------- */
  .modal-backdrop{
    position:fixed;inset:0;z-index:9999;
    background:rgba(10,16,26,0.65);
    backdrop-filter:blur(12px);-webkit-backdrop-filter:blur(12px);
    display:grid;place-items:center;padding:20px;
  }
  .modal-dialog{
    width:100%;max-width:480px;background:var(--surface);
    border:1px solid var(--border);border-radius:24px;padding:26px 28px;
    box-shadow:0 24px 64px -12px rgba(0,0,0,.35),0 0 0 1px rgba(255,255,255,.06);
    animation:modal-pop .24s cubic-bezier(.2,.8,.2,1);
    position:relative;
  }
  @keyframes modal-pop{
    from{opacity:0;transform:scale(.94) translateY(10px)}
    to{opacity:1;transform:scale(1) translateY(0)}
  }
  .modal-fade-enter-active,.modal-fade-leave-active{
    transition:opacity .22s ease;
  }
  .modal-fade-enter-from,.modal-fade-leave-to{
    opacity:0;
  }
  .modal-fade-enter-from .modal-dialog,.modal-fade-leave-to .modal-dialog{
    transform:scale(.94) translateY(10px);
  }
  .modal-header{
    display:flex;align-items:flex-start;justify-content:space-between;
    gap:16px;margin-bottom:20px;padding-bottom:16px;border-bottom:1px solid var(--border);
  }
  .modal-title-box{display:flex;align-items:center;gap:14px}
  .modal-icon-badge{
    width:44px;height:44px;border-radius:12px;background:var(--surface-2);
    border:1px solid var(--border);display:grid;place-items:center;color:var(--navy);
    flex-shrink:0;box-shadow:0 2px 6px rgba(0,0,0,.04);
  }
  .modal-title{font-size:18px;font-weight:700;color:var(--ink);margin-bottom:2px}
  .modal-sub{font-size:13px;color:var(--muted)}
  .modal-close-btn{
    width:34px;height:34px;border-radius:10px;border:1px solid var(--border);
    background:var(--surface-2);color:var(--muted);display:grid;place-items:center;
    cursor:pointer;transition:all .15s ease;flex-shrink:0;
  }
  .modal-close-btn:hover{color:var(--ink);border-color:var(--navy);transform:scale(1.05)}
  
  .contact-links{display:flex;flex-direction:column;gap:12px}
  .contact-card{
    display:flex;align-items:center;gap:15px;padding:14px 18px;
    border-radius:16px;border:1px solid var(--border);background:var(--surface-2);
    text-decoration:none;color:inherit;transition:all .2s ease;position:relative;
  }
  .contact-card:hover{
    border-color:var(--navy);transform:translateY(-2px);
    box-shadow:0 8px 24px -6px rgba(0,0,0,.12);
  }
  .contact-card-icon-box{
    width:46px;height:46px;border-radius:12px;display:grid;place-items:center;
    flex-shrink:0;transition:transform .2s ease;
  }
  .contact-card:hover .contact-card-icon-box{transform:scale(1.08)}
  .wa-box{background:rgba(37,211,102,0.12);color:#25D366}
  .email-box{background:rgba(225,27,39,0.12);color:var(--red)}
  .linkedin-box{background:rgba(10,102,194,0.12);color:#0A66C2}
  
  .contact-card-info{flex:1;min-width:0}
  .contact-card-title{
    display:flex;align-items:center;gap:8px;font-size:14.5px;font-weight:700;
    color:var(--ink);margin-bottom:2px;
  }
  .contact-badge{
    font-family:"JetBrains Mono",monospace;font-size:10px;font-weight:600;
    padding:2px 7px;border-radius:6px;
  }
  .wa-badge{background:rgba(37,211,102,0.16);color:#128C7E}
  .contact-card-val{
    font-family:"JetBrains Mono",monospace;font-size:12.5px;color:var(--body);
    white-space:nowrap;overflow:hidden;text-overflow:ellipsis;margin-bottom:2px;
  }
  .contact-card-desc{font-size:12px;color:var(--muted)}
  .contact-card-arrow{color:var(--muted);transition:transform .2s ease,color .2s ease}
  .contact-card:hover .contact-card-arrow{color:var(--ink);transform:translate(2px,-2px)}
</style>
</head>
<body>
<script>window.I18N = { en:{}, id:{} };</script>
<div id="app" v-cloak>

  <!-- TOP BAR (Full Width Edge-to-Edge) -->
  <header class="bar">
    <div class="bar-inner">
      <a href="#" class="logo" @click.prevent="goToSection('hero')">
        <img src="/images/logo/mark-color-on-light.svg" alt="Reza Pratama" class="logo-mark-img" />
        <span class="logo-text">Reza Pratama</span>
      </a>

      <!-- Desktop Navigation Menu (Ergonomic, Minimizes Eye Travel) -->
      <nav class="top-nav" aria-label="Main Navigation">
        <button 
          v-for="item in navItems" 
          :key="item.id"
          type="button"
          class="top-nav-btn"
          :class="{ active: activeSection === item.id }"
          @click="goToSection(item.id)"
        >
          {{ t.nav[item.id] }}
        </button>
      </nav>

      <div class="spacer"></div>

      <!-- Calmed-down Digital Time & Location (No restless ticking seconds) -->
      <div class="loc-clock-pill mono" :title="'Waktu lokal Balikpapan (WITA): ' + clock.date">
        <span class="loc-pin-dot"></span>
        <span class="loc-name">Balikpapan</span>
        <span class="loc-sep">·</span>
        <span class="loc-time">{{ clock.time }} <span class="loc-tz">WITA</span></span>
      </div>

      <!-- Language Switcher -->
      <div class="ctrl">
        <button :class="{on:lang==='en'}" @click="lang='en'">EN</button>
        <button :class="{on:lang==='id'}" @click="lang='id'">ID</button>
      </div>

      <!-- Theme Switcher -->
      <button class="icbtn" @click="toggleTheme" :title="t.themeToggle">
        <svg v-if="theme==='light'" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M21 12.8A9 9 0 1 1 11.2 3a7 7 0 0 0 9.8 9.8Z"/></svg>
        <svg v-else width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M2 12h2M20 12h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4"/></svg>
      </button>
    </div>
  </header>
@endverbatim

  <!-- SIDEBAR NAVIGATION -->
  @include('common.nav-sidebar')

  {{-- Profile / hero --}}
  @include('self.profile')

  {{-- Experience --}}
  @include('self.experience')

  {{-- Skills & education --}}
  @include('self.skills')

  {{-- Licenses & Certifications --}}
  @include('self.certificates')

  {{-- Project miniatures (external links) --}}
  @include('project.cards')

@verbatim
  <!-- FOOTER -->
  <footer id="contact">
    <div class="wrap">
      <div class="foot">
        <div class="links">
          <a class="link" :href="'https://wa.me/6287781234450?text=' + encodeURIComponent(t.waMessage)" target="_blank" rel="noopener">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0 0 12.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.23 8.23 0 0 1 2.41 5.83c0 4.54-3.7 8.24-8.24 8.24-1.42 0-2.82-.37-4.06-1.07l-.29-.16-3.02.79.81-2.94-.19-.3a8.18 8.18 0 0 1-1.25-4.36c0-4.54 3.69-8.24 8.23-8.24m4.52 11.66c-.25-.13-1.47-.72-1.7-.81-.23-.08-.39-.13-.56.13-.17.25-.64.81-.79.97-.14.17-.29.19-.54.06-.25-.13-1.05-.39-2-1.23-.74-.66-1.24-1.47-1.38-1.72-.15-.25-.02-.38.11-.51.11-.11.25-.29.38-.44.12-.14.17-.25.25-.41.08-.17.04-.31-.02-.44-.06-.13-.56-1.34-.76-1.84-.2-.48-.41-.42-.56-.43h-.48c-.17 0-.44.06-.66.31-.23.25-.88.86-.88 2.1s.9 2.43 1.03 2.6c.12.17 1.77 2.7 4.28 3.79.6.26 1.07.41 1.43.53.6.19 1.15.16 1.58.1.48-.07 1.47-.6 1.68-1.18.21-.58.21-1.07.15-1.18-.06-.11-.23-.17-.48-.29"/></svg>
            WhatsApp
          </a>
          <a class="link" href="mailto:rezprama@gmail.com">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg>
            rezprama@gmail.com
          </a>
          <a class="link" href="https://linkedin.com/in/rezpra" target="_blank" rel="noopener">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M4.98 3.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5ZM3 9h4v12H3zM9 9h3.8v1.7h.05c.53-.95 1.83-1.95 3.77-1.95 4.03 0 4.78 2.5 4.78 5.75V21h-4v-4.9c0-1.17-.02-2.67-1.9-2.67-1.9 0-2.2 1.27-2.2 2.58V21H9z"/></svg>
            linkedin.com/in/rezpra
          </a>
        </div>
        <div class="stack">
          {{ t.builtWith }}<br>
          <b>Laravel 13</b> · PHP 8.3 · Vue.js · Tailwind CSS
        </div>
      </div>
    </div>
  </footer>

  <!-- CONTACT POPUP MODAL -->
  <transition name="modal-fade">
    <div class="modal-backdrop" v-if="contactModalOpen" v-cloak @click.self="closeContactModal">
      <div class="modal-dialog" role="dialog" aria-modal="true" aria-labelledby="contact-modal-title">
        <div class="modal-header">
          <div class="modal-title-box">
            <div class="modal-icon-badge">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            </div>
            <div>
              <h3 class="modal-title" id="contact-modal-title">{{ t.contactModalTitle }}</h3>
              <p class="modal-sub">{{ t.contactModalSub }}</p>
            </div>
          </div>
          <button type="button" class="modal-close-btn" @click="closeContactModal" aria-label="Close">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M18 6 6 18M6 6l12 12"/></svg>
          </button>
        </div>

        <div class="contact-links">
          <!-- WhatsApp Business -->
          <a class="contact-card contact-wa" :href="'https://wa.me/6287781234450?text=' + encodeURIComponent(t.waMessage)" target="_blank" rel="noopener">
            <div class="contact-card-icon-box wa-box">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0 0 12.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.23 8.23 0 0 1 2.41 5.83c0 4.54-3.7 8.24-8.24 8.24-1.42 0-2.82-.37-4.06-1.07l-.29-.16-3.02.79.81-2.94-.19-.3a8.18 8.18 0 0 1-1.25-4.36c0-4.54 3.69-8.24 8.23-8.24m4.52 11.66c-.25-.13-1.47-.72-1.7-.81-.23-.08-.39-.13-.56.13-.17.25-.64.81-.79.97-.14.17-.29.19-.54.06-.25-.13-1.05-.39-2-1.23-.74-.66-1.24-1.47-1.38-1.72-.15-.25-.02-.38.11-.51.11-.11.25-.29.38-.44.12-.14.17-.25.25-.41.08-.17.04-.31-.02-.44-.06-.13-.56-1.34-.76-1.84-.2-.48-.41-.42-.56-.43h-.48c-.17 0-.44.06-.66.31-.23.25-.88.86-.88 2.1s.9 2.43 1.03 2.6c.12.17 1.77 2.7 4.28 3.79.6.26 1.07.41 1.43.53.6.19 1.15.16 1.58.1.48-.07 1.47-.6 1.68-1.18.21-.58.21-1.07.15-1.18-.06-.11-.23-.17-.48-.29"/></svg>
            </div>
            <div class="contact-card-info">
              <div class="contact-card-title">
                <span>{{ t.contactWaTitle }}</span>
                <span class="contact-badge wa-badge">{{ t.contactWaBadge }}</span>
              </div>
              <div class="contact-card-val">+62 877-8123-4450</div>
              <div class="contact-card-desc">{{ t.contactWaDesc }}</div>
            </div>
            <div class="contact-card-arrow">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M7 17 17 7M8 7h9v9"/></svg>
            </div>
          </a>

          <!-- Email -->
          <a class="contact-card contact-email" href="mailto:rezprama@gmail.com" target="_blank" rel="noopener">
            <div class="contact-card-icon-box email-box">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg>
            </div>
            <div class="contact-card-info">
              <div class="contact-card-title">
                <span>{{ t.contactEmailTitle }}</span>
              </div>
              <div class="contact-card-val">rezprama@gmail.com</div>
              <div class="contact-card-desc">{{ t.contactEmailDesc }}</div>
            </div>
            <div class="contact-card-arrow">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M7 17 17 7M8 7h9v9"/></svg>
            </div>
          </a>

          <!-- LinkedIn -->
          <a class="contact-card contact-linkedin" href="https://linkedin.com/in/rezpra" target="_blank" rel="noopener">
            <div class="contact-card-icon-box linkedin-box">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M4.98 3.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5ZM3 9h4v12H3zM9 9h3.8v1.7h.05c.53-.95 1.83-1.95 3.77-1.95 4.03 0 4.78 2.5 4.78 5.75V21h-4v-4.9c0-1.17-.02-2.67-1.9-2.67-1.9 0-2.2 1.27-2.2 2.58V21H9z"/></svg>
            </div>
            <div class="contact-card-info">
              <div class="contact-card-title">
                <span>{{ t.contactLinkedinTitle }}</span>
              </div>
              <div class="contact-card-val">linkedin.com/in/rezpra</div>
              <div class="contact-card-desc">{{ t.contactLinkedinDesc }}</div>
            </div>
            <div class="contact-card-arrow">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M7 17 17 7M8 7h9v9"/></svg>
            </div>
          </a>
        </div>
      </div>
    </div>
  </transition>
</div>

<script>
Object.assign(I18N.en, {
  themeToggle: "Toggle theme",
  builtWith: "Built with",
  contactModalTitle: "Get in Touch",
  contactModalSub: "Select your preferred platform to connect with me",
  contactWaTitle: "WhatsApp Business",
  contactWaBadge: "Fast Response",
  contactWaDesc: "Direct chat for discussions & inquiries",
  waMessage: "Hello Reza, I saw your portfolio and would like to get in touch.",
  contactEmailTitle: "Email",
  contactEmailDesc: "For project collaborations and formal inquiries",
  contactLinkedinTitle: "LinkedIn",
  contactLinkedinDesc: "Professional network and profile",
});

Object.assign(I18N.id, {
  themeToggle: "Ganti tema",
  builtWith: "Dibangun dengan",
  contactModalTitle: "Hubungi Saya",
  contactModalSub: "Pilih platform yang paling nyaman untuk Anda",
  contactWaTitle: "WhatsApp Business",
  contactWaBadge: "Respon Cepat",
  contactWaDesc: "Chat langsung untuk diskusi cepat & kerja sama",
  waMessage: "Halo Reza, saya menghubungi Anda melalui website portofolio.",
  contactEmailTitle: "Email Langsung",
  contactEmailDesc: "Untuk diskusi proyek resmi dan penawaran kerja sama",
  contactLinkedinTitle: "LinkedIn",
  contactLinkedinDesc: "Jejaring profesional dan profil karir",
});

const { createApp } = Vue;

function setupReveal(){
  const io = new IntersectionObserver((entries) => {
    entries.forEach((en) => {
      if (en.isIntersecting) { en.target.classList.add("in"); io.unobserve(en.target); }
    });
  }, { threshold:0.1, rootMargin:"0px 0px -20px 0px" });
  document.querySelectorAll(".reveal:not(.in)").forEach((el) => {
    const rect = el.getBoundingClientRect();
    if (rect.top < window.innerHeight && rect.bottom > 0) {
      el.classList.add("in");
    } else {
      io.observe(el);
    }
  });
}

createApp({
  data(){
    return {
      lang:"id",
      theme: window.matchMedia && window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark":"light",
      clock:{time:"--:--",date:""},
      projects: window.PROJECTS,
      certificates: window.CERTIFICATES || [],
      navItems: window.NAV_ITEMS || [],
      operationalModules: window.OPERATIONAL_MODULES || [],
      activeSection: "hero",
      contactModalOpen: false,
      certFilter: "all",
      previewCert: null,
      certLimit: 6,
      showAllCerts: false,
      activeProjIdx: 0,
      projProgressPct: 33,
      activeModuleTab: { tifreg: "gis", dalapareg: "rekon", tomman: "dispatch" },
      selectedDetailProj: null,
      isDraggingProj: false,
      dragStartX: 0,
      dragScrollStart: 0,
      hasDragged: false,
    };
  },
  computed:{
    t(){ return I18N[this.lang]; },
    filteredCertificates(){
      if (this.certFilter === 'all') return this.certificates;
      return this.certificates.filter(c => c.category === this.certFilter);
    },
    displayedCertificates(){
      if (this.showAllCerts || this.filteredCertificates.length <= this.certLimit) {
        return this.filteredCertificates;
      }
      return this.filteredCertificates.slice(0, this.certLimit);
    },
  },
  methods:{
    toggleTheme(){ this.theme = this.theme==="light"?"dark":"light"; },
    openContactModal(){ this.contactModalOpen = true; },
    closeContactModal(){ this.contactModalOpen = false; },
    openCertPreview(cert){ this.previewCert = cert; },
    closeCertPreview(){ this.previewCert = null; },
    countCategory(cat){ return this.certificates.filter(c => c.category === cat).length; },
    toggleCertsExpanded(){
      this.showAllCerts = !this.showAllCerts;
      this.$nextTick(() => {
        setupReveal();
      });
      if (!this.showAllCerts) {
        const el = document.getElementById("certifications");
        if (el) {
          const offset = el.getBoundingClientRect().top + window.pageYOffset - 70;
          window.scrollTo({ top: Math.max(0, offset), behavior: "smooth" });
        }
      }
    },
    scrollToProj(idx){
      const total = this.projects ? this.projects.length : 3;
      if (idx < 0) idx = 0;
      if (idx >= total) idx = total - 1;
      this.activeProjIdx = idx;
      this.updateProjProgress();
      const reel = this.$refs.projReelRef;
      if (!reel) return;
      const cards = reel.querySelectorAll(".proj-wide-card");
      if (cards[idx]) {
        const card = cards[idx];
        const reelWidth = reel.clientWidth;
        const cardWidth = card.offsetWidth;
        const targetScrollLeft = card.offsetLeft - (reelWidth - cardWidth) / 2;
        
        // Temporarily pause snap so programmatic smooth scroll glides without micro-jitter
        reel.style.scrollSnapType = 'none';
        reel.style.scrollBehavior = 'smooth';
        reel.scrollTo({ left: Math.max(0, targetScrollLeft), behavior: "smooth" });
        
        clearTimeout(this._snapTimer);
        this._snapTimer = setTimeout(() => {
          if (!this.isDraggingProj && reel) {
            reel.style.scrollSnapType = 'x mandatory';
          }
        }, 500);
      }
    },
    nextProj(){
      if (this.activeProjIdx < (this.projects ? this.projects.length - 1 : 2)) {
        this.scrollToProj(this.activeProjIdx + 1);
      }
    },
    prevProj(){
      if (this.activeProjIdx > 0) {
        this.scrollToProj(this.activeProjIdx - 1);
      }
    },
    updateProjProgress(){
      const total = this.projects ? this.projects.length : 3;
      this.projProgressPct = Math.min(100, Math.max(20, ((this.activeProjIdx + 1) / total) * 100));
    },
    onProjReelScroll(e){
      const reel = e.target;
      if (!reel || this.isDraggingProj) return;
      if (this._scrollRaf) return;
      this._scrollRaf = requestAnimationFrame(() => {
        this._scrollRaf = null;
        if (!reel) return;
        const cards = reel.children;
        if (!cards || !cards.length) return;
        const firstCard = cards[0];
        const cardWidth = firstCard ? firstCard.offsetWidth : 800;
        const step = cardWidth + 28;
        const rawIdx = Math.round(reel.scrollLeft / step);
        const maxIdx = (this.projects ? this.projects.length : 3) - 1;
        const clampedIdx = Math.max(0, Math.min(maxIdx, rawIdx));
        if (clampedIdx !== this.activeProjIdx) {
          this.activeProjIdx = clampedIdx;
          this.updateProjProgress();
        }
      });
    },
    startDragProj(e){
      if (e.target.closest("button, a, input, select, textarea")) return;
      this.isDraggingProj = true;
      this.hasDragged = false;
      this.dragStartX = e.pageX;
      this.lastDragX = e.pageX;
      this.lastDragTime = Date.now();
      this.dragVelocity = 0;
      const reel = this.$refs.projReelRef;
      this.dragScrollStart = reel ? reel.scrollLeft : 0;
      if (reel) {
        reel.style.scrollSnapType = 'none';
        reel.style.scrollBehavior = 'auto';
        reel.classList.add("is-dragging");
      }
    },
    onDragProj(e){
      if (!this.isDraggingProj) return;
      const reel = this.$refs.projReelRef;
      if (!reel) return;
      const deltaX = e.pageX - this.dragStartX;
      if (Math.abs(deltaX) > 4) {
        this.hasDragged = true;
      }
      const now = Date.now();
      const dt = now - this.lastDragTime;
      if (dt > 10) {
        this.dragVelocity = (e.pageX - this.lastDragX) / dt;
        this.lastDragX = e.pageX;
        this.lastDragTime = now;
      }
      reel.scrollLeft = this.dragScrollStart - deltaX;
    },
    stopDragProj(){
      if (!this.isDraggingProj) return;
      this.isDraggingProj = false;
      const reel = this.$refs.projReelRef;
      if (reel) {
        reel.classList.remove("is-dragging");
        reel.style.scrollBehavior = 'smooth';
      }
      if (this.hasDragged) {
        if (this.dragVelocity < -0.22 && this.activeProjIdx < (this.projects.length - 1)) {
          this.scrollToProj(this.activeProjIdx + 1);
        } else if (this.dragVelocity > 0.22 && this.activeProjIdx > 0) {
          this.scrollToProj(this.activeProjIdx - 1);
        } else {
          this.snapToClosestCard();
        }
      } else {
        if (reel) reel.style.scrollSnapType = 'x mandatory';
      }
    },
    snapToClosestCard(){
      const reel = this.$refs.projReelRef;
      if (!reel) return;
      const cards = reel.querySelectorAll(".proj-wide-card");
      const reelCenter = reel.scrollLeft + reel.clientWidth / 2;
      let closestIdx = 0;
      let minDistance = Infinity;
      cards.forEach((card, idx) => {
        const cardCenter = card.offsetLeft + card.offsetWidth / 2;
        const dist = Math.abs(cardCenter - reelCenter);
        if (dist < minDistance) {
          minDistance = dist;
          closestIdx = idx;
        }
      });
      this.scrollToProj(closestIdx);
    },
    onReelWheel(e){
      const reel = this.$refs.projReelRef;
      if (!reel) return;
      if (Math.abs(e.deltaX) > Math.abs(e.deltaY)) return;
      if (Math.abs(e.deltaY) > 20) {
        clearTimeout(this._wheelTimer);
        this._wheelTimer = setTimeout(() => {
          if (e.deltaY > 0) {
            this.nextProj();
          } else {
            this.prevProj();
          }
        }, 35);
      }
    },
    onProgressTrackClick(e){
      const track = e.currentTarget;
      if (!track) return;
      const rect = track.getBoundingClientRect();
      const clickX = e.clientX - rect.left;
      const pct = clickX / rect.width;
      const total = this.projects ? this.projects.length : 3;
      const targetIdx = Math.min(total - 1, Math.max(0, Math.floor(pct * total)));
      this.scrollToProj(targetIdx);
    },
    setActiveModuleTab(projId, tabId){
      if (!this.activeModuleTab) this.activeModuleTab = {};
      this.activeModuleTab[projId] = tabId;
    },
    openProjectDetails(p){
      this.selectedDetailProj = p;
    },
    jumpToModule(projectId, tabId){
      const idx = this.projects.findIndex(p => p.id === projectId);
      if (idx !== -1) {
        this.scrollToProj(idx);
        this.setActiveModuleTab(projectId, tabId);
        const el = document.getElementById("project");
        if (el) {
          const offset = el.getBoundingClientRect().top + window.pageYOffset - 64;
          window.scrollTo({ top: Math.max(0, offset), behavior: "smooth" });
        }
      }
    },
    tick(){
      const now=new Date();
      const loc = this.lang==="id" ? "id-ID" : "en-GB";
      const rawTime = new Intl.DateTimeFormat(loc,{hour:"2-digit",minute:"2-digit",hour12:false,timeZone:"Asia/Makassar"}).format(now);
      this.clock.time = rawTime.replace(".", ":");
      this.clock.date = new Intl.DateTimeFormat(loc,{weekday:"short",day:"2-digit",month:"short",year:"numeric",timeZone:"Asia/Makassar"}).format(now);
    },
    goToSection(id){
      if (id === "contact") {
        this.openContactModal();
        return;
      }
      const el = document.getElementById(id);
      if (!el) return;
      this.activeSection = id;
      const headerOffset = 64;
      const elementPosition = el.getBoundingClientRect().top;
      const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
      window.scrollTo({
        top: Math.max(0, offsetPosition),
        behavior: "smooth"
      });

      // Re-trigger animation: reset and replay reveal effects
      const reveals = el.querySelectorAll(".reveal");
      if (reveals.length > 0) {
        reveals.forEach(r => {
          r.classList.remove("in");
          r.style.transition = "none";
        });
        void el.offsetWidth;
        setTimeout(() => {
          reveals.forEach((r, idx) => {
            r.style.transition = "";
            setTimeout(() => {
              r.classList.add("in");
            }, idx * 70);
          });
        }, 180);
      }
    },
    setupScrollSpy(){
      const sectionIds = ["hero", "exp", "skills", "certifications", "project", "contact"];
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            this.activeSection = entry.target.id;
          }
        });
      }, {
        rootMargin: "-20% 0px -55% 0px",
        threshold: 0
      });
      sectionIds.forEach(id => {
        const el = document.getElementById(id);
        if (el) observer.observe(el);
      });
    },
  },
  watch:{
    lang(v){
      this.tick();
      document.documentElement.setAttribute("lang", v);
      this.$nextTick(() => {
        setupReveal();
        this.setupScrollSpy();
      });
    },
    theme(v){ document.documentElement.setAttribute("data-theme", v); },
    certFilter(){
      this.showAllCerts = false;
      this.$nextTick(() => {
        setupReveal();
      });
    },
  },
  mounted(){
    this.tick();
    setInterval(this.tick,1000);
    document.documentElement.setAttribute("lang", this.lang);
    document.documentElement.setAttribute("data-theme", this.theme);
    this.updateProjProgress();
    window.addEventListener("keydown", (e) => {
      if (e.key === "Escape") {
        if (this.selectedDetailProj) {
          this.selectedDetailProj = null;
        } else if (this.previewCert) {
          this.closeCertPreview();
        } else if (this.contactModalOpen) {
          this.closeContactModal();
        }
      }
    });
    this.$nextTick(() => {
      setupReveal();
      this.setupScrollSpy();
    });
  },
}).mount("#app");
</script>
</body>
</html>
@endverbatim
