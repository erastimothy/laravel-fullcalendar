<!DOCTYPE html>
<html>
<head>
    <title>Laravel Fullcalendar</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <script>
        $(document).ready(function () {
           
          
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
          
        var calendar = $('#calendar').fullCalendar({
                            editable: true,
                            events: "{{ route('events.index') }}",
                            editable: true,
                            eventRender: function (event, element, view) {
                                if (event.allDay === 'true') {
                                        event.allDay = true;
                                } else {
                                        event.allDay = false;
                                }
                            },
                            selectable: true,
                            selectHelper: true,
                            select: function (start, end, allDay) {
                                var title = prompt('Event Title:');
                                if (title) {
                                    var start = $.fullCalendar.formatDate(start, "Y-MM-DD");
                                    var end = $.fullCalendar.formatDate(end, "Y-MM-DD");
                                    $.ajax({
                                        url: "{{ route('events.store') }}",
                                        data: {
                                            title: title,
                                            start: start,
                                            end: end,
                                        },
                                        type: "POST",
                                        success: function (data) {
                                            toastr.success("Event Created Successfully", 'Created');
          
                                            calendar.fullCalendar('renderEvent',
                                                {
                                                    id: data.id,
                                                    title: title,
                                                    start: start,
                                                    end: end,
                                                    allDay: allDay
                                                },true);
          
                                            calendar.fullCalendar('unselect');
                                        }
                                    });
                                }
                            },
                            eventDrop: function (event, delta) {
                                var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD");
                                var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD");
                                console.log(event);
                                $.ajax({
                                    url: "{{ route('events.update',) }}",
                                    data: {
                                        title: event.title,
                                        start: start,
                                        end: end,
                                        id: event.id,
                                    },
                                    type: "PUT",
                                    success: function (response) {
                                        toastr.success("Event Updated Successfully", 'Updated');
                                    }
                                });
                            },
                            eventClick: function (event) {
                                var deleteMsg = confirm("Do you really want to delete?");
                                if (deleteMsg) {
                                    $.ajax({
                                        type: "DELETE",
                                        url: "{{ route('events.destroy') }}",
                                        data: {
                                            id: event.id,
                                        },
                                        success: function (response) {
                                            calendar.fullCalendar('removeEvents', event.id);
                                            toastr.success("Event Deleted Successfully", 'Deleted');
                                        }
                                    });
                                }
                            }
         
                        });
         
        });
         
          
        </script>
</head>
<body>
  
<div class="container">
    <h1>Events</h1>
    <div id='calendar'></div>
</div>
  
</body>
</html>