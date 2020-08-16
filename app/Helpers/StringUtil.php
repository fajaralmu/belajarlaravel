<?php
namespace App\Helpers;

class StringUtil {
            public static function isUpperCase( $char) { 
                 
                return $char == strtoupper($char);
            }
         
            public static function extractCamelCase( string $camelCased) {
        
                $result = "";
        
                for ($i = 0; $i < strlen($camelCased); $i++) {
                    $char = $camelCased[$i];
                    if (StringUtil::isUpperCase($char)) {
                        $result .= (" ");
                    }
                    if (0 == $i) {
                        $result .= strtoupper($char);
                    } else{
                        $result .= ($char);
                    }
                         
                }
        
                return $result;
            }
}