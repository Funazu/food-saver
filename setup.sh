#!/bin/bash

read -p "👤 Nama Admin: " ADMIN_NAME
read -p "📧 Email Admin: " ADMIN_EMAIL
read -s -p "🔐 Password Admin: " ADMIN_PASSWORD
echo

export ADMIN_NAME
export ADMIN_EMAIL
export ADMIN_PASSWORD

php artisan shield:generate

php artisan shield:generate

echo "⚙️ Migrasi dan seeding..."
php artisan migrate:fresh --seed

echo ""
echo "✅ Admin berhasil dibuat!"
echo "🧑‍💼 Nama: $ADMIN_NAME"
echo "📧 Email: $ADMIN_EMAIL"
echo "🔑 Password: (disembunyikan)"
