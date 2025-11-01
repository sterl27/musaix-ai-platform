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
