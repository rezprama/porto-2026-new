# Panduan Rollback: Horizontal Showcase UX

Folder ini berisi cadangan berkas tampilan sebelum perombakan Horizontal Showcase & Real-Estate UX:
1. `welcome.blade.php.original` -> Cadangan `resources/views/welcome.blade.php`
2. `cards.blade.php.original` -> Cadangan `resources/views/project/cards.blade.php`

## Cara Menjalankan Rollback

### Cara 1: Menggunakan Script Otomatis (PowerShell)
Buka terminal PowerShell di folder proyek ini dan jalankan:
```powershell
powershell -ExecutionPolicy Bypass -File resources\views\backup_horizontal_showcase\restore.ps1
```

### Cara 2: Manual Copy-Paste
1. Salin `resources\views\backup_horizontal_showcase\welcome.blade.php.original` dan timpa ke `resources\views\welcome.blade.php`.
2. Salin `resources\views\backup_horizontal_showcase\cards.blade.php.original` dan timpa ke `resources\views\project\cards.blade.php`.
