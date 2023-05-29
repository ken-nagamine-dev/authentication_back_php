# authentication_back_php
base code for back-end authentication with JWT.

## use
* php ^8.1.10
* composer 2.5.5
* vlucas/phpdotenv ^5.5
* firebase/php-jwt ^6.5

### server local
- php -S localhost:8000

### routes
* /auth/login
* /users/getAll

### database
* table users (id, email, password)