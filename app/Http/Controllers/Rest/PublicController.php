<?php
namespace App\Http\Controllers\Rest;
 
use Illuminate\Http\Request; 

class PublicController extends BaseRestController {

    public function pageCode(Request $request){ 

        $msg = 'UNDER-CONSTRUCTION';
        return $this->webResponse("00", $msg);
    }

}