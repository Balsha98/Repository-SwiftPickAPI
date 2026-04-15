<?php

namespace Source\Helpers\Classes;

class Encoder
{
    public static function encodeToJSON(string $key, mixed $data)
    {
        // return json_encode([$key => $data]);
        return json_encode($data);
    }

    public static function decodeFromJSON(string $json, bool $isAssoc = true)
    {
        return json_decode($json, $isAssoc);
    }
}
