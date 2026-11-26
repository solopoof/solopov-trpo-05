<?php
declare(strict_types=1);
final class Category {
 public function __construct(private int $id,private string $name){if($id<1)throw new InvalidArgumentException('ID категории должен быть положительным.');if(trim($name)==='')throw new InvalidArgumentException('Название категории не может быть пустым.');}
 public function id():int{return $this->id;} public function name():string{return $this->name;}
 public function hasId(int $id):bool{return $this->id===$id;}
}
