# Task Management - Naive Bayes

Project ini terdiri dari dua service utama:

1. Laravel (Web Application)
2. Python API (Machine Learning - Naive Bayes)

Keduanya dijalankan menggunakan Docker.

------------------------------------------------------------
STRUKTUR PROJECT
------------------------------------------------------------

```
naive-bayes
├── task-management/
├── task-management-api/
└── README.md
```

### Keterangan

- `task-management/` → Laravel Web Application  
- `task-management-api/` → Python Machine Learning API  

------------------------------------------------------------
1. CLONE REPOSITORY
------------------------------------------------------------

    git clone <repo-url>
    cd naive-bayes
    sudo chown -R user:user naive-bayes

------------------------------------------------------------
2. SETUP LARAVEL (WEB APPLICATION)
------------------------------------------------------------

Masuk ke folder Laravel:

    cd task-management

Install dependency:

    composer install
    cp .env.example .env

------------------------------------------------------------
KONFIGURASI DATABASE
------------------------------------------------------------

Edit file .env dan sesuaikan:

    DB_CONNECTION=mysql
    DB_HOST=mysql
    DB_PORT=3306
    DB_DATABASE=naivebayes
    DB_USERNAME=root
    DB_PASSWORD=password

------------------------------------------------------------
INSTALL LARAVEL SAIL
------------------------------------------------------------

    php artisan sail:install

------------------------------------------------------------
GENERATE KEY & SETUP DATABASE
------------------------------------------------------------

    ./vendor/bin/sail artisan key:generate
    ./vendor/bin/sail artisan migrate
    ./vendor/bin/sail artisan db:seed

------------------------------------------------------------
JALANKAN LARAVEL
------------------------------------------------------------

    ./vendor/bin/sail up -d

Akses aplikasi melalui browser:

    http://localhost

Untuk menghentikan container:

    ./vendor/bin/sail down
    
atau
    
    ./vendor/bin/sail stop

------------------------------------------------------------
3. SETUP PYTHON API (MACHINE LEARNING SERVICE)
------------------------------------------------------------

Masuk ke folder API:

    cd task-management-api

Build dan jalankan container:

    docker compose up --build

Untuk menghentikan service:

    docker compose down
    
atau
   
    docker compose stop

API akan berjalan di http://localhost:8000/api/sort-tasks

------------------------------------------------------------
REQUIREMENT
------------------------------------------------------------

- Docker
- Docker Compose
- PHP
- Composer
- Linux / WSL (Direkomendasikan)

------------------------------------------------------------
TROUBLESHOOTING
------------------------------------------------------------

Permission Error:

    sudo chown -R $USER:$USER .

Database Access Denied:
- Pastikan konfigurasi .env sesuai dengan MySQL container.
- Pastikan service mysql berjalan.

Cek Log Container:

    ./vendor/bin/sail logs
    docker compose logs

------------------------------------------------------------

Project siap digunakan setelah kedua service (Laravel dan Python API) berjalan dengan baik.
