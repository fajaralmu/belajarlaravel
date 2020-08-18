<?php
namespace App\Helpers;


class FileUtil {
    public static function writeBase64File(string $base64_string, $output_file) {

        // split the string on commas
        // $data[ 0 ] == "data:image/png;base64"
        // $data[ 1 ] == <actual base64 string>
        $data = explode( ',', $base64_string );
        if(sizeof($data) != 2){
            return "";
        }
        $extensionRaw = explode( '/',  $data[0] );
        $extension = explode( ';',  $extensionRaw[1] );

        $output_file .= ".". $extension[0];
        // open the output file for writing
        $ifp = fopen( "img/". $output_file, 'wb' ); 
    
      
    
        // we could add validation here with ensuring count( $data ) > 1
        fwrite( $ifp, base64_decode( $data[ 1 ] ) );
    
        // clean up the file resource
        fclose( $ifp ); 
       
        return $output_file; 
    }
}