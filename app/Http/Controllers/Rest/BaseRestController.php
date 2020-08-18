<?php


namespace App\Http\Controllers\Rest;

use App\Dto\WebRequest;
use App\Dto\WebResponse;
use App\Helpers\EntityUtil;
use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;

class BaseRestController extends Controller {

    public function __construct()
    {
        // $this->middleware('api');
    }

    public function pageCode(Request $request){

    
    }

    protected function getWebRequest(Request $request){
        return   EntityUtil::arraytoobj(new WebRequest(), $request->json());
    }

    protected function webResponse($code=null, $message=null){
        $response = new WebResponse();

        if(null != $code){
            $response->code = $code;
        }
        if(null!=$message){
            $response->message = $message;
        }
        $statusCode = 200;
        if($code!="00"){
            $statusCode = 500;
        }
        return response(json_encode($this->object_to_array($response)),   $statusCode ); 
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
    
    protected function json_response(WebResponse $response, array $header = null){
         
        if(null == $header ){
            return response( )->json($this->object_to_array($response)); 
        } 
        
        return response(json_encode($this->object_to_array($response)), 200, $header);
    }
}