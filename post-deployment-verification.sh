#!/bin/bash
echo "🔍 MUSAIX PRO V2.0 - POST-DEPLOYMENT VERIFICATION"
echo "================================================"
echo ""

# Test site accessibility
echo "🌐 Testing site accessibility..."
if curl -s -L -o /dev/null -w "%{http_code}" https://musaix.com | grep -q "200"; then
    echo "✅ musaix.com: Site accessible"
else
    echo "❌ musaix.com: Connection issues"
fi

# Test WordPress admin
echo "🔑 Testing WordPress admin..."
if curl -s -L -o /dev/null -w "%{http_code}" https://musaix.com/wp-admin | grep -q "200"; then
    echo "✅ WordPress admin: Accessible"
else
    echo "❌ WordPress admin: Connection issues"
fi

echo ""
echo "🎵 Manual verification checklist:"
echo "1. ✅ Visit https://musaix.com - Should show cyberpunk design"
echo "2. ✅ Check WordPress admin - Theme should be 'Musaix Pro'"
echo "3. ✅ Test mobile responsiveness - Hamburger menu"
echo "4. ✅ Verify training system - File upload interface"
echo "5. ✅ Check animations - Cyber grid background"
echo ""
echo "🚀 If all tests pass, your Musaix Pro v2.0 is live!"
