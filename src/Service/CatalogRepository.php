<?php
declare(strict_types=1);
require_once __DIR__.'/../Model/Product.php';
require_once __DIR__.'/../Model/Category.php';
require_once __DIR__.'/CatalogService.php';
final class CatalogRepository {
 private function readJson(string $file):array{
  if(!is_file($file)||!is_readable($file))throw new RuntimeException('Файл данных отсутствует: '.basename($file));
  $raw=file_get_contents($file);if($raw===false)throw new RuntimeException('Не удалось прочитать '.basename($file));
  $data=json_decode($raw,true,512,JSON_THROW_ON_ERROR);if(!is_array($data))throw new RuntimeException('Ожидался JSON-массив: '.basename($file));return $data;
 }
 public function load(string $productsFile,string $categoriesFile,string $requirementsFile):CatalogService{
  $categories=array_map(fn($row)=>new Category((int)$row['id'],(string)$row['name']),$this->readJson($categoriesFile));
  $products=array_map(fn($row)=>new Product((int)$row['id'],(string)$row['name'],(float)$row['price'],(int)$row['category_id']),$this->readJson($productsFile));
  return new CatalogService($products,$categories,$this->loadRequirements($requirementsFile));
 }
 public function loadRequirements(string $file):array{
  if(!is_file($file)||!is_readable($file))throw new RuntimeException('Не найден class_requirements.csv.');
  $handle=fopen($file,'rb');if(!$handle)throw new RuntimeException('Не удалось открыть class_requirements.csv.');
  try{$header=fgetcsv($handle,null,';','"','');if(!is_array($header))return [];$header[0]=preg_replace('/^\xEF\xBB\xBF/','',(string)$header[0]);$rows=[];while(($row=fgetcsv($handle,null,';','"',''))!==false){if(count($row)===count($header))$rows[]=array_combine($header,$row);}return $rows;}finally{fclose($handle);}
 }
}
