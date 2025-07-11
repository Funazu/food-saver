# 🥗 Food Saver

**Food Saver** adalah sebuah platform web yang bertujuan untuk mengurangi limbah makanan dengan cara memfasilitasi penjual makanan untuk menjual makanan berlebih atau makanan dengan waktu konsumsi terbatas, kepada pembeli yang mencari makanan dengan harga terjangkau.

---

## 🚀 Fitur Utama

- Manajemen toko dan makanan oleh penjual
- Sistem pemesanan langsung tanpa keranjang
- Verifikasi penjual oleh admin
- Panel terpisah untuk admin dan penjual (menggunakan Filament)
- Statistik pesanan dan penjualan
- Sistem artikel / edukasi oleh admin
- Pembayaran melalui metode tunai, transfer, atau QRIS (opsional)
- Pembeli dapat melihat makanan berdasarkan lokasi

---

## 🛠️ Teknologi

- **Laravel** 10+
- **Filament Admin Panel**
- **Spatie Permission** (Role & Access)
- **Filament Shield** (panel protection)
- **TailwindCSS**
- **MySQL**
- **Livewire**

---

## ⚙️ Cara Install & Setup

1. **Clone Project**
   ```bash
   git clone https://github.com/yourusername/food-saver.git
   cd food-saver
   ```
2. Instalasi dependensi:
   ```bash
   composer install
   npm install && npm run dev
   ```
3. **Buat file `.env`**
   ```bash
   cp .env.example .env
   ```
4. **Generate Key dan Storage Link**
   ```bash
   php artisan key:generate
   php artisan storage:link
   ```
5. **Migrasi Database**
    ```bash
    bash ./setup.sh
    ```
    Saat menjalankan script ini, kamu akan diminta untuk mengisi:

    - Nama admin
    - Email admin
    - Password admin

    Script ini akan melakukan:

    - Migrasi database
    - Membuat role dan permission
    - Membuat akun admin
    - Menambahkan dummy data (penjual)

    ---

    ## 🌐 Route Akses

    - **Admin Panel:**  
        Akses admin dapat dilakukan melalui:  
        ```
        /admin
        ```

    - **Penjual Panel:**  
        Akses penjual dapat dilakukan melalui:  
        ```
        /penjual
        ```