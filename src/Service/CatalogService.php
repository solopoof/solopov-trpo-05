<?php
declare(strict_types=1);
require_once __DIR__.'/../Model/Product.php';require_once __DIR__.'/../Model/Category.php';
final class CatalogService {
 public function __construct(private array $products,private array $categories,private array $requirements=[]){}
 public function categories():array{return $this->categories;} public function requirements():array{return $this->requirements;}
 public function countActive():int{return count(array_filter($this->products,fn(Product $p)=>$p->isActive()));}
 public function averagePrice():float{return $this->products===[]?0.0:array_sum(array_map(fn(Product $p)=>$p->price(),$this->products))/count($this->products);}
 public function categoryName(int $id):string{foreach($this->categories as $c)if($c->hasId($id))return $c->name();return 'Без категории';}
 public function products(array $f=[]):array{
  $min=($f['min']??'')===''?null:(float)$f['min'];$max=($f['max']??'')===''?null:(float)$f['max'];$cat=($f['category']??'')===''?null:(int)$f['category'];$q=trim((string)($f['q']??''));$active=(bool)($f['active']??false);
  $items=array_filter($this->products,static function(Product $p)use($min,$max,$cat,$q,$active):bool{if($active&&!$p->isActive())return false;if($cat!==null&&!$p->belongsToCategory($cat))return false;return $p->isWithinPriceRange($min,$max)&&$p->matchesSearch($q);});
  usort($items,fn(Product $a,Product $b)=>$a->id()<=>$b->id());return array_values($items);
 }
}
