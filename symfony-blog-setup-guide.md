git commit -m "Initial Symfony blog setup"

# Symfony Blog Project Setup & Security Guide (Ordered by Actual Workflow)

## 1. Install Symfony Blog Project
```bash
composer create-project symfony/skeleton symfony-blog
cd symfony-blog
```

## 2. Set Up Docker, MySQL, and phpMyAdmin
- Edit `compose.yaml` and `compose.override.yaml` to add MySQL and phpMyAdmin services.
- Expose MySQL on port 3306 and phpMyAdmin on port 8888.
- Start containers (requires Docker):
  ```bash
  docker compose up -d
  ```

## 3. Configure .env and Secure .env.dev.local
- Edit `.env` to set your `DATABASE_URL` (example for MySQL):
  ```env
  DATABASE_URL="mysql://app:!ChangeMe!@127.0.0.1:3306/symfony_blog?serverVersion=8.0.32&charset=utf8mb4"
  ```
- Create `.env.dev.local` (not committed to git):
  ```env
  APP_SECRET=your_random_secret_key
  ```
- Generate a secure key:
  ```bash
  php -r "echo bin2hex(random_bytes(16));"
  ```
- Ensure `.env.dev.local` is in `.gitignore`.

## 4. Create Database and Run Migrations
```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

## 5. Install Static Code Analyzers
- Install PHP-CS-Fixer:
  ```bash
  composer require --dev friendsofphp/php-cs-fixer
  php vendor/bin/php-cs-fixer fix
  ```
- Install PHPStan:
  ```bash
  composer require --dev phpstan/phpstan phpstan/extension-installer
  vendor/bin/phpstan analyse
  ```

## 6. Install and Configure Twig Extras
- Install extra Twig features as needed:
  ```bash
  composer require twig/inky-extra twig/markdown-extra twig/cssinliner-extra
  ```

## 7. Lint and Fix Twig Templates
- Lint Twig files:
  ```bash
  symfony console lint:twig
  ```
- Install any missing Twig extensions as suggested by the linter.

## 8. Commit Your Work
- After each major step:
  ```bash
  git add .
  git commit -m "Describe your change"
  ```

## 9. Configure Autoload and Environment (Reference)
Symfony loads environment variables in `tests/bootstrap.php`:
```php
if (method_exists(Dotenv::class, 'bootEnv')) {
    (new Dotenv())->bootEnv(dirname(__DIR__).'/.env');
}
```
This ensures your app uses the correct environment variables, including those from `.env.dev.local`.

## 10. Summary
You now have a Symfony blog project with:
- Secure environment configuration
- Database connection
- Static code analysis tools
- Extended Twig features
- Proper version control

This process ensures your Symfony project is secure, maintainable, and ready for development or production.
