<?php
require_once __DIR__.'/../src/Product.php';require_once __DIR__.'/../src/Category.php';require_once __DIR__.'/../src/CatalogService.php';
$s=new CatalogService([new Product(1,'Товар 1',100,2,true),new Product(2,'Товар 2',200,3,false)],[new Category(2,'Оборудование')]);
assert(count($s->products(['active'=>true]))===1);assert(count($s->products(['min'=>150]))===1);assert($s->categoryName(2)==='Оборудование');echo "OK\n";
