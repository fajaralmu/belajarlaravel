<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model{

    public function setId($id){
        $this->id = $id;
    }
    
}