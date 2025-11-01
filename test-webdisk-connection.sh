#!/bin/bash
echo "🔍 TESTING WEB DISK CONNECTION"
echo "============================="
echo ""
echo "Testing domain accessibility..."

# Test main domain
if ping -c 1 musaix.com >/dev/null 2>&1; then
    echo "✅ musaix.com: Domain reachable"
else
    echo "❌ musaix.com: Connection issues"
fi

# Test WebDAV port
if nc -z musaix.com 2078 2>/dev/null; then
    echo "✅ Port 2078: WebDAV port open"
else
    echo "⚠️  Port 2078: May be filtered (normal on some networks)"
fi

echo ""
echo "🔗 CONNECTION METHODS TO TRY:"
echo "1. Windows Network Drive: \\\\musaix.com\\S73RL"
echo "2. WebDAV HTTPS: https://musaix.com:2078/S73RL"
echo "3. WebDAV HTTP: http://musaix.com:2077/S73RL"
echo "4. Browser Access: https://musaix.com:2078"
echo ""
echo "If connection fails, try browser method first!"
