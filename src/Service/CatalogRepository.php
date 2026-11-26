<?php
declare(strict_types=1);
require_once __DIR__.'/../Model/Product.php';require_once __DIR__.'/../Model/Category.php';require_once __DIR__.'/CatalogService.php';
final class CatalogRepository {
 private function readJson(string $file):array{if(!is_file($file)||!is_readable($file))throw new RuntimeException('Файл данных отсутствует: '.basename($file));$raw=file_get_contents($file);if($raw===false)throw new RuntimeException('Не удалось прочитать '.basename($file));$d=json_decode($raw,true,512,JSON_THROW_ON_ERROR);if(!is_array($d))throw new RuntimeException('Ожидался JSON-массив: '.basename($file));return $d;}
 public function load(string $productsFile,string $categoriesFile,string $requirementsFile):CatalogService{
  $cats=array_map(fn($x)=>new Category((int)$x['id'],(string)$x['name']),$this->readJson($categoriesFile));
  $products=array_map(fn($x)=>new Product((int)$x['id'],(string)$x['name'],(float)$x['price'],(int)$x['category_id'],(bool)($x['active']??true)),$this->readJson($productsFile));
  return new CatalogService($products,$cats,$this->loadRequirements($requirementsFile));
 }
 public function loadRequirements(string $file):array{
  if(!is_file($file)||!is_readable($file))throw new RuntimeException('Не найден class_requirements.csv.');$h=fopen($file,'rb');if(!$h)throw new RuntimeException('Не удалось открыть class_requirements.csv.');
  try{$head=fgetcsv($h,null,';','"','');if(!is_array($head))return [];$head[0]=preg_replace('/^\xEF\xBB\xBF/','',(string)$head[0]);$out=[];while(($r=fgetcsv($h,null,';','"',''))!==false){if(count($r)===count($head))$out[]=array_combine($head,$r);}return $out;}finally{fclose($h);}
 }
}
