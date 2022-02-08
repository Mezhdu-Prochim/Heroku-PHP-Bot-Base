<?php

namespace Core\View;
use Core\InterfaceView;

Class ImageView implements InterfaceView {
    public $image;
    public function __construct($name)
    {
        $this->image = $name;
    }

    public function getView()
    {
        return '<img class="tree" src="/tree/img/' . strtolower($this->image) . '/1.png" />';
    }
}