<?php

namespace Source\Helpers\Classes;

class Encoder
{
    public static function encodeToJSON(array $data)
    {
        return json_encode($data);
    }

    public static function decodeFromJSON(string $json, bool $isAssoc = true)
    {
        return json_decode($json, $isAssoc);
    }
}
