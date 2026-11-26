<?php
declare(strict_types=1);
final class CatalogService {
 public function __construct(private array $products,private array $categories){}
 public function categories():array{return $this->categories;}
 public function categoryName(int $id):string{foreach($this->categories as $c)if($c->id()===$id)return $c->name();return 'Без категории';}
 public function countActive():int{return count(array_filter($this->products,fn($p)=>$p->isActive()));}
 public function products(array $f=[]):array{
 $a=array_filter($this->products,function(Product $p)use($f){
 if(!empty($f['active'])&&!$p->isActive())return false;
 if(($f['category']??'')!==''&&$p->categoryId()!==(int)$f['category'])return false;
 if(($f['min']??'')!==''&&$p->price()<(float)$f['min'])return false;
 if(($f['max']??'')!==''&&$p->price()>(float)$f['max'])return false;
 if(($f['q']??'')!==''&&mb_stripos($p->name(),$f['q'])===false)return false;return true;});
 usort($a,fn($x,$y)=>$x->id()<=>$y->id());return array_values($a);}
}