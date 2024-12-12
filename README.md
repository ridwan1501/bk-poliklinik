# Project Laravel

## Deskripsi
Ini adalah proyek Laravel yang digunakan untuk [deskripsi proyek]. Proyek ini dibangun menggunakan framework Laravel dan dilengkapi dengan fitur-fitur seperti [fitur utama proyek].

## Persyaratan Sistem
- PHP >= 8.2
- Composer
- MySQL atau database lain yang didukung Laravel

## Langkah Instalasi

### 1. Clone Repositori
Clone repositori ini ke mesin lokal Anda menggunakan Git:
```bash
git clone https://github.com/baagas0/appointment.git
```

### 2. Buat database baru pada mysql
Buka phpMyAdmin -> create new

### 3. copy file .env.example ke .env
Copy file .env.example

### 4. Sesuaikan file .env
Sesuaikan file .env yang tadi dicopy seperti config host, nama database, username, password

### 5. install depencies
```bash
composer install
```

### 6. migrate dan seed
Jalanin migrate dan seed
```bash
php artisan migrate:fresh --seed
```

### 7. generate key baru
Buat kunci untuk laravel
```bash
php artisan key:generate
```

### 8. jalankan laravel
```bash
php artisan serve
```

## Login Admin
nama pengguna: admin@gmail.com
kata sandi: admin

(kalau tidak bisa login, cek database users)
