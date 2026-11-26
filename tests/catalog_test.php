<?php
declare(strict_types=1);
require_once __DIR__.'/../src/Service/CatalogRepository.php';
function check(bool $ok,string $m):void{if(!$ok)throw new RuntimeException($m);}
$c=(new CatalogRepository())->load(__DIR__.'/../dataset/products.json',__DIR__.'/../dataset/categories.json',__DIR__.'/../dataset/class_requirements.csv');
check(count($c->products())===12,'12 products expected');check(count($c->categories())===3,'3 categories expected');check(count($c->requirements())===6,'6 class requirements expected');check($c->countActive()===10,'10 active products expected');
check(count($c->products(['category'=>'2']))===4,'category filter');check(count($c->products(['min'=>'500','max'=>'1000']))===4,'price range');check(count($c->products(['q'=>'ТОВАР 1']))===4,'case-insensitive search');check(count($c->products(['active'=>true]))===10,'active filter');check($c->categoryName(999)==='Без категории','unknown category');
$bad=false;try{new Product(0,'Ошибка',1.0,1);}catch(InvalidArgumentException){$bad=true;}check($bad,'Product constructor validation');
$bad=false;try{new Category(1,' ');}catch(InvalidArgumentException){$bad=true;}check($bad,'Category constructor validation');
echo "TRPO-05: OK\n";
