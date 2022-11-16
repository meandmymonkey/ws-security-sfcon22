## SymfonyCon 2022

# Advanced Security with Symfony

### What is this?

A temporary repository containing material for participants of the workshop
[Advanced Security with Symfony](https://live.symfony.com/2022-paris-con/workshop/advanced-security-with-symfony)

### Setup

**General Setup**

- Clone this repository

**Optional - only if you do not have a local PHP 8.1 or database:**

- `docker-compose up -d`
- Enter PHP container

**General Setup**

- `composer install`
- configure local `.env` if required for your DB setup
- `bin/console doctrine:database:create` (when not using provided DB container)
- `bin/console doctrine:migrations:migrate`
- `bin/console doctrine:fixtures:load`
- Open `https://localhost:8000/api/users` in your browser (scheme, host, and port depend on your setup)