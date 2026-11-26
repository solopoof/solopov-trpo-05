<?php
declare(strict_types=1);
require_once __DIR__.'/../Model/Product.php';
require_once __DIR__.'/../Model/Category.php';
final class CatalogService {
 public function __construct(private array $products,private array $categories,private array $requirements=[]){}
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
