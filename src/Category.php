<?php
declare(strict_types=1);
final class Category {
 public function __construct(private int $id,private string $name){if($id<1||trim($name)==='')throw new InvalidArgumentException('Некорректная категория');}
 public function id():int{return $this->id;} public function name():string{return $this->name;}
}