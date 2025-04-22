# Credit Issuance System

A simple and extensible credit application system built with Laravel 11.

---

## 🚀 Features

- Client creation
- Credit eligibility check
- Credit issuance (with rate modifiers and rejection rules)
- Static analysis (PHPStan) & code style (Laravel Pint)
- HTTP request collections for API testing

---

## 🧱 Tech Stack

- PHP 8.3
- Laravel 11
- MySQL 8 (Dockerized)
- Docker Compose
- PHPUnit
- PHPStan
- Laravel Pint

---

## 📦 Installation

### 1. Clone the repository

```bash
git clone git@github.com:serhiiBliSolutions/credit-system.git
cd credit-system
```

### 2. Copy and configure `.env`

```bash
cp backend/.env.example backend/.env
```

- **Edit `.env` if needed**, default DB config:
  ```
  DB_CONNECTION=mysql
  DB_HOST=mysql
  DB_PORT=3306
  DB_DATABASE=credit
  DB_USERNAME=laravel
  DB_PASSWORD=secret
  ```

### 3. Run Docker and start app

```bash
docker-compose up -d --build
docker-compose exec app composer install
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan migrate
docker-compose exec app php artisan serve --host=0.0.0.0 --port=8000
```


> App is available at: **http://localhost:8000**

---

## 🛠 Usage

### Run tests

```bash
docker-compose exec app php artisan test
```

### Run code style fixer

```bash
docker-compose exec app ./vendor/bin/pint
```

### Run static analysis

```bash
docker-compose exec app ./vendor/bin/phpstan analyse
```

---

## 🧪 API Testing in PhpStorm

Use the `.http` request collection for testing via PhpStorm's HTTP Client.

📄 File: `tests/http/credit-api.http`

1. Open the file in PhpStorm
2. Click ▶️ next to any request block
3. Requires Laravel running on http://localhost:8000

---

## 📁 Folder Structure

```
app/
├── Application/    → Application logic
├── Domain/         → Entities, interfaces, and rules
├── Infrastructure/ → Persistence and logging implementations
├── Http/           → Controllers and Requests
├── Providers/      → Service providers (autoloaded)
```

---

## 🤝 Author

Made with care by Serhii Bespalov  
sergey.bespalov2@gmail.com

---

## 📝 Notes

- `.env` is **excluded** from git (`.gitignore`), you must copy it manually.
- **Composer dependencies** are excluded from git, install with `composer install`.