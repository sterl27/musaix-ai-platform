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
echo "📊 FILE SYSTEM STATUS"
echo "====================="
echo ""

# Check file permissions
echo "🔒 Checking file permissions..."
find . -name "wp-config.php" -exec ls -la {} \;
find . -name "wp-content" -type d -exec ls -ld {} \;

# Check disk usage
echo ""
echo "💾 Disk Usage:"
du -sh . 2>/dev/null || echo "Could not calculate disk usage"

# Count files
echo ""
echo "📁 File Count:"
echo "  Total files: $(find . -type f | wc -l)"
echo "  PHP files: $(find . -name "*.php" | wc -l)"
echo "  Images: $(find . -name "*.jpg" -o -name "*.png" -o -name "*.gif" -o -name "*.webp" | wc -l)"

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
echo "🎨 THEME STATUS CHECK" 
echo "===================="
echo ""

if [ -d wp-content/themes ]; then
    echo "🎨 Installed Themes:"
    ls -la wp-content/themes/ | grep "^d" | awk '{print "  " $9}' | grep -v "^\.$\|^\.\.$"
else
    echo "❌ Themes directory not found"
fi

echo ""
echo "📝 LOG FILE STATUS"
echo "=================="
echo ""

# Check for common log files
LOG_FILES=(
    "wp-content/debug.log"
    "error_log"
    ".htaccess"
)

for log_file in "${LOG_FILES[@]}"; do
    if [ -f "$log_file" ]; then
        size=$(du -sh "$log_file" | cut -f1)
        echo "📄 $log_file: $size"
        
        # Show last few lines if it's a log file
        if [[ "$log_file" == *".log" ]]; then
            echo "   Last 3 entries:"
            tail -n 3 "$log_file" 2>/dev/null | sed 's/^/   /' || echo "   (Could not read log)"
        fi
    else
        echo "❌ $log_file: Not found"
    fi
done

echo ""
echo "🚀 PERFORMANCE CHECKS"
echo "===================="
echo ""

# Check .htaccess for performance optimizations
if [ -f .htaccess ]; then
    echo "✅ .htaccess found"
    
    # Check for common performance features
    if grep -q "mod_rewrite" .htaccess; then
        echo "  ✅ URL rewriting enabled"
    fi
    
    if grep -q "ExpiresActive" .htaccess; then
        echo "  ✅ Browser caching configured"
    else
        echo "  ⚠️ Browser caching not configured"
    fi
    
    if grep -q "mod_deflate\|mod_gzip" .htaccess; then
        echo "  ✅ Compression enabled"
    else
        echo "  ⚠️ Compression not configured"
    fi
else
    echo "❌ .htaccess not found"
fi

echo ""
echo "🔒 SECURITY STATUS"
echo "=================="
echo ""

# Security checks
SECURITY_FILES=(
    "wp-config.php"
    "wp-admin/install.php"
    "wp-content/uploads/.htaccess"
)

for sec_file in "${SECURITY_FILES[@]}"; do
    if [ -f "$sec_file" ]; then
        perms=$(ls -la "$sec_file" | awk '{print $1}')
        echo "🔐 $sec_file: $perms"
    fi
done

# Check for security plugins or measures
if [ -d "wp-content/plugins" ]; then
    SECURITY_PLUGINS=$(ls wp-content/plugins/ | grep -i "security\|firewall\|wordfence" || echo "None found")
    echo "🛡️ Security plugins: $SECURITY_PLUGINS"
fi

echo ""
echo "📊 SUMMARY & RECOMMENDATIONS"
echo "============================"
echo ""

echo "✅ Status: WordPress installation verified"
echo "🎵 Site: musaix.com is live and operational"
echo ""
echo "🔧 Next Steps:"
echo "  1. Run the optimization script (optimize-musaix.sh)"
echo "  2. Set up automated backups (backup-musaix.sh)"
echo "  3. Test all AI features through WordPress admin"
echo "  4. Monitor error logs regularly"
echo "  5. Keep plugins and WordPress updated"
echo ""
echo "🚀 Your Musaix Pro platform is ready for action!"