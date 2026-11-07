---
paths:
  - 'resources/views/project/dalapareg/**'
---

# Dalapareg

## Dalapareg demo: light-only, Indonesian-only miniature of the legacy app
Miniature of the legacy DALAPA app (reference: c:\laragon\www\DalapaRegionalNewApp, read-only). Each page is a standalone HTML doc — no shared layout.

- **No dark mode and no language switcher, deliberately** — the real app has neither. Do not add a `data-theme` toggle, a `#langSwitch`, or any `dalapa-theme` / `dalapa-lang` localStorage use here (the tifreg demo has those; this one must not). Light mode + Indonesian only.
- `feature/partials/shell-styles.blade.php` intentionally `@include`s the tifreg shell CSS and only repaints it. Do not fork that CSS — add overrides there, and never add `[data-theme="dark"]` rules.
- Colours are sampled from the real `assets/css/themes/type-e/theme-navy.min.css`, not invented: page `#ecf0f5`, panels `#fff`, headings `#4d627b`, body text `#7a878e`, primary `#25476a`, Nifty `.btn-primary` `#1c3550`, `.btn-mint` `#1f897f`, plus the DLP mark red `#d0242f`. The real navbar splits in two: `.navbar-header` (logo) sits on the plain page background, `.navbar-content` (menu/search/user links) is solid navy `#25476a` with light-grey `#dbdbdb` text — there is no red rule anywhere on it (that was a past mistake in this file, corrected 2026-09-22). Our fixed sidebar plays the `.navbar-header` role, so `.topbar` must be the navy `.navbar-content` half: `background:var(--brand-600)`, icons/text in `#dbdbdb`/`#fff`, no border-bottom.
- Any `panel-primary` in the real source (a detail/drill-down modal's tab strip, e.g. `<div class="panel panel-primary"><div class="panel-heading">`) is also solid navy `#25476a` with white tab text — our shared `.tabs` strip must stay navy for the same reason, not grey.
- Login mirrors `resources/views/auth.blade.php`: white page with the real hexagon artwork (`public/images/dalapa/login-bg.png`, copied from the app's `assets/img/dalapa_nasional.png`) at .8 opacity, centred white card, big red DLP logo, navy Login button, teal Register button. Demo credentials `1111 / 1111`.
- `feature/partials/shell-script.blade.php` is standalone. `PAGE_I18N` / `SHELL_I18N` are now flat Indonesian string tables (no `id` / `en` nesting); `t()` + `applyLang()` stay as the single copy deck so JS-generated strings and `data-i18n` markup share one source. Call `applyLang()` after JS-rendered tables exist. Never put `data-i18n` on an element containing child markup — wrap the text in a `<span>`.
- It also provides the WITA clock, sidebar toggles, `rupiah()`, `kvHtml()`, `toast()`, and a `.tabs` + `[data-tab]` strip handler.
- Demo numbers come from a deterministic `seeded()` hash, never `Math.random()`, so matrices, totals and drill-down details stay consistent across re-renders.
