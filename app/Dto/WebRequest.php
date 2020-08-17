<?php 
namespace App\Dto;

class WebRequest {

    public Filter $filter;
    /**
     * entityName
     */
    public string $entity = "";

    public function __construct(){
        $this->filter = new Filter();
    }
}
