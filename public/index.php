<?php
declare(strict_types=1);
require_once __DIR__.'/../src/Service/CatalogRepository.php';
function e(mixed $value):string{return htmlspecialchars((string)$value,ENT_QUOTES|ENT_SUBSTITUTE,'UTF-8');}
$error='';
try{$catalog=(new CatalogRepository())->load(__DIR__.'/../dataset/products.json',__DIR__.'/../dataset/categories.json',__DIR__.'/../dataset/class_requirements.csv');}
catch(Throwable $exception){http_response_code(500);$error=$exception->getMessage();$catalog=new CatalogService([],[],[]);}
$selectedCategory=($_GET['category']??'')===''?null:(int)$_GET['category'];
$products=$catalog->products($selectedCategory);
?><!doctype html><html lang="ru"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Каталог товаров — ТРПО 05</title><link rel="stylesheet" href="/assets/styles.css"></head><body>
<header class="site-header"><div class="brand">Практическая работа №05</div><div class="tag">PHP · ООП</div></header>
<main class="wrap"><section class="hero"><h1>Каталог товаров</h1><p class="muted">Каталог сформирован из объектов Product и Category.</p><strong>Солопов Антон · ЭПБО-01-25</strong></section>
<?php if($error!==''):?><div class="notice error"><?=e($error)?></div><?php endif;?>
<section class="panel"><h2>Фильтр по категории</h2><form method="get" class="form-grid"><div class="field"><label for="category">Категория</label><select id="category" name="category"><option value="">Все категории</option><?php foreach($catalog->categories() as $category):?><option value="<?=$category->id()?>" <?=$selectedCategory===$category->id()?'selected':''?>><?=e($category->name())?></option><?php endforeach;?></select></div><div><button>Применить</button> <a class="btn ghost" href="/">Сбросить</a></div></form></section>
<section class="panel"><h2>Товары</h2><p class="muted">Количество товаров: <?=count($products)?></p><div class="cards"><?php foreach($products as $product):?><article class="card"><h3><?=e($product->name())?></h3><p><?=e($catalog->categoryName($product->categoryId()))?></p><div class="metric"><?=e($product->formattedPrice())?></div></article><?php endforeach;?></div><?php if($products===[]):?><div class="empty">Товары не найдены.</div><?php endif;?></section>
<section class="panel"><h2>Средняя цена</h2><div class="metric"><?=e(number_format($catalog->averagePrice(),2,',',' '))?> ₽</div></section>
</main><footer class="site-footer">Практическая работа №05</footer></body></html>
