 
<div class="modal fade" id="modal-entity-form" tabindex="-1"
	role="dialog" aria-labelledby="Entity Form Modal" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalCenterTitle">{{$entityProperty->alias }}</h5>
				@if($singleRecord == false)
					<button type="button" class="close" data-dismiss="modal"
						aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				@endif
			</div>
			<div class="modal-body" style="height: 400px; overflow: scroll;">
				<div id="entity-form">
					 
					<!-- ///////////////ELEMENTS////////////////// -->
					@foreach ($entityProperty->elements as $element)

						<div id="form_input_{{$element->id }}"
							groupName="{{$element->inputGroupname }}"
							class="entity-input-form {{$element->isGrouped ? 'grouped' : '' }}"
							style="grid-template-columns:  {{$entityProperty->getGridTemplateColumns()}}">
							<div class="entity-input-label">
								<label>{{$element->lableName }}</label>
							</div>
							<div class="entity-input-field">
								 
									@if($element->type == 'FIELD_TYPE_FIXED_LIST')
										<select class="input-field form-control" id="{{$element->id }}"
											 {{$element->required?"required":"" }} 
											identity="{{$element->identity?"true":"false" }}"
											itemValueField="{{$element->optionValueName}}"
											itemNameField="{{$element->optionItemName}}"
											foreignkey="{{$element->foreignKey}}"
											{{$element->multipleSelect?'multiple':'' }}
											>

										</select>
										<script>
											managedEntity["valueField_{{$element->id}}"] = "{{$element->optionValueName}}";
											managedEntity["itemField_{{$element->id}}"] = "{{$element->optionItemName}}";
											var optionJsonString =  {!!$element->jsonList!!};

											fixedListOptionValues["{{$element->id}}"] =  (optionJsonString);
											for (let i = 0; i < fixedListOptionValues["{{$element->id}}"].length; i++) {
												var optionItemName = managedEntity["itemField_{{$element->id}}"];
												var toDisplay; 
												const optionItem = fixedListOptionValues["{{$element->id}}"][i];
												
												if(optionItemName.includes(".")){
													var raw = optionItemName.split(".");
													toDisplay = optionItem[raw[0]][raw[1]];
												}else{
													toDisplay = optionItem["{{$element->optionItemName}}"];
												}
												
												const option = createHtmlTag({
													tagName : 'option',
													value : optionItem["{{$element->optionValueName}}"],
													innerHTML : toDisplay
												});

												_byId("{{$element->id }}").append(
														option);
											}
										</script>
									@elseif($element->type == 'FIELD_TYPE_DYNAMIC_LIST')
										<input onkeyup="loadList(this)" name="{{$element->id }}"
											id="input-{{$element->id }}" class="form-control" type="text" />
										<br />
										<select style="width: 200px" class="input-field form-control"
											id="{{$element->id }}"  {{$element->required ? "required":""}} 
											multiple="multiple" identity="{{$element->identity?"true":"false" }}"
											itemValueField="{{$element->optionValueName}}"
											itemNameField="{{$element->optionItemName}}"
											dynamic-list="true"
											name="{{$element->entityReferenceClass}}"
											foreignkey="{{$element->foreignKey}}"
											 
											>

										</select>
										<script>
											managedEntity["valueField_{{$element->id}}"] = "{{$element->optionValueName}}";
											managedEntity["itemField_{{$element->id}}"] = "{{$element->optionItemName}}";
										</script>
									@elseif($element->type == 'FIELD_TYPE_PLAIN_LIST')
										<select class="input-field form-control" id="{{$element->id }}"
											 {{$element->required ?"required":"" }}
											identity="{{$element->identity?"true":"false" }}" 
											plainlist="true"
											{{$element->multipleSelect?'multiple':'' }}>
											@foreach ($element->plainListValues as $item)
												<option value="{{$item }}">{{$item }}</option>
											@endforeach
											 

										</select>
									@elseif($element->type == 'FIELD_TYPE_TEXTAREA')
										<textarea class="input-field form-control" id="{{$element->id }}"
												type="textarea" {{$element->required?'required':'' }}
												identity="{{$element->identity?"true":"false" }}">
										</textarea>
									@elseif($element->showDetail)
										<input detailfields="{{$element->detailFields}}"
											showdetail="true" class="input-field" id="{{$element->id }}"
											type="hidden" name="{{$element->optionItemName}}"
											disabled="disabled" />

										<button id="btn-detail-{{$element->id }}" class="btn btn-info"
											onclick="showDetail('{{$element->id }}','{{$element->optionItemName}}' )">Detail</button>
									@elseif($element->type=='FIELD_TYPE_IMAGE' && $element->multiple == false)
										<input class="input-field form-control" id="{{$element->id }}"
											type="file" {{$element->required?'required':'' }}
											identity="{{$element->identity?"true":"false" }}" />

										<button id="{{$element->id }}-file-ok-btn"
											class="btn btn-primary btn-sm"
											onclick="addImagesData('{{$element->id}}')">ok</button>

										<button id="{{$element->id }}-file-cancel-btn"
											class="btn btn-warning btn-sm"
											onclick="cancelImagesData('{{$element->id}}')">cancel</button>
										<div>
											<img id="{{$element->id }}-display" width="50" height="50" />
										</div>
									@elseif($element->type=='FIELD_TYPE_IMAGE' && $element->multiple == true)
										<div id="{{$element->id }}" name="input-list" class="input-field">
											<div id="{{$element->id }}-0-input-item"
												class="{{$element->id }}-input-item">

												<input class="input-file" id="{{$element->id }}-0" type="file"
													{{$element->required?'required':'' }}
													identity="{{$element->identity?"true":"false" }}" />

												<button id="{{$element->id }}-0-file-ok-btn "
													class="btn btn-primary btn-sm"
													onclick="addImagesData('{{$element->id}}-0')">ok</button>

												<button id="{{$element->id }}-0-file-cancel-btn"
													class="btn btn-warning btn-sm"
													onclick="cancelImagesData('{{$element->id}}-0')">cancel</button>

												<button id="{{$element->id }}-0-remove-list"
													class="btn btn-danger btn-sm"
													onclick="removeImageList('{{$element->id }}-0')">Remove</button>

												<div>
													<img id="{{$element->id }}-0-display" width="50" height="50" />
												</div>
											</div>
										</div>
										<button id="{{$element->id }}-add-list"
											onclick="addImageList('{{$element->id }}')">Add</button>
									@elseif($element->identity )
										<input class="input-field form-control" disabled="disabled"
											id="{{$element->id }}" type="text"
											{{$element->required?'required':'' }}
											identity="{{$element->identity?"true":"false" }}" />
									@else 
										<input class="input-field form-control" id="{{$element->id }}"
											type="{{$element->type }}"{{$element->required?'required':'' }}
											identity="{{$element->identity?"true":"false" }}" />
									@endif
								 
							</div>
						</div>
					@endforeach
				</div>

				<!-- </div> -->
			</div>
			<div class="modal-footer">
				@if($entityProperty->editable == true )
					<button id="btn-submit" class="btn btn-primary">Save
						Changes</button>
						@if($singleRecord == false )
						<button class="btn" id="btn-clear">Clear</button>
						@endif
				@endif
				@if($singleRecord == false)
					<button type="button" class="btn btn-secondary"
						data-dismiss="modal">Close</button>
				@endif
				@if($singleRecord == true)
					<a role="button" class="btn btn-secondary"
						href="{{$context_path}}/admin/home"  >Back</a>
				@endif
			</div>
		</div>
	</div>
