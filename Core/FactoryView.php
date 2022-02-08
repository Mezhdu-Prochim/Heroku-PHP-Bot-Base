<?php

namespace Core;

Abstract Class FactoryView {

    abstract public function factoryMethod();

    public function getView() {
        $product = $this->factoryMethod();
        $result = $product->getView();

        return $result;
    }

    public function operation() {
        $product = $this->factoryMethod();
        var_dump($product);
//        $result = $product->operationTwo();
//        return $result;
    }
}
