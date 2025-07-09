# Aplikasi Informasi dan Layanan - Laravel 7

Aplikasi ini dikembangkan menggunakan teknologi **Laravel 7** untuk menyediakan informasi dan layanan kepada pengguna, seperti berita, pengumuman, laporan keuangan, dan berbagai layanan lainnya.

---

## ✅ Requirements

- PHP 7.x
- MySQL
- Composer
- Web Server (Apache/Nginx)
- Node.js & NPM (opsional, jika menggunakan fitur frontend)

---

## 🚀 Fitur

- 📢 Berita
- 📣 Pengumuman
- 📊 Laporan Keuangan
- 🛠️ Layanan

---

## ⚙️ Cara Menjalankan

1.  **Clone Repository**

    ```bash
    git clone https://github.com/username/nama-aplikasi.git
    ```

    ```bash
    cd nama-aplikasi
    ```

2.  **Install Dependency**

    ```bash
    composer install
    ```

3.  **Salin File Environment**

    ```bash
    cp .env.example .env
    ```

4.  **Konfigurasi Database di .env**
    ```makefile
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=nama_database
    DB_USERNAME=root
    DB_PASSWORD=
    ```
5.  **Generate Key & Migrasi Database**

    ```bash
    php artisan key:generate
    php artisan migrate
    ```

6.  **Jalankan Server**
    ```bash
    php artisan serve
    ```
