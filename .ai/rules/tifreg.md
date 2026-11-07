---
paths:
  - 'resources/views/project/tifreg/**'
---

# Tifreg

## DALAPA miniature pages: ship ID + EN i18n from the start
Every new miniature page under project/tifreg/ must ship bilingual (Indonesian default + English), not ID-only.

Pattern (each page is a standalone HTML doc, no shared layout):
- Mark static text with `data-i18n="key"`, placeholders with `data-i18n-ph`, tooltips with `data-i18n-title`. Never put data-i18n on an element that also contains an SVG/child markup — wrap the text node in a `<span>` first, because applyLang() overwrites textContent.
- Declare `var I18N = { id: {...}, en: {...} }` + `t(k)` + `applyLang()` at the top of the page script; call `applyLang()` after any JS-rendered tables exist so their generated cells re-translate.
- Persist the choice in localStorage key `dalapa-lang` and read it back on load, same as the theme key `dalapa-theme` (restored by a small script in `<head>` before body renders to avoid a flash).
- Any string produced in JS (toasts, confirm dialogs, table cells, select placeholders) must go through `t()`, not be hardcoded.

Source of truth for wording is the real app's `resources/lang/Vue/{id,en}/*.json` in c:\laragon\www\new-dalapa-tif-reg (read-only reference).
