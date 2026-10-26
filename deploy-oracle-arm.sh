#!/usr/bin/env bash
# ==============================================================================
# Oracle Cloud ARM64 (Ampere A1) One-Command Deployment Script
# Usage:
#   chmod +x deploy-oracle-arm.sh
#   ./deploy-oracle-arm.sh                  # Deploy via HTTP on port 80 (IP only)
#   ./deploy-oracle-arm.sh yourdomain.com   # Deploy with automatic HTTPS via Caddy
# ==============================================================================
set -e

DOMAIN_ARG="${1:-}"

# Ignore literal example domains if user copied the README command before buying a domain
if [ "$DOMAIN_ARG" = "seudominio.com.br" ] || [ "$DOMAIN_ARG" = "seudominio.com" ] || [ "$DOMAIN_ARG" = "yourdomain.com" ]; then
    echo "[!] Notice: '${DOMAIN_ARG}' is an example domain. Deploying via HTTP on your VM IP (port 80) for now!"
    echo "    When you buy your real domain and point its DNS to this VM, run: ./deploy-oracle-arm.sh <your-real-domain>"
    DOMAIN_ARG=""
fi

echo "========================================================"
echo "  NEOBRUTALIST PORTFOLIO — ORACLE CLOUD ARM DEPLOYER"
echo "========================================================"

# 1. Install Docker & Docker Compose if missing
if ! command -v docker >/dev/null 2>&1; then
    echo "[1/5] Installing Docker Engine (ARM64 compatible)..."
    curl -fsSL https://get.docker.com | sudo sh
    sudo usermod -aG docker "$USER" || true
else
    echo "[1/5] Docker is already installed."
fi

# 2. Open ports 80 & 443 on Oracle Cloud Ubuntu iptables
echo "[2/5] Opening HTTP (80) & HTTPS (443) ports in OS firewall..."
if sudo iptables -L INPUT -n | grep -q "REJECT"; then
    sudo iptables -C INPUT -p tcp --dport 80 -m state --state NEW -j ACCEPT 2>/dev/null || \
        sudo iptables -I INPUT 5 -p tcp --dport 80 -m state --state NEW -j ACCEPT || true
    sudo iptables -C INPUT -p tcp --dport 443 -m state --state NEW -j ACCEPT 2>/dev/null || \
        sudo iptables -I INPUT 5 -p tcp --dport 443 -m state --state NEW -j ACCEPT || true
    sudo iptables -C INPUT -p udp --dport 443 -j ACCEPT 2>/dev/null || \
        sudo iptables -I INPUT 5 -p udp --dport 443 -j ACCEPT || true
    if command -v netfilter-persistent >/dev/null 2>&1; then
        sudo netfilter-persistent save || true
    fi
fi

# 3. Prepare .env file
if [ ! -f ".env" ]; then
    if [ -f ".env.example" ]; then
        echo "[3/5] Creating .env from .env.example..."
        cp .env.example .env
    else
        echo "[3/5] Creating default .env..."
        cat << 'EOF' > .env
APP_NAME="Humberto // Portfolio"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=http://localhost
APP_PORT=80
DOMAIN=localhost
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=portfolio
DB_USERNAME=portfolio
DB_PASSWORD=secret
DB_ROOT_PASSWORD=rootsecret
SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync
FILESYSTEM_DISK=public
ADMIN_USERNAME=admin
ADMIN_PASSWORD=changeme123
EOF
    fi
else
    echo "[3/5] Using existing .env file."
fi

# Ensure LF line endings on scripts and .env, and readable directory permissions for Nginx
chmod 755 . || true
sed -i 's/\r$//' .env 2>/dev/null || true
sed -i 's/\r$//' docker/php/entrypoint.sh 2>/dev/null || true

# 4. Configure domain if passed as argument
if [ -n "$DOMAIN_ARG" ]; then
    echo "[4/5] Configuring domain: https://${DOMAIN_ARG}"
    sed -i "s|^DOMAIN=.*|DOMAIN=${DOMAIN_ARG}|g" .env
    sed -i "s|^APP_URL=.*|APP_URL=https://${DOMAIN_ARG}|g" .env
    sed -i "s|^APP_ENV=.*|APP_ENV=production|g" .env
    sed -i "s|^APP_DEBUG=.*|APP_DEBUG=false|g" .env

    echo "[5/5] Building & starting containers with automatic HTTPS (Caddy)..."
    sudo docker compose -f docker-compose.yml -f docker-compose.prod.yml up -d --build
else
    PUBLIC_IP=$(curl -s --max-time 4 https://ifconfig.me || echo "localhost")
    echo "[4/5] Deploying on HTTP port 80 (http://${PUBLIC_IP})..."
    sed -i "s|^APP_PORT=.*|APP_PORT=80|g" .env
    sed -i "s|^APP_URL=.*|APP_URL=http://${PUBLIC_IP}|g" .env

    echo "[5/5] Building & starting containers..."
    sudo docker compose up -d --build
fi

echo ""
echo "========================================================"
echo "  DEPLOYMENT COMPLETE!"
if [ -n "$DOMAIN_ARG" ]; then
    echo "  URL:   https://${DOMAIN_ARG}"
    echo "  Admin: https://${DOMAIN_ARG}/admin"
else
    echo "  URL:   http://${PUBLIC_IP:-64.181.164.2}"
    echo "  Admin: http://${PUBLIC_IP:-64.181.164.2}/admin"
fi
echo "========================================================"
