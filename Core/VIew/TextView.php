<?php

namespace Core\View;
use Core\InterfaceView;

Class TextView implements InterfaceView {
    public function operation()
    {
        return '<span style="font-size: 40px">@</span>';
    }
}