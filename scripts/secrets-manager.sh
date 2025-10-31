#!/bin/bash

# 🔐 MUSAIX PRO SECRETS MANAGEMENT SYSTEM
# Secure credential management for development and production

set -euo pipefail

SECRETS_DIR="$HOME/.config/musaix-secrets"
VAULT_FILE="$SECRETS_DIR/vault.gpg"
ENV_FILE=".env"

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Functions
log_info() {
    echo -e "${BLUE}ℹ️  $1${NC}"
}

log_success() {
    echo -e "${GREEN}✅ $1${NC}"
}

log_warning() {
    echo -e "${YELLOW}⚠️  $1${NC}"
}

log_error() {
    echo -e "${RED}❌ $1${NC}"
}

# Initialize secrets directory
init_secrets() {
    if [ ! -d "$SECRETS_DIR" ]; then
        mkdir -p "$SECRETS_DIR"
        chmod 700 "$SECRETS_DIR"
        log_success "Created secrets directory: $SECRETS_DIR"
    fi
}

# Generate strong password
generate_password() {
    local length=${1:-32}
    openssl rand -base64 $length | tr -d "=+/" | cut -c1-$length
}

# Create secure .env file
create_secure_env() {
    log_info "Creating secure .env file..."
    
    # Generate secure passwords
    DB_PASSWORD=$(generate_password 32)
    DB_ROOT_PASSWORD=$(generate_password 32)
    ADMIN_PASSWORD=$(generate_password 24)
    
    cat > "$ENV_FILE" << EOF
# Musaix Pro Environment Configuration
# Generated: $(date)
# SECURITY: This file contains sensitive data - never commit to version control

# Database Configuration
DB_NAME=musaixpro_wp
DB_USER=wordpress
DB_PASSWORD=$DB_PASSWORD
DB_ROOT_PASSWORD=$DB_ROOT_PASSWORD

# WordPress Configuration
WP_ENV=development
WP_HOME=http://localhost:8080
WP_SITEURL=http://localhost:8080

# Site Configuration
SITE_TITLE=Musaix Pro
ADMIN_USER=admin
ADMIN_PASSWORD=$ADMIN_PASSWORD
ADMIN_EMAIL=admin@musaix.com

# Security Configuration
WP_DEBUG=false
WP_DEBUG_LOG=false
WP_DEBUG_DISPLAY=false
SCRIPT_DEBUG=false

# Production overrides (uncomment for production)
# WP_ENV=production
# WP_HOME=https://musaix.com
# WP_SITEURL=https://musaix.com
# FORCE_SSL_ADMIN=true
EOF

    chmod 600 "$ENV_FILE"
    log_success "Secure .env file created with generated passwords"
}

# Backup current credentials
backup_credentials() {
    if [ -f "$ENV_FILE" ]; then
        local backup_file="$SECRETS_DIR/env.backup.$(date +%Y%m%d_%H%M%S)"
        cp "$ENV_FILE" "$backup_file"
        chmod 600 "$backup_file"
        log_success "Backed up existing .env to: $backup_file"
    fi
}

# Encrypt secrets vault
encrypt_vault() {
    if command -v gpg &> /dev/null; then
        log_info "Encrypting secrets vault..."
        echo "# Musaix Pro Secrets Vault - $(date)" > "$SECRETS_DIR/vault.txt"
        echo "# Database Password: $DB_PASSWORD" >> "$SECRETS_DIR/vault.txt"
        echo "# Root Password: $DB_ROOT_PASSWORD" >> "$SECRETS_DIR/vault.txt"
        echo "# Admin Password: $ADMIN_PASSWORD" >> "$SECRETS_DIR/vault.txt"
        
        gpg --symmetric --cipher-algo AES256 --output "$VAULT_FILE" "$SECRETS_DIR/vault.txt"
        rm "$SECRETS_DIR/vault.txt"
        log_success "Secrets encrypted and stored in vault"
    else
        log_warning "GPG not available - secrets not encrypted"
    fi
}

# Main function
main() {
    echo "🔐 MUSAIX PRO SECRETS MANAGEMENT"
    echo "================================"
    echo ""
    
    case "${1:-setup}" in
        "setup")
            init_secrets
            backup_credentials
            create_secure_env
            encrypt_vault
            log_success "Secrets management setup complete!"
            echo ""
            log_info "Generated passwords stored in .env file"
            log_warning "Keep your .env file secure and never commit it to version control"
            ;;
        "rotate")
            log_info "Rotating passwords..."
            backup_credentials
            create_secure_env
            encrypt_vault
            log_success "Passwords rotated successfully!"
            ;;
        "backup")
            backup_credentials
            log_success "Credentials backed up"
            ;;
        *)
            echo "Usage: $0 [setup|rotate|backup]"
            echo "  setup  - Initialize secrets management (default)"
            echo "  rotate - Generate new passwords"
            echo "  backup - Backup current credentials"
            ;;
    esac
}

# Run main function
main "$@"