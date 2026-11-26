<?php
declare(strict_types=1);
final class CatalogRepository {
 public function load(string $productsFile,string $categoriesFile):CatalogService{
 $read=fn($f)=>json_decode((string)file_get_contents($f),true,512,JSON_THROW_ON_ERROR);
 $cats=array_map(fn($x)=>new Category((int)$x['id'],(string)$x['name']),$read($categoriesFile));
 $products=array_map(fn($x)=>new Product((int)$x['id'],(string)$x['name'],(float)$x['price'],(int)$x['category_id'],(bool)($x['active']??true)),$read($productsFile));
 return new CatalogService($products,$cats);}
}