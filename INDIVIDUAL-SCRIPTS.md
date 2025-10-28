# 🎵 MUSAIX.COM INDIVIDUAL SCRIPTS FOR MANUAL DEPLOYMENT

## If you prefer to create scripts manually on your server, copy each script below:

---

## 1. HEALTH CHECK SCRIPT
**File**: `~/scripts/health-check-musaix.sh`

```bash
#!/bin/bash

# 🎵 MUSAIX.COM LIVE SITE MANAGEMENT SCRIPT
# Run this on your HostGator server: ssh acaptade@192.254.189.236

echo "🎵 MUSAIX.COM - LIVE SITE HEALTH CHECK"
echo "====================================="
echo ""

# Check current directory and switch to WordPress root
cd ~/public_html || { echo "❌ Cannot access public_html"; exit 1; }
echo "📁 Current location: $(pwd)"
echo ""

echo "🔍 WORDPRESS CORE STATUS"
echo "========================"
echo ""

# Check WordPress version
if [ -f wp-config.php ]; then
    echo "✅ WordPress installation found"
    
    # Extract version from wp-includes/version.php if available
    if [ -f wp-includes/version.php ]; then
        WP_VERSION=$(grep "wp_version = " wp-includes/version.php | cut -d "'" -f 2)
        echo "📦 WordPress Version: $WP_VERSION"
    fi
    
    # Check if wp-config.php is readable
    if [ -r wp-config.php ]; then
        echo "✅ wp-config.php accessible"
        
        # Extract database info (safely)
        DB_NAME=$(grep "DB_NAME" wp-config.php | cut -d "'" -f 4)
        DB_USER=$(grep "DB_USER" wp-config.php | cut -d "'" -f 4)
        DB_HOST=$(grep "DB_HOST" wp-config.php | cut -d "'" -f 4)
        
        echo "🗄️ Database: $DB_NAME"
        echo "👤 DB User: $DB_USER" 
        echo "🖥️ DB Host: $DB_HOST"
    fi
else
    echo "❌ WordPress not found in current directory"
    exit 1
fi

echo ""
echo "🔌 PLUGIN STATUS CHECK"
echo "======================"
echo ""

# List active plugins by checking database or files
if [ -d wp-content/plugins ]; then
    echo "📦 Installed Plugins:"
    ls -la wp-content/plugins/ | grep "^d" | awk '{print "  " $9}' | grep -v "^\.$\|^\.\.$"
else
    echo "❌ Plugins directory not found"
fi

echo ""
echo "🚀 Your Musaix Pro platform is ready for action!"
```

---

## 2. OPTIMIZATION SCRIPT  
**File**: `~/scripts/optimize-musaix.sh`

```bash
#!/bin/bash

# 🚀 MUSAIX.COM PERFORMANCE OPTIMIZATION SCRIPT

echo "⚡ MUSAIX.COM - PERFORMANCE OPTIMIZATION"
echo "======================================="

# Switch to WordPress directory
cd ~/public_html || { echo "❌ Cannot access public_html"; exit 1; }

echo "🔒 Setting correct file permissions..."
find . -type d -exec chmod 755 {} \;
find . -type f -exec chmod 644 {} \;
chmod 600 wp-config.php 2>/dev/null

echo "🚀 Creating optimized .htaccess..."
cp .htaccess .htaccess.backup.$(date +%Y%m%d_%H%M%S) 2>/dev/null

cat > .htaccess << 'EOF'
# BEGIN WordPress
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase /
RewriteRule ^index\.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /index.php [L]
</IfModule>
# END WordPress

# Force HTTPS
<IfModule mod_rewrite.c>
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://musaix.com%{REQUEST_URI} [L,R=301]
</IfModule>

# Enable compression
<IfModule mod_deflate.c>
AddOutputFilterByType DEFLATE text/plain text/html text/css application/javascript
</IfModule>
EOF

echo "✅ Optimization complete! Your site is now faster and more secure."
```

---

## 3. BACKUP SCRIPT
**File**: `~/scripts/backup-musaix.sh`

```bash
#!/bin/bash

# 🛡️ MUSAIX.COM AUTOMATED BACKUP SCRIPT

echo "💾 MUSAIX.COM - AUTOMATED BACKUP SYSTEM"
echo "======================================="

BACKUP_DIR="$HOME/musaix_backups"
SITE_DIR="$HOME/public_html"
DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_NAME="musaix_backup_$DATE"

# Create backup directory
mkdir -p "$BACKUP_DIR/$BACKUP_NAME"/{files,database}

cd "$SITE_DIR" || exit 1

# Get database credentials
DB_NAME=$(grep "DB_NAME" wp-config.php | cut -d "'" -f 4)
DB_USER=$(grep "DB_USER" wp-config.php | cut -d "'" -f 4)
DB_PASS=$(grep "DB_PASSWORD" wp-config.php | cut -d "'" -f 4)

echo "🗄️ Backing up database..."
mysqldump -u "$DB_USER" -p"$DB_PASS" "$DB_NAME" > "$BACKUP_DIR/$BACKUP_NAME/database/musaix_database.sql"

echo "📁 Backing up files..."
tar -czf "$BACKUP_DIR/$BACKUP_NAME/files/musaix_files.tar.gz" --exclude="*.log" .

echo "✅ Backup complete: $BACKUP_DIR/$BACKUP_NAME"
```

---

## 4. AI FEATURES TEST SCRIPT
**File**: `~/scripts/test-ai-features.sh`

```bash
#!/bin/bash

# 🔍 MUSAIX.COM AI FEATURES TEST SCRIPT

echo "🤖 MUSAIX.COM - AI FEATURES TESTING"
echo "==================================="

cd ~/public_html || exit 1

echo "🔍 Checking AI plugin status..."
if [ -d "wp-content/plugins/ai-power-complete-ai-pack" ] || [ -d "wp-content/plugins/gpt3-ai-content-generator" ]; then
    echo "✅ AIP AI Toolkit plugin found"
else
    echo "⚠️ AI plugin directory not found"
fi

echo "🎨 Checking Elementor..."
if [ -d "wp-content/plugins/elementor" ]; then
    echo "✅ Elementor plugin found"
    if [ -d "wp-content/plugins/elementor-pro" ]; then
        echo "✅ Elementor Pro plugin found"
    fi
else
    echo "❌ Elementor plugin not found"
fi

echo ""
echo "🎵 AI Features Test Complete!"
echo "Login to https://musaix.com/wp-admin with S73RL/Bl@ckbirdSr71"
echo "Test each AI feature manually through the WordPress admin."
```

---

## 🚀 DEPLOYMENT INSTRUCTIONS

### Quick Deploy via SSH:
```bash
ssh acaptade@192.254.189.236
mkdir -p ~/scripts
# Copy each script above into respective files
chmod +x ~/scripts/*.sh
cd ~/public_html && ~/scripts/health-check-musaix.sh
```

### Your Musaix Pro platform is ready for optimization! 🎵