<?php
namespace App\Helpers;

class StringUtil
{

    public static function strContains(string $string, string $word)
    {
        return strpos($string, $word) !== false;
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

