<?php 
namespace App\Annotations; 

/** 
 * @Annotation 
 * @Target({"METHOD","PROPERTY"})
 * 
 */
class FormField
{
    
	 public string $type;

	 public $multipleImage;

	 public string $lableName;

	 public $availableValues;

	 public $required;

	 public $multiply;

	 public $optionItemName;

	 public $detailFields;

	 public $showDetail;

	 public $emptyAble;

	 public $defaultValue;

	 public $multipleSelect;

	 public string $foreignKey;

}
?>
