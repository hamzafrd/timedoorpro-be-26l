### **Prasyarat**

Sebelum menginstal aplikasi ini, pastikan Anda sudah menginstal beberapa perangkat lunak berikut:

- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL atau DBMS lain yang didukung Laravel

### **Langkah-langkah Instalasi**

1. **Clone Repository**

   ```bash
   git clone https://github.com/hamzafrd/timedoorpro-be-26l.git
   cd timedoorpro-be-26l
   ```

2. **Salin File Konfigurasi**

   ```bash
   cp .env.example .env
   ```

3. **Instal Dependensi**

    - Instal dependensi PHP menggunakan Composer:
      ```bash
      composer install
      ```
    - Instal dependensi frontend menggunakan NPM:
      ```bash
      npm install
      ```

4. **Generate Key Aplikasi**

   ```bash
   php artisan key:generate
   ```

5. **Konfigurasi Database**

    - Buka file `.env` dan sesuaikan konfigurasi database Anda:
      ```plaintext
      DB_CONNECTION=mysql
      DB_HOST=127.0.0.1
      DB_PORT=3306
      DB_DATABASE=marketplace
      DB_USERNAME=username_anda
      DB_PASSWORD=password_anda
      ```

6. **Migrasi dan Seed Database**

   ```bash
   php artisan migrate --seed
   ```

7. **Kompilasi Asset Frontend**

   ```bash
   npm run dev
   ```

8. **Jalankan Aplikasi**

   ```bash
   php artisan serve
   ```

   Aplikasi akan berjalan di `http://localhost:8000`.

## **Lisensi**

Aplikasi ini dilisensikan di bawah [MIT License](LICENSE).
