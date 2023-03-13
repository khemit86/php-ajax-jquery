function editEvent(event) {
	 $('#event-modal input[name="event-index"]').val(event ? event.id : '');
	 $('#event-modal input[name="event-name"]').val(event ? event.name : '');
	 $('#event-modal input[name="event-location"]').val(event ? event.location : '');
	 $('#event-modal input[name="event-start-date"]').datepicker('update', event ? event.startDate : '');
	 $('#event-modal input[name="event-end-date"]').datepicker('update', event ? event.endDate : '');
	 $('#event-modal').modal();
 }
 
 function deleteEvent(event) {
	 var dataSource = $('#calendar').data('calendar').getDataSource();
 
	 for(var i in dataSource) {
		 if(dataSource[i].id == event.id) {
			 dataSource.splice(i, 1);
			 break;
		 }
	 }
	 
	 $('#calendar').data('calendar').setDataSource(dataSource);
 }
 $(function() {
	 var currentYear = new Date().getFullYear();
 
	 $('#calendar').calendar({
		 enableContextMenu: true,
		 enableRangeSelection: true
		 //startYear : 2018
		/*  minDate: new Date('01/01/2018'),
		maxDate: new Date('12/31/2018') */
	 });
 });