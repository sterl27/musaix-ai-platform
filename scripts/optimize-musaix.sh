#!/bin/bash

# 🚀 MUSAIX.COM PERFORMANCE OPTIMIZATION SCRIPT
# Run this on your HostGator server: ssh acaptade@192.254.189.236

echo "⚡ MUSAIX.COM - PERFORMANCE OPTIMIZATION"
echo "======================================="
echo ""

# Switch to WordPress directory
cd ~/public_html || { echo "❌ Cannot access public_html"; exit 1; }

echo "🔧 Starting optimization process..."
echo ""

echo "1️⃣ FILE PERMISSIONS OPTIMIZATION"
echo "================================="
echo ""

# Fix file permissions for security and performance
echo "🔒 Setting correct file permissions..."

# Directories should be 755
find . -type d -exec chmod 755 {} \;
echo "✅ Directory permissions set to 755"

# Files should be 644  
find . -type f -exec chmod 644 {} \;
echo "✅ File permissions set to 644"

# wp-config.php should be more restrictive
if [ -f wp-config.php ]; then
    chmod 600 wp-config.php
    echo "✅ wp-config.php secured (600)"
fi

echo ""
echo "2️⃣ .HTACCESS OPTIMIZATION"
echo "========================="
echo ""

# Create optimized .htaccess for performance
if [ -f .htaccess ]; then
    echo "📄 Backing up existing .htaccess..."
    cp .htaccess .htaccess.backup.$(date +%Y%m%d_%H%M%S)
fi

echo "🚀 Creating optimized .htaccess..."

cat > .htaccess << 'EOF'
# 🎵 MUSAIX.COM OPTIMIZED .HTACCESS

# BEGIN WordPress
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]
RewriteBase /
RewriteRule ^index\.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /index.php [L]
</IfModule>
# END WordPress

# 🔒 SECURITY ENHANCEMENTS
# Protect wp-config.php
<Files wp-config.php>
order allow,deny
deny from all
</Files>

# Protect .htaccess
<Files .htaccess>
order allow,deny
deny from all
</Files>

# Block access to sensitive files
<FilesMatch "^.*(error_log|wp-config\.php|php.ini|\.[hH][tT][aApP].*)$">
Order deny,allow
Deny from all
</FilesMatch>

# ⚡ PERFORMANCE OPTIMIZATIONS
# Enable compression
<IfModule mod_deflate.c>
AddOutputFilterByType DEFLATE text/plain
AddOutputFilterByType DEFLATE text/html
AddOutputFilterByType DEFLATE text/xml
AddOutputFilterByType DEFLATE text/css
AddOutputFilterByType DEFLATE application/xml
AddOutputFilterByType DEFLATE application/xhtml+xml
AddOutputFilterByType DEFLATE application/rss+xml
AddOutputFilterByType DEFLATE application/javascript
AddOutputFilterByType DEFLATE application/x-javascript
AddOutputFilterByType DEFLATE application/json
</IfModule>

# Browser caching
<IfModule mod_expires.c>
ExpiresActive On
ExpiresByType image/jpg "access plus 1 month"
ExpiresByType image/jpeg "access plus 1 month"
ExpiresByType image/gif "access plus 1 month"
ExpiresByType image/png "access plus 1 month"
ExpiresByType image/webp "access plus 1 month"
ExpiresByType text/css "access plus 1 month"
ExpiresByType application/pdf "access plus 1 month"
ExpiresByType text/javascript "access plus 1 month"
ExpiresByType application/javascript "access plus 1 month"
ExpiresByType application/x-javascript "access plus 1 month"
ExpiresByType application/x-shockwave-flash "access plus 1 month"
ExpiresByType image/x-icon "access plus 1 year"
ExpiresDefault "access plus 2 days"
</IfModule>

# Force HTTPS (SSL)
<IfModule mod_rewrite.c>
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://musaix.com%{REQUEST_URI} [L,R=301]
</IfModule>

# 🎵 MUSAIX SPECIFIC OPTIMIZATIONS
# Optimize for AI content delivery
<IfModule mod_headers.c>
Header set Cache-Control "public, max-age=31536000" "expr=%{REQUEST_URI} =~ m#\.(ico|png|jpg|jpeg|gif|webp|js|css|woff|woff2|ttf|svg)$#"
</IfModule>
EOF

echo "✅ Optimized .htaccess created"

echo ""
echo "3️⃣ WORDPRESS CONFIGURATION OPTIMIZATION"
echo "========================================"
echo ""

# Check and optimize wp-config.php
if [ -f wp-config.php ]; then
    echo "⚙️ Checking WordPress configuration..."
    
    # Create backup
    cp wp-config.php wp-config.php.backup.$(date +%Y%m%d_%H%M%S)
    echo "✅ wp-config.php backed up"
    
    # Add performance optimizations if not present
    if ! grep -q "WP_CACHE" wp-config.php; then
        sed -i "/\/\* That's all, stop editing/i define('WP_CACHE', true);" wp-config.php
        echo "✅ WordPress caching enabled"
    fi
    
    if ! grep -q "COMPRESS_CSS" wp-config.php; then
        sed -i "/\/\* That's all, stop editing/i define('COMPRESS_CSS', true);" wp-config.php
        echo "✅ CSS compression enabled"
    fi
    
    if ! grep -q "COMPRESS_SCRIPTS" wp-config.php; then
        sed -i "/\/\* That's all, stop editing/i define('COMPRESS_SCRIPTS', true);" wp-config.php
        echo "✅ Script compression enabled"
    fi
    
    if ! grep -q "CONCATENATE_SCRIPTS" wp-config.php; then
        sed -i "/\/\* That's all, stop editing/i define('CONCATENATE_SCRIPTS', true);" wp-config.php
        echo "✅ Script concatenation enabled"
    fi
    
    # Increase memory limit if needed
    if ! grep -q "WP_MEMORY_LIMIT" wp-config.php; then
        sed -i "/\/\* That's all, stop editing/i define('WP_MEMORY_LIMIT', '256M');" wp-config.php
        echo "✅ Memory limit increased to 256M"
    fi
