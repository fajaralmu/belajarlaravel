<?php 
namespace App\Annotations; 

/** 
 * @Annotation 
 * @Target({"METHOD","PROPERTY"})
 * 
 */
/** @Annotation */  
class FormField
{
    
	 public string $type="FIELD_TYPE_TEXT";

	 public bool $multipleSelect=false;

	 public string $lableName="";

	 public string $className = "";

	 public string $optionItemName="";

	 public array $multiply=[];

	 public bool $emptyAble=true;

	 public array $detailFields=[];

	 public bool $showDetail=false;

	 public string $defaultValue="";

	 public bool $required=false;

	 public array $availableValues=[];

	 public bool $multipleImage=false;

	 public string $foreignKey="";

}
?>