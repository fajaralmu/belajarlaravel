<%@ page language="java" contentType="text/html; charset=ISO-8859-1"
	pageEncoding="ISO-8859-1"%>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core"%>
<%@ taglib prefix="form" uri="http://www.springframework.org/tags/form"%>
<%@ taglib prefix="spring" uri="http://www.springframework.org/tags"%><!DOCTYPE html>
<div class="content">
	<h2>Time Line</h2>

	<div id="calendar-wrapper">
		<table id="cal-input-fields" style="width: 100%;"></table>
		<table id="calendarTable" style="width: 100%;"></table>
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

		function loadScheduleData(m, y) {
			const requestObject = { };
			doLoadEntities("<spring:url value="/api/public/mealschedule" />?month="+m+"&year="+y,
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

