<?php


namespace App\Http\Controllers\Rest;

use App\Dto\WebResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseRestController extends Controller {

    public function pageCode(Request $request){

    
    }

    protected function webResponse($code=null, $message=null){
        $response = new WebResponse();

        if(null != $code){
            $response->code = $code;
        }
        if(null!=$message){
            $response->message = $message;
        }
        return response()->json($this->object_to_array($response)); 
    }

    function object_to_array($data)
    {
    if (is_array($data) || is_object($data))
    {
        $result = array();
        foreach ($data as $key => $value)
        {
            $result[$key] = $this->object_to_array($value);
        }
        return $result;
    }
    return $data;
    }

    protected function json_response(WebResponse $response){
        return response()->json($this->object_to_array($response)); 
    }
}