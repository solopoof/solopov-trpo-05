# Практическая работа №05 — PHP ООП

**Студент:** Солопов Антон  
**Группа:** ЭПБО-01-25  
**Дисциплина:** Технологии разработки программного обеспечения

## Результат
Приложение формирует каталог из объектов Product и Category на основе products.json и categories.json. Product содержит свойства id, name, price и categoryId согласно class_requirements.csv. CatalogService фильтрует каталог по категории и вычисляет среднюю цену. HTML-карточки формируются отдельно от моделей.

## Запуск
PHP 8.1+. Дополнительные расширения и библиотеки не требуются.

```bash
php -S localhost:8000 -t public
```

Откройте http://localhost:8000.

## Проверка
```bash
php -d zend.assertions=1 -d assert.exception=1 tests/catalog_test.php
```

Проверяются загрузка товаров и категорий, фильтрация по категории, средняя цена и проверка конструкторов.

## Структура
src/Model/ — классы Product и Category.  
src/Service/CatalogRepository.php — загрузка исходных файлов.  
src/Service/CatalogService.php — фильтрация и вычисление средней цены.  
public/index.php — обработка GET и HTML-представление.  
dataset/ — исходные данные.  
tests/ — проверки.
