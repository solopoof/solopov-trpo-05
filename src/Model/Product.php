<?php
declare(strict_types=1);
final class Product {
 public function __construct(private int $id,private string $name,private float $price,private int $categoryId){
  if($id<1)throw new InvalidArgumentException('ID товара должен быть положительным.');
  if(trim($name)==='')throw new InvalidArgumentException('Название товара не может быть пустым.');
  if(!is_finite($price)||$price<0)throw new InvalidArgumentException('Цена должна быть конечным неотрицательным числом.');
  if($categoryId<1)throw new InvalidArgumentException('ID категории должен быть положительным.');
 }
 public function id():int{return $this->id;}
 public function name():string{return $this->name;}
 public function price():float{return $this->price;}
 public function categoryId():int{return $this->categoryId;}
 public function hasId(int $id):bool{return $this->id===$id;}
 public function belongsToCategory(int $id):bool{return $this->categoryId===$id;}
 public function isWithinPriceRange(?float $min,?float $max):bool{return ($min===null||$this->price>=$min)&&($max===null||$this->price<=$max);}
 public function formattedPrice():string{return number_format($this->price,2,',',' ').' ₽';}
}
