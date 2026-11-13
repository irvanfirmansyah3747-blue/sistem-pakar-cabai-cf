$ErrorActionPreference = "Stop"
$ProjectDir = "D:\TUGAS KULIAH\SEMESTER 5\BASIS DATA LANJUT\UTS"
Set-Location $ProjectDir

Write-Host ""
Write-Host "=====================================================" -ForegroundColor Green
Write-Host "  SISTEM PAKAR CABAI - RUMAH SEMAI HELLY SEEDLING   " -ForegroundColor Green
Write-Host "=====================================================" -ForegroundColor Green
Write-Host ""

# 1. Cek apakah MySQL (port 3306) sudah berjalan
$mysqlListening = Get-NetTCPConnection -LocalPort 3306 -State Listen -ErrorAction SilentlyContinue
if (-not $mysqlListening) {
    Write-Host "[1/3] Menjalankan MySQL Server (XAMPP)..." -ForegroundColor Yellow
    Start-Process -FilePath "C:\xampp\mysql\bin\mysqld.exe" -ArgumentList "--defaults-file=C:\xampp\mysql\bin\my.ini", "--standalone" -WindowStyle Hidden

    $timeout = 10
    while ($timeout -gt 0) {
        Start-Sleep -Seconds 1
        $mysqlListening = Get-NetTCPConnection -LocalPort 3306 -State Listen -ErrorAction SilentlyContinue
        if ($mysqlListening) { break }
        $timeout--
    }

    if ($mysqlListening) {
        Write-Host "      MySQL aktif di port 3306." -ForegroundColor Green
    } else {
        Write-Host "      Gagal memulai MySQL secara otomatis. Pastikan XAMPP MySQL tidak terkunci." -ForegroundColor Red
        exit 1
    }
} else {
    Write-Host "[1/3] MySQL sudah berjalan di port 3306." -ForegroundColor Cyan
}

# 2. Cek apakah Laravel Server (port 8000) sudah berjalan
$laravelListening = Get-NetTCPConnection -LocalPort 8000 -State Listen -ErrorAction SilentlyContinue
if ($laravelListening) {
    Write-Host "[2/3] Server Laravel sudah aktif di http://127.0.0.1:8000" -ForegroundColor Cyan
    Write-Host "[3/3] Membuka aplikasi di browser..." -ForegroundColor Green
    Start-Process "http://127.0.0.1:8000"
} else {
    Write-Host "[2/3] Membuka browser ke http://127.0.0.1:8000..." -ForegroundColor Green
    Start-Process "http://127.0.0.1:8000"
    Write-Host "[3/3] Menjalankan Laravel Server (Tekan Ctrl+C untuk berhenti)..." -ForegroundColor Yellow
    Write-Host ""
    php artisan serve --port=8000
}

