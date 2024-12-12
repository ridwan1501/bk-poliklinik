# POLIKLINIK

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
https://github.com/ridwan1501/bk-poliklinik.git
cd <project-folder>
```

### 2. Install Composer
```bash
composer install
```

### 3. Copy .env.example ke .env
```bash
cp .env.example .env
```

### 4. Buat Database Baru
Buka phpMyAdmin/Tools Lain -> create new database -> sesuaikan dengan 


### 5. Sesuaikan config .env yang ingin digunakan
Sesuaikan file .env yang tadi dicopy seperti config host, nama database, username, password


### 6. Migrate dan Seed
Jalanin migrate dan seed
```bash
php artisan migrate:fresh --seed
```

### 7. generate Key
Buat kunci untuk laravel
```bash
php artisan key:generate
```

### 8. Run Laravel
```bash
php artisan serve
```

## Login Admin
nama pengguna: admin@gmail.com
kata sandi: admin

(kalau tidak bisa login, cek database users)
