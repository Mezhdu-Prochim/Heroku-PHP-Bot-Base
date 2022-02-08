<?php

namespace Core;

Class Controller extends Factory {
	
    public function factoryMethod()
    {
		$className = "\Models\\".$this->type.'Type';
        return new $className($this->id,$this->location);
    }
}