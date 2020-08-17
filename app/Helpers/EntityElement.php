<?php
namespace App\Helpers;

use App\Annotations\FormField;
use phpDocumentor\Reflection\Types\Self_;
use ReflectionProperty;
use ReflectionType;

class EntityElement {
     

	public   bool $ignoreBaseField; //const
	public   bool $isGrouped; //const
	public ReflectionProperty $field;

	public string $id= "";
	public string $type= "";
	public string $className= "";
	public string $lableName= "";
	public string $jsonList= "";
	public string $optionItemName= "";
	public string $optionValueName= "";
	public string $entityReferenceName= "";
	public string $entityReferenceClass= "";

	public string $detailFields= "";
    public string $inputGroupname= "";
    
	public array $defaultValues = [];
	public array $plainListValues = [];
	public array $options = []; //list of baseEntity

	public bool $identity= false;
	public bool $required= false;
	public bool $idField= false;
	public bool $skipBaseField= false;
	public bool $hasJoinColumn= false;
	public bool $multiple= false;
	public bool $showDetail= false;
	public bool $detailField= false;
	public bool $multipleSelect= false;

    public EntityProperty $entityProperty;
    // Map<string, List>
	public array $additionalMap = [];

	public FormField $formField;
	public /*BaseField*/ $baseField;

//	public static void main(string[] args) {
//		string json = "[{\\\"serialVersionUID\\\":\\\"4969863194918869183\\\",\\\"name\\\":\\\"Kebersihan\\\",\\\"description\\\":\\\"1111111\\t\\t\\t\\t\\t\\\",\\\"serialVersionUID\\\":\\\"-8161890497812023383\\\",\\\"id\\\":1,\\\"color\\\":null,\\\"fontColor\\\":null,\\\"createdDate\\\":\\\"2020-05-14 21:06:03->0\\\",\\\"modifiedDate\\\":\\\"2020-05-14 21:06:03->0\\\",\\\"deleted\\\":\\\"false\\\"},{\\\"serialVersionUID\\\":\\\"4969863194918869183\\\",\\\"name\\\":\\\"Mukafaah\\\",\\\"description\\\":\\\"dfdffd\\\",\\\"serialVersionUID\\\":\\\"-8161890497812023383\\\",\\\"id\\\":2,\\\"color\\\":\\\"#000000\\\",\\\"fontColor\\\":\\\"#000000\\\",\\\"createdDate\\\":\\\"2020-05-12 21:16:58->0\\\",\\\"modifiedDate\\\":\\\"2020-05-12 21:16:58->0\\\",\\\"deleted\\\":\\\"false\\\"},{\\\"serialVersionUID\\\":\\\"4969863194918869183\\\",\\\"name\\\":\\\"Alat Tulis\\\",\\\"description\\\":\\\"alat tulis kantor\\t\\t\\t\\t\\t\\t\\\",\\\"serialVersionUID\\\":\\\"-8161890497812023383\\\",\\\"id\\\":3,\\\"color\\\":null,\\\"fontColor\\\":null,\\\"createdDate\\\":\\\"2020-05-12 21:56:36->0\\\",\\\"modifiedDate\\\":\\\"2020-05-12 21:56:36->0\\\",\\\"deleted\\\":\\\"false\\\"}]";
//		System->out->println(json->replace("\\t", ""));
//	}

    public function __construct()
    {
       
    }

	public static function construct1(ReflectionProperty $field, EntityProperty $entityProperty) {
        $obj = new self();
        $obj->field = $field;
		$obj->ignoreBaseField = $entityProperty->ignoreBaseField;
		$obj->entityProperty = $entityProperty;
		$obj->isGrouped = $entityProperty->isQuestionare;
        if($obj->init()){
            return $obj;
        }
        return null;
		
	}

	public static function construct2(ReflectionProperty $field, EntityProperty $entityProperty, array $additionalMap) {
        $obj = new self();
        $obj->field = $field;
        $obj->ignoreBaseField = $entityProperty->ignoreBaseField ;
        $obj->entityProperty = $entityProperty;
        $obj->additionalMap = $additionalMap;
        $obj->isGrouped = $entityProperty->isQuestionare ;
        if($obj->init()){
            return $obj;
        }
        return null;
	}

