# Skrip Rollback untuk memulihkan file sebelum implementasi Horizontal Showcase
$ErrorActionPreference = "Stop"
$backupDir = $PSScriptRoot
$viewsDir = Resolve-Path "$PSScriptRoot\.."

Write-Host "Memulai proses rollback..." -ForegroundColor Cyan

# 1. Restore welcome.blade.php
if (Test-Path "$backupDir\welcome.blade.php.original") {
    Copy-Item "$backupDir\welcome.blade.php.original" "$viewsDir\welcome.blade.php" -Force
    Write-Host " [OK] welcome.blade.php berhasil dipulihkan." -ForegroundColor Green
} else {
    Write-Warning "File welcome.blade.php.original tidak ditemukan!"
}

# 2. Restore cards.blade.php
if (Test-Path "$backupDir\cards.blade.php.original") {
    Copy-Item "$backupDir\cards.blade.php.original" "$viewsDir\project\cards.blade.php" -Force
    Write-Host " [OK] project/cards.blade.php berhasil dipulihkan." -ForegroundColor Green
} else {
    Write-Warning "File cards.blade.php.original tidak ditemukan!"
}

Write-Host "`nRollback selesai dengan sukses! Halaman portofolio telah kembali ke versi sebelumnya." -ForegroundColor Green