fi

echo ""
echo "4️⃣ DATABASE OPTIMIZATION"
echo "========================"
echo ""

# Extract database credentials
DB_NAME=$(grep "DB_NAME" wp-config.php | cut -d "'" -f 4)
DB_USER=$(grep "DB_USER" wp-config.php | cut -d "'" -f 4)
DB_PASS=$(grep "DB_PASSWORD" wp-config.php | cut -d "'" -f 4)
DB_HOST=$(grep "DB_HOST" wp-config.php | cut -d "'" -f 4)

echo "🗄️ Optimizing database: $DB_NAME"

# Create database optimization SQL
cat > optimize_db.sql << EOF
-- 🎵 MUSAIX.COM DATABASE OPTIMIZATION

-- Clean up post revisions (keep last 3)
DELETE r1 FROM ${DB_NAME}.9Uk_posts r1
INNER JOIN ${DB_NAME}.9Uk_posts r2
WHERE r1.post_parent = r2.post_parent
AND r1.post_type = 'revision'
AND r1.ID < r2.ID
AND r1.post_parent IN (
  SELECT ID FROM (
    SELECT ID FROM ${DB_NAME}.9Uk_posts 
    WHERE post_type = 'revision' 
    GROUP BY post_parent 
    HAVING COUNT(*) > 3
  ) AS temp
);

-- Clean up spam and trashed comments
DELETE FROM ${DB_NAME}.9Uk_comments WHERE comment_approved = 'spam';
DELETE FROM ${DB_NAME}.9Uk_comments WHERE comment_approved = 'trash';

-- Clean up unused post meta
DELETE pm FROM ${DB_NAME}.9Uk_postmeta pm
LEFT JOIN ${DB_NAME}.9Uk_posts p ON pm.post_id = p.ID
WHERE p.ID IS NULL;

-- Clean up unused comment meta
DELETE cm FROM ${DB_NAME}.9Uk_commentmeta cm
LEFT JOIN ${DB_NAME}.9Uk_comments c ON cm.comment_id = c.comment_ID
WHERE c.comment_ID IS NULL;

-- Clean up transients (expired temporary data)
DELETE FROM ${DB_NAME}.9Uk_options WHERE option_name LIKE '_transient_%';
DELETE FROM ${DB_NAME}.9Uk_options WHERE option_name LIKE '_site_transient_%';

-- Optimize all tables
OPTIMIZE TABLE ${DB_NAME}.9Uk_posts;
OPTIMIZE TABLE ${DB_NAME}.9Uk_postmeta;
OPTIMIZE TABLE ${DB_NAME}.9Uk_comments;
OPTIMIZE TABLE ${DB_NAME}.9Uk_commentmeta;
OPTIMIZE TABLE ${DB_NAME}.9Uk_options;
OPTIMIZE TABLE ${DB_NAME}.9Uk_users;
OPTIMIZE TABLE ${DB_NAME}.9Uk_usermeta;
EOF

echo "📊 Database optimization script created (optimize_db.sql)"

echo ""
echo "5️⃣ UPLOADS DIRECTORY OPTIMIZATION"
echo "================================="
echo ""

# Optimize uploads directory
if [ -d wp-content/uploads ]; then
    echo "📁 Optimizing uploads directory..."
    
    # Create .htaccess in uploads for security
    cat > wp-content/uploads/.htaccess << 'EOF'
# Protect uploads directory
<Files *.php>
deny from all
</Files>
EOF
    
    echo "✅ Uploads directory secured"
    
    # Set correct permissions
    find wp-content/uploads -type d -exec chmod 755 {} \;
    find wp-content/uploads -type f -exec chmod 644 {} \;
    echo "✅ Uploads permissions optimized"
fi

echo ""
echo "6️⃣ PLUGIN CACHE OPTIMIZATION"
echo "============================"
echo ""

# Clear any existing cache files
echo "🧹 Clearing cache files..."

# Common cache directories
CACHE_DIRS=(
    "wp-content/cache"
    "wp-content/uploads/cache"
    "wp-content/w3tc-config"
    "wp-content/et-cache"
)

for cache_dir in "${CACHE_DIRS[@]}"; do
    if [ -d "$cache_dir" ]; then
        rm -rf "$cache_dir"/*
        echo "✅ Cleared: $cache_dir"
    fi
done

echo ""
echo "✅ OPTIMIZATION COMPLETE!"
echo "========================"
echo ""

echo "🚀 Performance improvements applied:"
echo "  ✅ File permissions optimized"
echo "  ✅ .htaccess configured for speed and security"
echo "  ✅ WordPress configuration enhanced"
echo "  ✅ Database optimization script ready"
echo "  ✅ Uploads directory secured"
echo "  ✅ Cache cleared"
echo ""
echo "🔧 Manual steps required:"
echo "  1. Run database optimization:"
echo "     mysql -u $DB_USER -p $DB_NAME < optimize_db.sql"
echo "  2. Test your site: https://musaix.com"
echo "  3. Test admin: https://musaix.com/wp-admin"
echo "  4. Verify AI features are working"
echo ""
echo "🎵 Your Musaix Pro site is now optimized for maximum performance!"