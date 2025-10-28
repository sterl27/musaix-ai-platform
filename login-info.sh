#!/bin/bash

echo "🎵 MUSAIX PRO - ADMIN LOGIN CREDENTIALS"
echo "======================================"
echo ""
echo "🌐 WordPress Admin: http://localhost:8080/wp-admin"
echo ""
echo "👤 ADMIN USERS:"
echo ""
echo "🔑 Primary Admin (Original):"
echo "   Username: admin"
echo "   Password: admin123"
echo "   Email: admin@example.com"
echo ""
echo "🔑 S73RL Admin (Your Account):"
echo "   Username: S73RL"
echo "   Password: Bl@ckbirdSr71"
echo "   Email: x@sterlai.com"
echo "   Name: Sterling Atkinson"
echo "   Role: Administrator"
echo ""
echo "💡 Both accounts have full administrative privileges"
echo ""
echo "🚀 Quick Access:"
echo "   • WordPress Admin: http://localhost:8080/wp-admin"
echo "   • Site Frontend:   http://localhost:8080"
echo "   • phpMyAdmin:      http://localhost:8081"
echo ""
echo "📊 Development Status:"
echo "   ✅ WordPress installed and running"
echo "   ✅ Admin users created"
echo "   ✅ Essential plugins installed"
echo "   ✅ Ready for content import"
echo ""

# Option to open admin panel
read -p "🌐 Open WordPress admin panel now? (y/n): " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    echo "🚀 Opening WordPress admin..."
    if command -v xdg-open > /dev/null; then
        xdg-open http://localhost:8080/wp-admin
    elif command -v open > /dev/null; then
        open http://localhost:8080/wp-admin
    else
        echo "Please manually open: http://localhost:8080/wp-admin"
    fi
fi