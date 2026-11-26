# Практическая работа №05 — ООП и каталог

**Студент:** Солопов Антон  
**Группа:** ЭПБО-01-25

## Реализовано
Классы Product и Category с конструкторами и методами чтения; CatalogRepository преобразует исходные JSON в объекты; CatalogService выполняет фильтрацию по названию, категории, диапазону цен и активности. Интерфейс не работает с JSON напрямую.

## Запуск
PHP 8.1+ и mbstring: `php -S localhost:8000 -t public`, затем http://localhost:8000.

## Проверка
`php -d zend.assertions=1 -d assert.exception=1 tests/catalog_test.php`

## Структура
`src/` — модели, репозиторий и сервис; `public/index.php` — HTTP и представление; `dataset/` — предоставленные исходные данные; `tests/` — тест сервиса.

Обязательные свойства Product и Category соответствуют `dataset/class_requirements.csv`. Поле `active` дополнительно присутствует в исходном products.json и используется для фильтрации.
