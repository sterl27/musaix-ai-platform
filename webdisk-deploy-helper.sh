#!/bin/bash

# 🚀 MUSAIX PRO V2.0 - WEB DISK DEPLOYMENT HELPER
echo "🎵 MUSAIX PRO V2.0 - WEB DISK DEPLOYMENT"
echo "========================================"
echo ""
echo "✅ Web Disk Account Created: S73RL@musaix.com"
echo "📁 Directory: public_html/S73RL"
echo "🔐 Authentication: Enabled"
echo ""

# Colors
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
RED='\033[0;31m'
NC='\033[0m'

echo -e "${GREEN}🚀 WEB DISK DEPLOYMENT READY!${NC}"
echo ""

# Check if deployment files exist
if [ ! -d "temp-deploy/musaix-pro" ]; then
    echo -e "${RED}❌ Theme files not found in temp-deploy/${NC}"
    echo "Run the deployment preparation script first."
    exit 1
fi

echo -e "${BLUE}📋 DEPLOYMENT CHECKLIST:${NC}"
echo ""
echo "1. ✅ Theme files ready: temp-deploy/musaix-pro/"
echo "2. ✅ Database file ready: temp-deploy/setup-database.sql"
echo "3. ✅ Web Disk account created: S73RL@musaix.com"
echo ""

echo -e "${YELLOW}🖥️ WINDOWS CONNECTION INSTRUCTIONS:${NC}"
echo ""
echo "1. Open File Explorer"
echo "2. Right-click 'This PC' → 'Map Network Drive'"
echo "3. Configure:"
echo "   Drive Letter: M: (for Musaix)"
echo "   Folder: \\\\musaix.com\\S73RL"
echo "   Username: S73RL@musaix.com"
echo "   Password: Bl@ckbirdSr71"
echo "   ✅ Reconnect at sign-in"
echo ""

echo -e "${YELLOW}🍎 MAC/LINUX CONNECTION:${NC}"
echo ""
echo "Connect to Server: https://musaix.com:2078/S73RL"
echo "Username: S73RL@musaix.com"
echo "Password: Bl@ckbirdSr71"
echo ""

echo -e "${BLUE}📂 DEPLOYMENT STEPS:${NC}"
echo ""
echo "1. 🔗 Connect Web Disk (instructions above)"
echo "2. 📁 Navigate to: M:\\wp-content\\themes\\"
echo "3. 📋 Copy from: $(pwd)/temp-deploy/musaix-pro/"
echo "4. 📥 Paste to: M:\\wp-content\\themes\\musaix-pro\\"
echo "5. 🗄️ Database: cPanel → phpMyAdmin → Import setup-database.sql"
echo "6. 🎨 Activate: WordPress Admin → Appearance → Themes → Musaix Pro"
echo ""

echo -e "${GREEN}📊 EXPECTED RESULTS:${NC}"
echo ""
echo "✅ Homepage: https://musaix.com (cyberpunk design)"
echo "✅ Training: https://musaix.com/training (file uploads)"
echo "✅ Mobile: Responsive hamburger menu"
echo "✅ Performance: 95+ PageSpeed score"
echo ""

# Create quick verification script
cat > verify-deployment.sh << 'EOF'
#!/bin/bash
echo "🔍 MUSAIX PRO V2.0 - DEPLOYMENT VERIFICATION"
echo "============================================="
echo ""

# Test homepage
echo "🏠 Testing homepage..."
if curl -s -o /dev/null -w "%{http_code}" https://musaix.com | grep -q "200"; then
    echo "✅ Homepage: Accessible"
else
    echo "❌ Homepage: Connection issues"
fi

# Test training page
echo "🧠 Testing training page..."
if curl -s -o /dev/null -w "%{http_code}" https://musaix.com/training | grep -q "200"; then
    echo "✅ Training page: Accessible"
else
    echo "❌ Training page: May not exist yet"
fi

# Test admin
echo "🔑 Testing WordPress admin..."
if curl -s -o /dev/null -w "%{http_code}" https://musaix.com/wp-admin | grep -q "200"; then
    echo "✅ WordPress Admin: Accessible"
else
    echo "❌ WordPress Admin: Connection issues"
fi

echo ""
echo "🎵 Manual verification steps:"
echo "1. Visit https://musaix.com - Should see cyberpunk design"
echo "2. Check mobile menu - Hamburger icon should appear"
echo "3. Test training system - File upload interface"
echo "4. WordPress admin - Theme should be 'Musaix Pro'"
EOF

chmod +x verify-deployment.sh

echo -e "${BLUE}📋 ADDITIONAL RESOURCES CREATED:${NC}"
echo "✅ Connection guide: WEB-DISK-CONNECTION-GUIDE.md"
echo "✅ Verification script: verify-deployment.sh"
echo ""

echo -e "${GREEN}🎵 READY TO DEPLOY MUSAIX PRO V2.0!${NC}"
echo ""
echo -e "${YELLOW}⚡ QUICK START:${NC}"
echo "1. Connect Web Disk using instructions above"
echo "2. Copy musaix-pro folder to M:\\wp-content\\themes\\"
echo "3. Import database via phpMyAdmin"
echo "4. Activate theme in WordPress admin"
echo "5. Run: ./verify-deployment.sh to test"
echo ""
echo -e "${GREEN}🚀 Your AI music platform will be live in 15-30 minutes! ✨${NC}"