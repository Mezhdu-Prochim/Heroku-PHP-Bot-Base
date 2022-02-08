<?php

namespace Core;

use Core\Db;
use Core\InitialFactory;

Abstract Class Factory extends InitialFactory {

	public $id;
	public $location;
	public $type;
	public $locations = [];
	public $inventory = [];

    abstract public function factoryMethod();

    public function operation($value) {
		$this->id = $value;
		//if (isset($this->locations[$this->id])) {
		$this->location = $this->locations[$this->id];
		$this->type = $this->locations[$this->id]['type'];
		$product = $this->factoryMethod();
		$result = $product->operation();
		//} else {
		//	$result = 'Произошла какая-то ошибка';
		//}
		
        return $result;
    }
}