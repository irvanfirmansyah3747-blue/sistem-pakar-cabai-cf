#!/bin/sh
set -e

echo "==> Menyiapkan environment Laravel..."

# Cache config & route jika key sudah ada
if [ -n "$APP_KEY" ]; then
    php artisan config:clear || true
    php artisan storage:link || true
    
    # Otomatis jalankan migrasi database saat start
    if [ "$RUN_MIGRATIONS" = "true" ]; then
        echo "==> Menjalankan migrasi database..."
        php artisan migrate --force --seed || true
    fi
fi

echo "==> Menjalankan Nginx & PHP-FPM melalui Supervisord..."
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