	private function init() {
        $formField = EntityUtil::getPropertyAnnotation($this->field,  FormField::class);
        if(is_null($formField)){
            return false;
        }

        $this->formField = $formField;
		// $this->baseField = field->getAnnotation(BaseField->class);

		$this->idField = $this->field->getName() == "id";
		$this->skipBaseField = false;//!idField && (baseField != null && ignoreBaseField);

		$this->identity = $this->idField;
        $this->hasJoinColumn = $this->formField->foreignKey!="" && $this->formField->foreignKey!=null;
        
        $this->checkIfGroupedInput();
        return true;
	}

	public function getJsonListstring(bool $removeBeginningAndEndIndex) {
	 
			$jsonstringified = trim( json_encode($this->jsonList));
			 
			// if ($removeBeginningAndEndIndex) {
            //     $stringBuilder ="";
			// 	$stringBuilder = $jsonstringified;
			// 	$stringBuilder[0]= ' ';
			// 	$stringBuilder[strlen($jsonstringified) - 1]=' ';
			// 	$jsonstringified = trim($stringBuilder);
			// 	// log->info("jsonstringified: {}", jsonstringified);
			// }
			$jsonstringified = str_replace($jsonstringified,"\\t", "");
			$jsonstringified = str_replace($jsonstringified,"\\r", "");
			$jsonstringified = str_replace($jsonstringified,"\\n", "");
			// log->info("RETURN jsonstringified: {}", jsonstringified);
			return $this->jsonList;
		   
	}

	private function checkIfGroupedInput() {

		if ($this->isGrouped) {
			// AdditionalQuestionField annotation = field->getAnnotation(AdditionalQuestionField->class);
			// inputGroupname = annotation != null ? annotation->value() : AdditionalQuestionField->DEFAULT_GROUP_NAME;
		}
	}

	public function build()  {
		$result = $this->doBuild();
        unset($this->entityProperty);
        
        $this->normalizeFieldType();

		return $result;
    }
    
    private function normalizeFieldType(){
        //setting field type so can be read by browser
	    switch ($this->type){
        case "FIELD_TYPE_TEXT":
            $this->type = "text";
            break;
        case "FIELD_TYPE_NUMBER":
            $this->type= "number";
            break;
        case "FIELD_TYPE_COLOR":
            $this->type = "color";
            break;
        case "FIELD_TYPE_DATE":
            $this->type = "date";
            break;
        case "FIELD_TYPE_IMAGE":
            // $this->type = "file";
            break;
        }
    }

	private function doBuild()  {

		$formFieldIsNullOrSkip = ($this->formField == null || $this->skipBaseField);
		if ($formFieldIsNullOrSkip) {
			return false;
		}

		$lableName = $this->formField->lableName==("") ? $this->field->getName() : $this->formField->lableName;
        $determinedFieldType = $this->determineFieldType(); 
        
			$this->checkFieldType($determinedFieldType);
            $hasJoinColumn = $this->formField->foreignKey!=null && $this->formField->foreignKey!="";
            //FIXME
			$collectionOfBaseEntity = false;// CollectionUtil->isCollectionOfBaseEntity($field);

			if ($hasJoinColumn || $collectionOfBaseEntity) {
				$this->processJoinColumn($determinedFieldType);
			}

			$this->checkDetailField(); 
			$this->lableName=(StringUtil::extractCamelCase($lableName));
			$this->type = ($determinedFieldType );
			
			$this->id=($this->field->getName());
			$this->identity=($this->idField);
			$this->required=($this->formField->required );
			$this->multiple=($this->formField->multipleImage );
			$this->className=($this->field->getDeclaringClass()->getShortName());
			$this->showDetail=($this->formField->showDetail);
			
	 
		return true;
	}

	private function checkDetailField() {

		if (!is_null($this->formField->detailFields) && sizeof($this->formField->detailFields) > 0) {
			$this->detailFields = join("~", $this->formField->detailFields);
		}
		if ($this->formField->showDetail) {
			$this->optionItemName=($this->formField->optionItemName);
			$this->detailField=(true);
		}
	}

