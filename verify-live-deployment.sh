#!/bin/bash
echo "🔍 MUSAIX PRO V2.0 - LIVE VERIFICATION"
echo "====================================="
echo ""

echo "Testing live deployment..."

# Test homepage
echo "🏠 Testing homepage..."
HOME_STATUS=$(curl -s -o /dev/null -w "%{http_code}" https://musaix.com)
if [ "$HOME_STATUS" = "200" ]; then
    echo "✅ https://musaix.com: Accessible ($HOME_STATUS)"
else
    echo "⚠️  https://musaix.com: Status $HOME_STATUS"
fi

# Test training page
echo "🧠 Testing training page..."
TRAIN_STATUS=$(curl -s -o /dev/null -w "%{http_code}" https://musaix.com/training)
if [ "$TRAIN_STATUS" = "200" ]; then
    echo "✅ https://musaix.com/training: Accessible ($TRAIN_STATUS)"
elif [ "$TRAIN_STATUS" = "404" ]; then
    echo "⚠️  https://musaix.com/training: Page not found (normal until theme active)"
else
    echo "⚠️  https://musaix.com/training: Status $TRAIN_STATUS"
fi

# Test WordPress admin
echo "🔑 Testing WordPress admin..."
ADMIN_STATUS=$(curl -s -o /dev/null -w "%{http_code}" https://musaix.com/wp-admin)
if [ "$ADMIN_STATUS" = "200" ]; then
    echo "✅ https://musaix.com/wp-admin: Accessible ($ADMIN_STATUS)"
else
    echo "⚠️  https://musaix.com/wp-admin: Status $ADMIN_STATUS"
fi

echo ""
echo "🎵 DEPLOYMENT VERIFICATION COMPLETE"
echo ""
echo "Next steps:"
echo "1. Check theme activation in WordPress admin"
echo "2. Verify cyberpunk design on homepage"
echo "3. Test training system functionality"
echo "4. Confirm mobile responsiveness"
echo ""
echo "🚀 Your Musaix Pro v2.0 should be live!"
