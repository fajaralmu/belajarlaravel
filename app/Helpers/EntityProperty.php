<?php
namespace App\Helpers; 

class EntityProperty {

    
	public string $groupNames= "";
	public string $entityName= "";
	public string $alias= "";
	public string $fieldNames= "";
	public string $idField= "";
	public string $detailFieldName= "";
	

	public string $imageElementsJson= "";
	public string $dateElementsJson= "";
	public string $multipleSelectElementsJson= "";
	public string $currencyElementsJson= "";

	public int $formInputColumn = 2;
	
	public bool $editable = true; 
	public bool $withDetail = false; 
	
	public array $dateElements = array(); 
	public array $imageElements = array(); 
	public array $currencyElements = array(); 
	public array $multipleSelectElements = array();
	public array $elements = array();
	public array $fieldNameList = array();

	public bool $ignoreBaseField  = false;
	public bool $isQuestionare = false;

	public function setElementJsonList() {

		$this->dateElementsJson = json_encode($this->dateElements);
		$this->imageElementsJson = json_encode($this->imageElements);
		$this->currencyElementsJson = json_encode($this->currencyElements);
		$this->multipleSelectElementsJson = json_encode($this->multipleSelectElements);
	}

	public function removeElements(string... $fieldNames) {
		if ($this->elements == null)
			return;
		  for (  $i = 0; $i < sizeof($fieldNames); $i++) {
            $fieldName = $fieldNames[$i];
            for (  $j = 0; $j < sizeof($this->fieldNameList); $j++)  {
                $fName = $this->fieldNameList[$j];
				if ($fieldName == ($fName)) {
                     
                    array_splice($this->fieldNameList, $j, 1);
                    break; 
				}
            }
            for (  $j = 0; $j < sizeof($this->elements); $j++)  {
			    $entityElement = $this->elements[$j];
				if ($entityElement->id ==  $fieldName) {
					array_splice($this->elements, $j, 1);
                    break;
				}
			}
		}
		$this->fieldNames = json_encode($this->fieldNameList);
	}

	public function setGroupNames(array $groupNamesArray) {
		$removedIndex = 0;
		for ($i = 0; $i < sizeof($groupNamesArray); $i++) {
			if ($groupNamesArray[$i] ==  "DEFAULT_GROUP_NAME") {
				$removedIndex = $i;
			}
		}
		$groupNamesArray = array_splice($groupNamesArray, $removedIndex, 1);
		$this->groupNames =  join(",", $groupNamesArray);
		$this->groupNames += ("," + "DEFAULT_GROUP_NAME");
	}

//	static function main(string[] args) {
//		args =new string[] {"OO", "ff", "fff22"};
//		for (int i = 0; i < args.length; i++) {
//			if(args[i] == "OO")
//		}
//	}

	public function getGridTemplateColumns() {
		if ($this->formInputColumn == 2) {
			return "20% 70%";
		}
		return str_repeat( "auto ", $this->formInputColumn);
	}

	public function determineIdField() {
		if (null == $this->elements) {
			out("Entity ELements is NULL");
			return;
		}
		foreach ($this->elements as $entityElement) {
			if ($entityElement->idField  && $this->idField  == null) {
				$this->idField=($entityElement->id);
			}
		}
	}
}