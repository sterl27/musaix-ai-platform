#!/bin/bash

# 🔍 MUSAIX.COM AI FEATURES TEST SCRIPT
# Run this on your HostGator server: ssh acaptade@192.254.189.236

echo "🤖 MUSAIX.COM - AI FEATURES TESTING"
echo "==================================="
echo ""

# Switch to WordPress directory
cd ~/public_html || { echo "❌ Cannot access public_html"; exit 1; }

# Extract database credentials
if [ -f wp-config.php ]; then
    DB_NAME=$(grep "DB_NAME" wp-config.php | cut -d "'" -f 4)
    DB_USER=$(grep "DB_USER" wp-config.php | cut -d "'" -f 4)
    DB_PASS=$(grep "DB_PASSWORD" wp-config.php | cut -d "'" -f 4)
    DB_HOST=$(grep "DB_HOST" wp-config.php | cut -d "'" -f 4)
else
    echo "❌ wp-config.php not found"
    exit 1
fi

echo "🔍 TESTING AI PLUGIN STATUS"
echo "==========================="
echo ""

# Check if AIP plugin exists
if [ -d "wp-content/plugins/ai-power-complete-ai-pack" ] || [ -d "wp-content/plugins/gpt3-ai-content-generator" ]; then
    echo "✅ AIP AI Toolkit plugin directory found"
    
    # Check plugin files
    AI_PLUGIN_FILES=(
        "wp-content/plugins/ai-power-complete-ai-pack/ai-power.php"
        "wp-content/plugins/gpt3-ai-content-generator/gpt3-ai-content-generator.php"
    )
    
    for plugin_file in "${AI_PLUGIN_FILES[@]}"; do
        if [ -f "$plugin_file" ]; then
            echo "✅ Found: $plugin_file"
            
            # Check plugin version
            VERSION=$(grep "Version:" "$plugin_file" | head -1 | sed 's/.*Version: *//' | sed 's/ .*//')
            if [ ! -z "$VERSION" ]; then
                echo "   📦 Version: $VERSION"
            fi
        fi
    done
else
    echo "⚠️ AI plugin directory not found - checking database for activation status"
fi

echo ""
echo "🗄️ DATABASE AI FEATURES CHECK"
echo "============================"
echo ""

# Create SQL script to check AI features
cat > check_ai_features.sql << EOF
-- Check active plugins
SELECT option_value FROM ${DB_NAME}.9Uk_options WHERE option_name = 'active_plugins';

-- Check AI-related options
SELECT option_name, option_value FROM ${DB_NAME}.9Uk_options 
WHERE option_name LIKE '%ai%' OR option_name LIKE '%gpt%' OR option_name LIKE '%aip%'
LIMIT 10;

-- Check AI-related posts/pages
SELECT ID, post_title, post_type, post_status FROM ${DB_NAME}.9Uk_posts 
WHERE post_content LIKE '%ai%' OR post_title LIKE '%AI%' OR post_title LIKE '%Tweet%' OR post_title LIKE '%Blog%'
LIMIT 10;

-- Check for AI widgets or shortcodes
SELECT ID, post_title FROM ${DB_NAME}.9Uk_posts 
WHERE post_content LIKE '%aipkit%' OR post_content LIKE '%[ai%' OR post_content LIKE '%chatbot%'
LIMIT 5;

-- Check user capabilities for AI features
SELECT user_login, user_email FROM ${DB_NAME}.9Uk_users WHERE user_login = 'S73RL' OR user_login = 'admin';
EOF

echo "📊 Running database checks..."
mysql -h "$DB_HOST" -u "$DB_USER" -p"$DB_PASS" < check_ai_features.sql > ai_check_results.txt 2>/dev/null

if [ $? -eq 0 ]; then
    echo "✅ Database query completed - results saved to ai_check_results.txt"
else
    echo "❌ Database query failed - check credentials"
fi

echo ""
echo "🎨 ELEMENTOR FEATURES CHECK"
echo "=========================="
echo ""

# Check Elementor installation
if [ -d "wp-content/plugins/elementor" ]; then
    echo "✅ Elementor plugin found"
    
    # Check Elementor Pro
    if [ -d "wp-content/plugins/elementor-pro" ]; then
        echo "✅ Elementor Pro plugin found"
    else
        echo "⚠️ Elementor Pro not found"
    fi
    
    # Check Elementor uploads directory
    if [ -d "wp-content/uploads/elementor" ]; then
        ELEMENTOR_FILES=$(find wp-content/uploads/elementor -name "*.css" | wc -l)
        echo "✅ Elementor uploads directory: $ELEMENTOR_FILES CSS files"
    fi
    
else
    echo "❌ Elementor plugin not found"
fi

echo ""
echo "🔌 ALL PLUGINS STATUS"
echo "===================="
echo ""

