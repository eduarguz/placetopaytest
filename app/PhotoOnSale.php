<?php

namespace App;

class PhotoOnSale
{

    static public function price()
    {
        return 29500;
    }

    public function formattedPrice()
    {
        return number_format($this->price(), 0, '', '.');
    }

    static public function src()
    {
        return asset('/img/photo.jpeg');
    }

    static public function description()
    {
        return 'White Snowy Mountain';
    }
}