# Rollback script to restore original UI files
$backupDir = "$PSScriptRoot"
$viewsDir = "$PSScriptRoot\.."

Copy-Item "$backupDir\welcome.blade.php.original" "$viewsDir\welcome.blade.php" -Force
Copy-Item "$backupDir\profile.blade.php.original" "$viewsDir\self\profile.blade.php" -Force
Copy-Item "$backupDir\nav-sidebar.blade.php.original" "$viewsDir\common\nav-sidebar.blade.php" -Force

Write-Host "Rollback complete! All original files have been restored." -ForegroundColor Green