	private function checkFieldType(string $fieldType)  {

		switch ($fieldType) {
		case "FIELD_TYPE_IMAGE":
			$this->processImageType();
			break;
		case "FIELD_TYPE_CURRENCY":
			$this->processCurrencyType();
			break;
		case "FIELD_TYPE_DATE":
			$this->processDateType();
			break;
		case "FIELD_TYPE_PLAIN_LIST":
			$this->processPlainListType();
			break;
		case "FIELD_TYPE_FIXED_LIST":
			if($this->formField->multipleSelect) {
				$this->processMultipleSelectElements();
			}
			break;
		default:
			break;

		}

	}
	
	private function processMultipleSelectElements() {
		array_push($this->entityProperty->multipleSelectElements, $this->field->getName());
	}

	private function processCurrencyType() {
		array_push($this->entityProperty->currencyElements, $this->field->getName());
	}

	private function processImageType() {
		array_push($this->entityProperty->imageElements, $this->field->getName());
	}

	private function processDateType() {
		array_push($this->entityProperty->dateElements,$this->field->getName());
	}

	private function processPlainListType()   {

		$availableValues = $this->formField->availableValues;
		$arrayOfObject = $availableValues;// CollectionUtil->toObjectArray(availableValues);

		if (!is_null($availableValues) && sizeof($availableValues) > 0) {
			$this->plainListValues = $arrayOfObject;//

		// } else if ($this->field->getType()->isEnum()) {
		// 	Object[] enumConstants = field->getType()->getEnumConstants();
		// 	setPlainListValues(Arrays->asList(enumConstants));

		} else {
			// log->error("Ivalid element: {}", field->getName());
			// throw new Exception("Invalid Element");
		}
	}

	private function determineFieldType() {

		$fieldType = "FIELD_TYPE_TEXT";

		// if (EntityUtil->isNumericField(field)) {
		// 	fieldType = FieldType->FIELD_TYPE_NUMBER;

        // } else
        //  if (field->getType()->equals(Date->class) && field->getAnnotation(JsonFormat->class) == null) {
		// 	fieldType = FieldType->FIELD_TYPE_DATE;

        // } else 
        if ($this->idField) {
			$fieldType = "FIELD_TYPE_HIDDEN";
		} else {
			$fieldType = $this->formField->type;
		}
		return $fieldType;
	}

	private function processJoinColumn($fieldType)   {
		out("field {} of {} is join column, type: {}", $this->field->getName(),$this-> field->getDeclaringClass(), $fieldType);
        $referenceEntityClass = new ReflectionType();
		$referenceEntityClass = $this->field->getType();
		// Field referenceEntityIdField = EntityUtil->getIdFieldOfAnObject(field);

		// if (referenceEntityIdField == null) {
		// 	throw new Exception("ID Field Not Found");
		// }
	
		if ($fieldType=="FIELD_TYPE_FIXED_LIST" && $this->additionalMap != null && array_has($this->additionalMap,$this->field->getName() )) {
			
			$referenceEntityList = $this->additionalMap[$this->field->getName()];
			if (null == $referenceEntityList || sizeof($referenceEntityList ) == 0) {  
                out("null == referenceEntityList");
                return;
			}
			out("Additional map with key: {} -> Length: {}", $this->field->getName(), sizeof($referenceEntityList ));
			if ($referenceEntityList != null) {
				
				$this->options=($referenceEntityList); 
				$this->jsonList=(json_encode($referenceEntityList));
				 
			}

		} else if ($fieldType=="FIELD_TYPE_DYNAMIC_LIST") {
			$className = $referenceEntityClass->getName();
			$className = StringUtil::getWordsAfterLastChar($className, "\\");
			$this->entityReferenceClass = strtolower($className) ;
			
		}
		// dd($this->entityReferenceClass);
        //DEFAULT IS ID
		$this->optionValueName=("id");
		$this->multipleSelect=($this->formField->multipleSelect);
		$this->optionItemName=($this->formField->optionItemName);
	}

}