</div>
<script>
	const groupedInputs = getGroupedInputs();
	const entityForm = _byId('entity-form');
	var groupNames = "{{$entityProperty->groupNames}}";
	
	function arrangeInputs() {
		if(!groupedInputs) return;
		
		entityForm.innerHTML = "";
		const groupNameArray = groupNames.split(",");
		for (var i = 0; i < groupNameArray.length; i++) {
			const groupName = groupNameArray[i];
			
			console.debug("Now group name: ", groupName);
			
			const groupHeader = getGroupName(i+1, groupName);
			const elements =  getElementsByGroupName(groupName);
			const sectionContent = createHtmlTag({
				tagName:'div',
				id: 'section-'+groupName,
				class : 'form-section',
				ch1: groupHeader, 
				style: {
					padding: '5px',
					margin: '5px', 
				}
			})
			
			console.debug("Elements length: ", elements.length);
			for (var e= 0; e < elements.length; e++) {
				sectionContent.appendChild(elements[e]);
			}
			//appendElementsArray(sectionContent, elements);
			entityForm.appendChild(sectionContent);
			
		}
	}
	
	function getElementsByGroupName(groupName){
		const result = new Array();
		
		for (var i = 0; i < groupedInputs.length; i++) {
			const input = (groupedInputs[i]);
			if(input.getAttribute('groupName') == groupName){
				result.push(input);
			}
		}
		
		return result;
	}
	
	function getGroupedInputs(){
		const inputs = document.getElementsByClassName('grouped');
		const result = new Array();
		if(null == inputs || inputs.length == 0){ return null; }
		
		for (var i = 0; i < inputs.length; i++) {
			const cloned = inputs[i].cloneNode();
			cloned.innerHTML = inputs[i].innerHTML;
			result.push(cloned);
		}
		return result;
	} 
	
	function getSectionBordersCount(){
		try{
			return document.getElementsByClassName("section-border").length;
		}catch (e) {
			return 0; 
		}
	}
	 
	
	function getGroupName(section, groupName){
		const h3 = createHtmlTag({
			tagName: 'h3',
			innerHTML: section + '  ' + groupName,
			class: 'section-border'
		});
		return h3;
	}

	if (groupedInputs && groupedInputs.length > 1 ) {
		arrangeInputs();
	}
</script>