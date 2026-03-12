# Task Management - Naive Bayes

Project ini terdiri dari dua service utama:

1. **Laravel Web Application** (Task Management)
2. **Python API** (Machine Learning - Naive Bayes)

Kedua service dijalankan menggunakan **Docker Compose**.

---

# Project Structure

```
naive-bayes
│
├── compose.yaml
│
├── task-management
│   ├── Dockerfile
│   ├── entrypoint.sh
│   ├── app
│   ├── routes
│   ├── composer.json
│   └── ...
│
└── task-management-api
    ├── Dockerfile
    ├── requirements.txt
    └── app
```

## Folder Description

| Folder                | Description                              |
| --------------------- | ---------------------------------------- |
| `task-management`     | Laravel Web Application                  |
| `task-management-api` | Python FastAPI service untuk Naive Bayes |
| `compose.yaml`        | Konfigurasi Docker Compose               |

---

# Requirements

Pastikan software berikut sudah terinstall:

- Docker
- Docker Compose
- Git

Untuk pengguna Windows, **WSL2 sangat direkomendasikan**.

---

# Installation

Clone repository:

```bash
git clone <repo-url>
cd naive-bayes
```

---

# Run Application

Jalankan seluruh service menggunakan Docker Compose:

```bash
docker compose up --build
```

Docker akan menjalankan:

- Laravel container
- MySQL container
- Python API container

Saat container Laravel pertama kali dijalankan, sistem akan otomatis:

- membuat `.env` jika belum ada
- generate `APP_KEY`
- install dependency (`composer install`)
- install frontend dependency (`npm install`)
- build frontend (`npm run build`)
- menjalankan Laravel server

---

# Access Application

Laravel Web Application:

```
http://localhost:8000
```

Python API (Naive Bayes):

```
http://localhost:8001/docs
```

Endpoint API utama:

```
http://localhost:8001/api/sort-tasks
```

---

# Database Configuration

Laravel menggunakan service MySQL dari Docker.

Default configuration:

```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=naivebayes
DB_USERNAME=laravel
DB_PASSWORD=laravel
```

Database akan otomatis dibuat saat container pertama kali dijalankan.

---

# Run Laravel Commands

Untuk menjalankan perintah artisan:

```bash
docker compose exec laravel php artisan migrate
```

Contoh perintah lain:

```bash
docker compose exec laravel php artisan tinker
docker compose exec laravel php artisan db:seed
```

---

# Stop Application

Untuk menghentikan container:

```bash
docker compose down
```

Untuk menghentikan sekaligus menghapus database:

```bash
docker compose down -v
```

---

# View Logs

Melihat log semua container:

```bash
docker compose logs
```

Melihat log Laravel saja:

```bash
docker compose logs laravel
```

---

# Troubleshooting

## Permission Error (WSL)

Jika terjadi error permission:

```bash
sudo chown -R $USER:$USER .
```

## Database Connection Error

Pastikan MySQL container berjalan:

```bash
docker ps
```

Jika database bermasalah, reset volume:

```bash
docker compose down -v
docker compose up --build
```

---

# License

Project ini dibuat untuk keperluan pembelajaran dan pengembangan.
