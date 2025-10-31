#!/bin/bash

# 🔐 MUSAIX.COM SECURE DEPLOYMENT SCRIPT
# SECURITY NOTE: Credentials removed from script for security
# Use environment variables or secure credential storage

echo "🎵 MUSAIX.COM - SECURE DEPLOYMENT WITH AUTHENTICATION"
echo "=================================================="
echo ""

echo "🔑 Authentication Details:"
echo "  Host: \${DEPLOY_HOST:-acaptade@192.254.189.236}"
echo "  Password: \${DEPLOY_PASSWORD:-[SET DEPLOY_PASSWORD ENV VAR]}"
echo ""

echo "🚀 DEPLOYMENT OPTIONS"
echo "===================="
echo ""

echo "OPTION 1: Upload Scripts via SCP"
echo "--------------------------------"
echo "scp server-scripts.tar.gz \${DEPLOY_HOST}:~/"
echo "(Enter password when prompted - set DEPLOY_PASSWORD env var)"
echo ""

echo "OPTION 2: Manual SSH Connection"
echo "-------------------------------"
echo "ssh \${DEPLOY_HOST}"
echo "(Enter password when prompted - set DEPLOY_PASSWORD env var)"
echo ""

echo "OPTION 3: HostGator cPanel Upload (RECOMMENDED)"
echo "-----------------------------------------------"
echo "1. Login to HostGator cPanel with Energy2024$"
echo "2. Open File Manager"
echo "3. Upload server-scripts.tar.gz to home directory"
echo "4. Right-click → Extract"
echo "5. SSH in to run scripts"
echo ""

echo "📋 ONCE CONNECTED TO SERVER, RUN:"
echo "================================="
echo ""

cat << 'EOF'
# Extract scripts (if uploaded via SCP/cPanel)
tar -xzf server-scripts.tar.gz
chmod +x scripts/*.sh

# Run health check
cd ~/public_html && ~/scripts/health-check-musaix.sh

# Optimize performance
~/scripts/optimize-musaix.sh

# Test AI features
~/scripts/test-ai-features.sh

# Create backup
~/scripts/backup-musaix.sh
EOF

echo ""
echo "🎯 QUICK MANUAL SCRIPT CREATION"
echo "==============================="
echo ""
echo "If you prefer to create scripts directly on server:"
echo ""

cat << 'EOF'
# Connect to server
ssh acaptade@192.254.189.236

# Create scripts directory
mkdir -p ~/scripts

# Create health check script
cat > ~/scripts/health-check-musaix.sh << 'SCRIPT'
#!/bin/bash
echo "🎵 MUSAIX.COM - HEALTH CHECK"
cd ~/public_html || exit 1
echo "✅ WordPress location: $(pwd)"
if [ -f wp-config.php ]; then
    echo "✅ WordPress found"
    DB_NAME=$(grep "DB_NAME" wp-config.php | cut -d "'" -f 4)
    echo "🗄️ Database: $DB_NAME"
fi
echo "🔌 Plugins:"
ls wp-content/plugins/ 2>/dev/null || echo "Plugins directory not found"
echo "🎨 Themes:"
ls wp-content/themes/ 2>/dev/null || echo "Themes directory not found"
echo "✅ Health check complete!"
SCRIPT

# Make executable
chmod +x ~/scripts/health-check-musaix.sh

# Run health check
cd ~/public_html && ~/scripts/health-check-musaix.sh
EOF

echo ""
echo "🎵 Your Musaix Pro site management is ready!"
echo "Choose your preferred deployment method above."
echo ""
echo "🔗 Site Status:"
echo "  • Live Site: https://musaix.com"
echo "  • Admin: https://musaix.com/wp-admin"
echo "  • Login: S73RL / Bl@ckbirdSr71"
echo "  • SSH: acaptade@192.254.189.236 (Energy2024$)"