# List all installed plugins
if [ -d "wp-content/plugins" ]; then
    echo "📦 Installed plugins:"
    for plugin in wp-content/plugins/*/; do
        if [ -d "$plugin" ]; then
            plugin_name=$(basename "$plugin")
            main_file=$(find "$plugin" -maxdepth 1 -name "*.php" | head -1)
            
            if [ -f "$main_file" ]; then
                # Try to get plugin name from header
                display_name=$(grep "Plugin Name:" "$main_file" | head -1 | sed 's/.*Plugin Name: *//' | sed 's/ *\*\/.*//')
                if [ ! -z "$display_name" ]; then
                    echo "  ✅ $display_name ($plugin_name)"
                else
                    echo "  📁 $plugin_name"
                fi
            else
                echo "  📁 $plugin_name (no main file found)"
            fi
        fi
    done
else
    echo "❌ Plugins directory not found"
fi

echo ""
echo "🌐 WEBSITE CONNECTIVITY TEST"
echo "============================"
echo ""

# Test if site is accessible
echo "🔗 Testing site connectivity..."

# Check if we can access the site (if curl is available)
if command -v curl >/dev/null 2>&1; then
    HTTP_STATUS=$(curl -s -o /dev/null -w "%{http_code}" https://musaix.com)
    if [ "$HTTP_STATUS" = "200" ]; then
        echo "✅ Site accessible: https://musaix.com (HTTP $HTTP_STATUS)"
    else
        echo "⚠️ Site status: HTTP $HTTP_STATUS"
    fi
    
    # Test admin area
    ADMIN_STATUS=$(curl -s -o /dev/null -w "%{http_code}" https://musaix.com/wp-admin/)
    if [ "$ADMIN_STATUS" = "200" ] || [ "$ADMIN_STATUS" = "302" ]; then
        echo "✅ Admin accessible: https://musaix.com/wp-admin/ (HTTP $ADMIN_STATUS)"
    else
        echo "⚠️ Admin status: HTTP $ADMIN_STATUS"
    fi
else
    echo "⚠️ curl not available - cannot test connectivity"
fi

echo ""
echo "📱 AI FEATURES FUNCTIONALITY TEST"
echo "================================="
echo ""

# Create test content to verify AI features
echo "🧪 Creating AI features test content..."

cat > test_ai_features.txt << EOF
🤖 MUSAIX.COM AI FEATURES TEST CHECKLIST
=======================================

Manual tests to perform in WordPress admin (https://musaix.com/wp-admin):

1. 🐦 AI TWEET CLASSIFIER
   □ Login to WordPress admin
   □ Look for AIP or AI Power plugin in sidebar
   □ Find Tweet Classifier tool
   □ Test with sample tweet text
   □ Verify classification results

2. ✍️ BLOG POST GENERATOR
   □ Access AI content generator
   □ Enter topic: "AI in Music Production"
   □ Generate blog post content
   □ Verify quality and relevance

3. 💼 BUSINESS STRATEGY ADVISOR
   □ Find business advisor tool
   □ Input business question about music industry
   □ Review AI-generated advice
   □ Check for actionable insights

4. 💬 AI CHATBOTS (aipkit_chatbot)
   □ Look for chatbot configuration
   □ Test chatbot responses
   □ Verify integration on frontend
   □ Check conversation flow

5. 📝 AI FORMS (aipkit_ai_form)
   □ Find AI forms in admin
   □ Test form generation
   □ Verify AI form processing
   □ Check form submissions

6. 🎨 ELEMENTOR INTEGRATION
   □ Edit page with Elementor
   □ Look for AI widgets in Elementor panel
   □ Test AI widget functionality
   □ Verify design integration

7. 📊 GENERAL FUNCTIONALITY
   □ Check plugin settings and configuration
   □ Verify API connections (if applicable)
   □ Test on different pages/posts
   □ Check mobile responsiveness

ADMIN ACCESS:
- URL: https://musaix.com/wp-admin
- Username: S73RL
- Password: Bl@ckbirdSr71

TROUBLESHOOTING:
- If features not visible: Check plugin activation
- If not working: Check error logs
- If slow: Run optimization script
- If broken: Restore from backup
EOF

echo "✅ AI features test guide created (test_ai_features.txt)"

echo ""
echo "📊 SYSTEM RESOURCE CHECK"
echo "========================"
echo ""

# Check system resources
echo "💾 Disk usage for WordPress:"
du -sh . 2>/dev/null || echo "Could not check disk usage"

echo ""
echo "📁 Directory sizes:"
for dir in wp-content/plugins wp-content/themes wp-content/uploads; do
    if [ -d "$dir" ]; then
        size=$(du -sh "$dir" 2>/dev/null | cut -f1)
        echo "  $dir: $size"
    fi
done

echo ""
echo "✅ AI FEATURES TEST COMPLETE!"
echo "============================="
echo ""

echo "📋 TEST RESULTS SUMMARY:"
echo "  🔍 System check completed"
echo "  📊 Database queries executed"
echo "  📁 Plugin directories verified"
echo "  🌐 Connectivity tested"
echo "  📝 Manual test guide created"
echo ""
echo "🎯 NEXT STEPS:"
echo "  1. Review: ai_check_results.txt for database findings"
echo "  2. Follow: test_ai_features.txt for manual testing"
echo "  3. Login to: https://musaix.com/wp-admin (S73RL/Bl@ckbirdSr71)"
echo "  4. Test each AI feature systematically"
echo ""
echo "🎵 Your Musaix Pro AI features are ready for testing!"

# Cleanup
rm -f check_ai_features.sql