## Тестовое задание для компании "РЕГАРГО"

Техническое задание:

1. Создать сайт с 2умя страницами.

2. На первом поле ввода номера ОГРН, 
который тутже валидируется и в конце поля выставляется галочка корректен или нет
(форма должна быть защищена от автоматического ввода). 
Кнопка "Найти" осуществляет переход на второй экран.

3. На втором отображается введенный ранее код.
Второе поле предназначено для ввода-выбора даты.
Третье поле отображает курс (например USD) 
на указанную дату (по api Центробанка https://www.cbr.ru/development/).


Установка:

```
git clone git@github.com:glaphire/regargo_test_task.git
cd regargo_test_task
composer install
cp .env.example .env
php artisan key:generate
cd public
php -S localhost:5000
```
