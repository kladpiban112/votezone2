$(function(){

    $('#calendar').fullCalendar({
        header: {
            // left: 'prev,next today',  //  prevYear nextYea
            // center: 'title',
            // right: 'month,agendaWeek,agendaDay',
            // right: 'month',
        },  
        buttonIcons:{
            prev: 'left-single-arrow',
            next: 'right-single-arrow',
            prevYear: 'left-double-arrow',
            nextYear: 'right-double-arrow'         
        },       

        events: {
            url: 'views/ajax/event-data.php?t='+ (Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15)),
            error: function() {

            }
        },
        eventClick: function(event) {
            if (event.url) {
                window.open(event.url, "_blank");
                return false;
            }
        },    
        eventLimit:true,
//        hiddenDays: [ 2, 4 ],
        lang: 'th',
        dayClick: function() {
//            alert('a day has been clicked!');
//            var view = $('#calendar').fullCalendar('getView');
//            alert("The view's title is " + view.title);
        }        
    });
  
    
});