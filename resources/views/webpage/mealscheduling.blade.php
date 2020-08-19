@extends('layouts.app')
@section('content') 
<div class="content">
	<h2>Time Line</h2>

	<div id="calendar-wrapper">
		<table id="cal-input-fields" style="width: 100%;"></table>
		<table id="calendarTable" style="width: 100%;"></table>
	</div>
	<div style="display: grid; grid-column-gap:5px; grid-row-gap:5px; grid-template-columns: 30% 30%">
		<label>First Order Group Name:</label><select id="groupMembers" class="form-control">
			@foreach ($groupMembers as $groupMember)
			<option value="{{$groupMember->id }}"> {{$groupMember->group->name }}</option>
			@endforeach
		 
		</select>
		<button class="btn btn-secondary btn-sm" onclick="createSchedule()">CREATE
			Schedule For Selected Month</button>
		<button class="btn btn-danger btn-sm" onclick="resetSchedule()">RESET
				Schedule For Selected Month</button>
	</div>
	<script type="text/javascript">
		var scheduledData =  {};
		this.detailFunc = function(d, m, y) {
			console.info("DYNAMIC DETAIL: ", d, m, y);
		};

		this.addFunc = function(d, m, y) {
			console.info("DYNAMIC ADD: ", d, m, y);
		};

		this.fillDateItem = function(d, m, y) {
			//return createHtml("div", "Date: " + d);
			return null;
		};

		this.loadMonth = function(m, y) {
			console.info("MONTH LOADED:", (m+1), "-", y)
			loadScheduleData(m + 1, y);
		}
		
		 
		loadCalendar();
		  
		function loadScheduleData(m, y) {
			if(scheduledData[m+"-"+y]!=null){
				this.fillScheduleData(m, y);
				 
			}else{
			const requestObject = {
				"entity" : "scheduledfoodtaskgroup",
				"filter" : {
					"page" : 0,
					"fieldsFilter" : { "month" : m, "year" : y } 
				}
			};
			doLoadEntities("{{$context_path}}/api/entity/get"  ,
					requestObject, function(response) {

						const entities = response.entities;
						if (entities == null) {
							alert("Server Error!");
							return;
						} 
						scheduledData[m+"-"+y] = entities;
						fillScheduleData(m, y);
					});
			}
		}

		function fillScheduleData(m, y) {
			const currentMonthData = this.scheduledData[m+"-"+y];
			if(!currentMonthData){
				console.log("NO currentMonthData..");
				return;
			}
			for (var i = 0; i < currentMonthData.length; i++) {
				const data = currentMonthData[i];
				const id = "date-"+data.day+"-"+data.month;
				const deteElem = _byId(id);
				// console.info("ID", id);
				if(deteElem)
					deteElem.appendChild(createHtmlTag({
						tagName:"p",
						innerHTML:data.groupMember.group.name,
				}));
			}
		}

/////////////////////////////// Operation ///////////////////////////////

		function getRequestObject(){
			const requestObject = {
				'filter' : { 
					'month' :( MONTH_NOW + 1), 
					'year' : YEAR_NOW
				}
			}
			return requestObject;
		}

		function resetSchedule(){
			if (!confirm("RESET scheduler for: " + (MONTH_NOW + 1) + "/" + YEAR_NOW + "?")) {
				return;
			}
			infoLoading(); 
			postReq("{{$context_path}}/api/admin/resetmealschedule/" , getRequestObject(), function(xhr) {
				infoDone(); 
				if (xhr.data != null && xhr.data.code == "00") {
					alert("OPERATION SUCCESS, please reload to see the change");
				} else {
					alert("FAILED")
				}
			});

		}

		function createSchedule() {
			if (!confirm("CREATE scheduler for: " + (MONTH_NOW + 1) + "/" + YEAR_NOW + "?")) {
				return;
			}
			const beginningID = _byId("groupMembers").value;
			if (!beginningID) {
				alert("beginningID invalid!");
				return;
			}
			infoLoading(); 

			postReq("{{$context_path}}/api/admin/createmealschedule/"  
					+ beginningID, getRequestObject(), function(xhr) {
				infoDone(); 
				if (xhr.data != null && xhr.data.code == "00") {
					alert("OPERATION SUCCESS, please reload to see the change");
				} else {
					alert("FAILED")
				}
			});

		}

	</script>
</div> 
@endsection
