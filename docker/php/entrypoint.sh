#!/usr/bin/env bash
set -e

cd /var/www/html

# 1. Create .env from .env.example if missing
if [ ! -f ".env" ] && [ -f ".env.example" ]; then
    echo "[entrypoint] Creating .env from .env.example..."
    cp .env.example .env
fi

# 2. Ensure project root, storage & cache directories have right permissions
chmod 755 /var/www/html || true
mkdir -p storage/framework/{sessions,views,cache/data} storage/logs storage/app/public/projects bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache || true
chmod -R ug+rwx storage bootstrap/cache || true

# 3. Install Composer dependencies if vendor/ is missing
if [ ! -f "vendor/autoload.php" ]; then
    echo "[entrypoint] Installing Composer dependencies..."
    composer install --no-interaction --prefer-dist --optimize-autoloader
fi

# 4. Generate APP_KEY if not set
if grep -q "^APP_KEY=$" .env 2>/dev/null; then
    echo "[entrypoint] Generating Laravel APP_KEY..."
    php artisan key:generate --force
fi

# 5. Wait for MySQL when DB_CONNECTION=mysql
DB_CONN=$(php -r "echo getenv('DB_CONNECTION') ?: 'mysql';")
if [ "$DB_CONN" = "mysql" ]; then
    echo "[entrypoint] Waiting for MySQL database to be ready..."
    MAX_TRIES=30
    COUNT=0
    until php -r "
        \$host = getenv('DB_HOST') ?: 'mysql';
        \$port = getenv('DB_PORT') ?: '3306';
        \$db   = getenv('DB_DATABASE') ?: 'portfolio';
        \$user = getenv('DB_USERNAME') ?: 'portfolio';
        \$pass = getenv('DB_PASSWORD') ?: 'secret';
        try {
            new PDO(\"mysql:host={\$host};port={\$port};dbname={\$db}\", \$user, \$pass);
            exit(0);
        } catch (Throwable \$e) {
            exit(1);
        }
    " 2>/dev/null; do
        COUNT=$((COUNT + 1))
        if [ $COUNT -ge $MAX_TRIES ]; then
            echo "[entrypoint] Warning: MySQL not reachable after ${MAX_TRIES} attempts, continuing..."
            break
        fi
        sleep 2
    done

    echo "[entrypoint] Running database migrations..."
    php artisan migrate --force || true

    # Seed initial showcase projects if table is empty
    PROJECT_COUNT=$(php artisan tinker --execute="echo \App\Models\Project::count();" 2>/dev/null | tr -d '[:space:]' || echo "0")
    if [ "$PROJECT_COUNT" = "0" ]; then
        echo "[entrypoint] Seeding initial portfolio projects..."
        php artisan db:seed --force || true
    fi
fi

# 6. Link public storage for uploaded project images
if [ ! -L "public/storage" ]; then
    php artisan storage:link || true
fi

echo "[entrypoint] Portfolio container ready!"
exec "$@"

