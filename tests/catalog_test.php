<?php
declare(strict_types=1);
require_once __DIR__.'/../src/Service/CatalogRepository.php';
function check(bool $ok,string $message):void{if(!$ok)throw new RuntimeException($message);}
$catalog=(new CatalogRepository())->load(__DIR__.'/../dataset/products.json',__DIR__.'/../dataset/categories.json',__DIR__.'/../dataset/class_requirements.csv');
check(count($catalog->products())===12,'12 товаров загружены');
check(count($catalog->categories())===3,'3 категории загружены');
check(count($catalog->requirements())===6,'Требования к классам загружены');
check(count($catalog->products(2))===4,'Фильтрация по категории');
check(count($catalog->products(999))===0,'Неизвестная категория');
check(abs($catalog->averagePrice()-1192.5)<0.01,'Средняя цена рассчитана');
$invalid=false;try{new Product(0,'Ошибка',1.0,1);}catch(InvalidArgumentException){$invalid=true;}check($invalid,'Проверка конструктора Product');
$invalid=false;try{new Category(1,' ');}catch(InvalidArgumentException){$invalid=true;}check($invalid,'Проверка конструктора Category');
echo "TRPO-05: OK\n";
