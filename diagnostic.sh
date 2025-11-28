#!/bin/bash

echo "🔍 DIAGNOSTIC CASH OUT - Laravel"
echo "================================="
echo ""

# 1. Version PHP
echo "1️⃣ Version PHP:"
php -v | head -n 1
echo ""

# 2. Version Laravel
echo "2️⃣ Version Laravel:"
php artisan --version
echo ""

# 3. Vérifier les fichiers critiques
echo "3️⃣ Fichiers critiques:"
echo "✓ Routes web.php:" $([ -f routes/web.php ] && echo "OK" || echo "❌ MANQUANT")
echo "✓ Routes auth.php:" $([ -f routes/auth.php ] && echo "OK" || echo "❌ MANQUANT")
echo "✓ Bootstrap app.php:" $([ -f bootstrap/app.php ] && echo "OK" || echo "❌ MANQUANT")
echo "✓ .env:" $([ -f .env ] && echo "OK" || echo "❌ MANQUANT")
echo ""

# 4. Vérifier les middleware
echo "4️⃣ Middleware essentiels:"
echo "✓ Authenticate.php:" $([ -f app/Http/Middleware/Authenticate.php ] && echo "OK" || echo "❌ MANQUANT")
echo "✓ RedirectIfAuthenticated.php:" $([ -f app/Http/Middleware/RedirectIfAuthenticated.php ] && echo "OK" || echo "❌ MANQUANT")
echo ""

# 5. Permissions
echo "5️⃣ Permissions:"
echo "✓ storage:" $([ -w storage ] && echo "OK" || echo "❌ NON WRITABLE")
echo "✓ bootstrap/cache:" $([ -w bootstrap/cache ] && echo "OK" || echo "❌ NON WRITABLE")
echo ""

# 6. Cache
echo "6️⃣ Nettoyage des caches..."
php artisan config:clear > /dev/null 2>&1 && echo "✓ Config cleared" || echo "❌ Config clear failed"
php artisan cache:clear > /dev/null 2>&1 && echo "✓ Cache cleared" || echo "❌ Cache clear failed"
php artisan route:clear > /dev/null 2>&1 && echo "✓ Routes cleared" || echo "❌ Route clear failed"
php artisan view:clear > /dev/null 2>&1 && echo "✓ Views cleared" || echo "❌ View clear failed"
echo ""

# 7. Test syntaxe PHP
echo "7️⃣ Test syntaxe bootstrap/app.php:"
php -l bootstrap/app.php
echo ""

# 8. Lister les routes
echo "8️⃣ Routes disponibles:"
php artisan route:list --columns=Method,URI,Name 2>&1 | head -n 15
echo ""

# 9. Database
echo "9️⃣ Database connection:"
php artisan db:show 2>&1 | head -n 5
echo ""

# 10. Permissions détaillées
echo "🔟 Permissions détaillées:"
ls -la storage/ | head -n 5
echo ""

echo "================================="
echo "✅ Diagnostic terminé"
echo ""
echo "Si vous voyez des ❌, corrigez-les avant de continuer."