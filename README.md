MicroBlog
=========

A Symfony 3.3 project.

Нужен установленный MySql и php.
Также устанавливаем Composer: https://getcomposer.org/

Выполняем команды в папке проекта:

```bash
composer install
php bin/console doctrine:schema:update --force
php bin/console doctrine:fixtures:load
php bin/console server:run
```