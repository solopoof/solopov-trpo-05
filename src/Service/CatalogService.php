<?php
declare(strict_types=1);
require_once __DIR__.'/../Model/Product.php';
require_once __DIR__.'/../Model/Category.php';

final class CatalogService {
 private array $products=[];
 private array $categories=[];
 private array $requirements=[];

 public function __construct(string $productsFile,string $categoriesFile,string $requirementsFile){
  $this->categories=array_map(fn($row)=>new Category((int)$row['id'],(string)$row['name']),$this->readJson($categoriesFile));
  $this->products=array_map(fn($row)=>new Product((int)$row['id'],(string)$row['name'],(float)$row['price'],(int)$row['category_id']),$this->readJson($productsFile));
  $this->requirements=$this->loadRequirements($requirementsFile);
 }
 private function readJson(string $file):array{
  if(!is_file($file)||!is_readable($file))throw new RuntimeException('Файл данных отсутствует: '.basename($file));
  $raw=file_get_contents($file);
  if($raw===false)throw new RuntimeException('Не удалось прочитать '.basename($file));
  $data=json_decode($raw,true,512,JSON_THROW_ON_ERROR);
  if(!is_array($data))throw new RuntimeException('Ожидался JSON-массив: '.basename($file));
  return $data;
 }
 private function loadRequirements(string $file):array{
  if(!is_file($file)||!is_readable($file))throw new RuntimeException('Не найден class_requirements.csv.');
  $handle=fopen($file,'rb');
  if(!$handle)throw new RuntimeException('Не удалось открыть class_requirements.csv.');
  try{
   $header=fgetcsv($handle,null,';','"','');
   if(!is_array($header))return [];
   $header[0]=preg_replace('/^\xEF\xBB\xBF/','',(string)$header[0]);
   $rows=[];
   while(($row=fgetcsv($handle,null,';','"',''))!==false){
    if(count($row)===count($header))$rows[]=array_combine($header,$row);
   }
   return $rows;
  }finally{fclose($handle);}
 }
 public function categories():array{return $this->categories;}
 public function requirements():array{return $this->requirements;}
 public function averagePrice():float{return $this->products===[]?0.0:array_sum(array_map(fn(Product $p)=>$p->price(),$this->products))/count($this->products);}
 public function categoryName(int $id):string{foreach($this->categories as $category)if($category->hasId($id))return $category->name();return 'Без категории';}
 public function products(?int $categoryId=null):array{
  $items=array_filter($this->products,fn(Product $product)=>$categoryId===null||$product->belongsToCategory($categoryId));
  usort($items,fn(Product $a,Product $b)=>$a->id()<=>$b->id());
  return array_values($items);
 }
}
