@extends('layouts.app')
@section('content') 
<div class="content">
	<h2>Time Line</h2>

	<div id="calendar-wrapper">
		<table id="cal-input-fields" style="width: 100%;"></table>
		<table id="calendarTable" style="width: 100%;"></table>
	</div>
	<div>
		First Order Group Name: <select id="groupMembers">
			@foreach ($groupMembers as $groupMember)
			<option value="{{$groupMember->id }}"> {{$groupMember->group->name }}</option>
			@endforeach
		 
		</select>
		<button class="btn btn-secondary" onclick="createSchedule()">Create
			Schedule For Selected Month</button>
	</div>
	<script type="text/javascript">
		var scheduledData = new Array();
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

		function createSchedule() {
			if (!confirm("Create scheduler for: " + (MONTH_NOW + 1) + "/"
					+ YEAR_NOW + "?")) {
				return;
			}
			const beginningGroupMemberId = _byId("groupMembers").value;
			if (null == beginningGroupMemberId) {
				alert("beginningGroupMemberId invalid!");
				return;
			}
			infoLoading();
			var requestObject = {
				'filter' : { 
					'month' :( MONTH_NOW + 1), 
					'year' : YEAR_NOW
				}
			}

			postReq("{{$context_path}}/api/admin/createmealschedule/"  
					+ beginningGroupMemberId, requestObject, function(xhr) {
				infoDone();
				var response = (xhr.data);
				if (response != null && response.code == "00") {
					alert("OPERATION SUCCESS");
				} else {
					alert("FAILED")
				}
			});

		}

		function loadScheduleData(m, y) {
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

						scheduledData = entities;
						fillScheduleData();
					});
		}

		function fillScheduleData() {
			for (var i = 0; i < this.scheduledData.length; i++) {
				const data = scheduledData[i];
				const deteElem = _byId("date-"+data.day+"-"+data.month);
				deteElem.appendChild(createHtmlTag({
					tagName:"p",
					innerHTML:data.groupMember.group.name,
				}));
			}
		}
	</script>
</div> 
@endsection