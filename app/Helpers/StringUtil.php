<?php
namespace App\Helpers;
use Illuminate\Support\Str;

class StringUtil
{

    public static function strContains(string $string, string $word)
    {
        return strpos($string, $word) !== false;
    }

    public static function ends_with_some(string $string, string ... $suffixes){
        for ($i=0; $i < sizeof($suffixes); $i++) { 
            if(Str::endsWith  ($string, $suffixes[$i])){
                return true;
            }
        }
        return false;
    }
    public static function strContainsSome(string $string, string ... $words)
    {
        for ($i=0; $i < sizeof($words); $i++) { 
            if(Str::contains ($string, $words[$i])){
                return true;
            }
        }
        return false;
    }

    public static function getWordsAfterLastChar(string $word, string $char)
    {
        $res = "";
        for ($i = 0;$i < strlen($word);$i++)
        {
            $res .= $word[$i];
            if ($word[$i] == "\\")
            {
                $res = "";
            }
        }
        return $res;
    }
    public static function isUpperCase($char)
    {

        return $char == strtoupper($char);
    }

    public static function extractCamelCase(string $camelCased)
    {

        $result = "";

        for ($i = 0;$i < strlen($camelCased);$i++)
        {
            $char = $camelCased[$i];
            if (StringUtil::isUpperCase($char))
            {
                $result .= (" ");
            }
            if (0 == $i)
            {
                $result .= strtoupper($char);
            }
            else
            {
                $result .= ($char);
            }

        }

        return $result;
    }
}