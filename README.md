# Kwenta PHP example

See the [Kwenta documentation](https://docs.kwentapay.io) for more information on how to use the Kwenta API.

## Prerequisites

- PHP 7.2 or later
- [Composer](https://getcomposer.org/)
- [Kwenta API Client](https://github.com/kwentapay/api-client-php)

Example on Ubuntu 24.04:

```text
# Install PHP
sudo apt-get update && sudo apt-get install -y php php-cgi php-cli

# Install Composer
curl -sS https://getcomposer.org/installer -o /tmp/composer-setup.php \
 && sudo php /tmp/composer-setup.php --install-dir=/usr/local/bin --filename=composer \
 && rm /tmp/composer-setup.php

# Install the Kwenta API Client and its dependencies
composer install
```

## Start the example server

```
php -S localhost:5100
```

This should start a server at `http://localhost:5100`.
