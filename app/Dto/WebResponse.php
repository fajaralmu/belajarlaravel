<?php 
namespace App\Dto;

use DateTime;
use Illuminate\Support\Facades\Hash;

class WebResponse   {
    public 	$date    ;      
    public string	$code   ="00" ;       
    public string	$message ="success"  ;     
    public array	$entities  ;    
	public object $entitiy   ;      
    public int	$totalData   ;   
    public	$additionalData;  
    public 	Filter  $filter;

    public function __construct(){
        
        // $this->additionalData = Hash::make("123");
        $this->date = date("Y-m-d H:i:s");
    } 

    public static function failed(string $msg){
        $response = new WebResponse();
        $response->code = "01";
        $response->message = $msg;
        return $response;
    }
}