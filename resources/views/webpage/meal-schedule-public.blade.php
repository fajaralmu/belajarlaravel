@extends('layouts.app')
@section('content') 
<div class="content">
	<h2>Meal Schedule</h2>

	<div id="calendar-wrapper">
		<table id="cal-input-fields" style="width: 100%;"></table>
		<table id="calendarTable" style="width: 100%;"></table>
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
			doLoadEntities("{{$context_path}}/api/public/mealschedule?month="+m+"&year="+y  ,
					{}, function(response) {

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

	</script>
</div> 
@endsection
