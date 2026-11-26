# Практическая работа №05 — PHP ООП и каталог

**Студент:** Солопов Антон  
**Группа:** ЭПБО-01-25  
**Дисциплина:** Технологии разработки программного обеспечения

## Результат
Приложение загружает products.json и categories.json в объекты Product и Category. CatalogService фильтрует товары по названию, категории, диапазону цен и активности, вычисляет число активных товаров и среднюю цену. class_requirements.csv читается репозиторием и отображается в интерфейсе. Модели не содержат HTML.

Product реализует методы предметной области: проверка категории, попадание в диапазон цены, поиск по названию и форматирование цены. Конструкторы отклоняют некорректные значения через InvalidArgumentException.

## Запуск
PHP 8.1+. Дополнительные расширения и библиотеки не нужны.
php -S localhost:8000 -t public
Откройте http://localhost:8000.

## Тесты
php -d zend.assertions=1 -d assert.exception=1 tests/catalog_test.php
Проверяются 12 товаров, 3 категории, 6 требований из CSV, фильтры и ошибки конструкторов.

## Поток данных
products.json + categories.json + class_requirements.csv → CatalogRepository → объекты Product и Category → CatalogService → index.php → HTML-карточки.

src/Model — модели; src/Service/CatalogRepository.php — чтение файлов; src/Service/CatalogService.php — фильтрация и агрегаты; public/index.php — HTTP и HTML; dataset — исходные данные; tests — проверки.

require_once подключает необходимые файлы классов и предотвращает их повторное подключение. При увеличении числа классов список ручных подключений становится сложнее поддерживать.
