<?php

namespace Source\Helpers\Classes;

class Debugger
{
    public static function print(mixed $data)
    {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        exit();
    }
}
