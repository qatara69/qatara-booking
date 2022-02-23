@extends('layouts.admin')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('website/plugins/fullcalendar/main.min.css') }}">
    <link rel="stylesheet" href="{{ asset('website/plugins/fullcalendar-daygrid/main.min.css') }}">
    <link rel="stylesheet" href="{{ asset('website/plugins/fullcalendar-timegrid/main.min.css') }}">
    <link rel="stylesheet" href="{{ asset('website/plugins/fullcalendar-bootstrap/main.min.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('website/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}" /> --}}
    <link rel="stylesheet" href="{{ asset('website/plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('website/plugins/chart.js/Chart.min.css') }}">
    <style type="text/css">
        /* html, body {
            overflow: hidden;
        } */
        label {
            font-weight: bold;
        }
        .fc-content:hover {
            cursor: pointer;
        }
        .fc-button {
            padding: .25rem .5rem;
            font-size: .875rem;
            line-height: 1.5;
            border-radius: .2rem;
        }

        .fc-dayGrid-view .fc-body .fc-row {
            min-height: 6rem !important
        }

        .fc-day.fc-widget-content.fc-today {
            background-color: #007bff4a
        }
        .fc-header-toolbar {
            /*
            the calendar will be butting up against the edges,
            but let's scoot in the header's buttons
            */
            padding-top: 1em;
            padding-left: 1em;
            padding-right: 1em;
        }
        /*.fc-toolbar.fc-header-toolbar {
            margin-bottom: 0;
        }*/
        /* .calendar-container {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
          } */

    </style>
@endsection
@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    Dashboard
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3>{{ $pending_bookings ?? '0' }}</h3>
                                    <p>Pending Bookings</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-calendar-minus"></i>
                                </div>
                                <a href="{{ route('admin.bookings.index', ['filter' => '1', 'booking_status'=>['pending']]) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-primary">
                                <div class="inner">
                                    <h3>{{ $confirmed_bookings ?? '0' }}</h3>
                                    <p>Confirmed Bookings</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-calendar-check"></i>
                                </div>
                                <a href="{{ route('admin.bookings.index', ['filter' => '1', 'booking_status'=>['confirmed']]) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ $checked_in_bookings ?? '0' }}</h3>
                                    <p>Checked In Bookings</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-bed"></i>
                                </div>
                                <a href="{{ route('admin.bookings.index', ['filter' => '1', 'booking_status'=>['checked in']]) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>{{ $unpaid_bookings ?? '0' }}</h3>
                                    <p>Unpaid Bookings</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-ban"></i>
                                </div>
                                <a href="{{ route('admin.bookings.index', ['filter' => '1', 'payment_status'=>['unpaid']]) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Bookings Chart
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            {!! $bookingsChart->container() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Bookings
                </div>
                <div class="card-body">
                    <div class="calendar-container">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    {{-- <script src="{{ asset('website/plugins/moment/moment-with-locales.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('website/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.js') }}"></script> --}}
    <script src="{{ asset('website/plugins/daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset('website/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('website/plugins/fullcalendar/main.min.js') }}"></script>
    <script src="{{ asset('website/plugins/fullcalendar-daygrid/main.min.js') }}"></script>
    <script src="{{ asset('website/plugins/fullcalendar-timegrid/main.min.js') }}"></script>
    <script src="{{ asset('website/plugins/fullcalendar-interaction/main.min.js') }}"></script>
    <script src="{{ asset('website/plugins/fullcalendar-bootstrap/main.min.js') }}"></script>
    <script src="{{ asset('website/plugins/chart.js/Chart.bundle.min.js') }}"></script>
    {!! $bookingsChart->script() !!}
    <script>
        $(function () {
            /* $(document).on('click', '[data-dismiss="modal-ajax"]', function() {
                // closeAllModals()
                $('.modal').modal('hide')
                $('.modal-backdrop').fadeOut(250, function() {
                    $('.modal-backdrop').remove()
                })
                $('body').removeClass('modal-open').css('padding-right', '0px');
                $('#modalAjax').html('')
                // removeLocationHash()
            }) */
            /**
             * Initialize calendar
             */
            var Calendar = FullCalendar.Calendar;
            var calendarEl = document.getElementById('calendar');
            var calendar = new Calendar(calendarEl, {
                plugins: [ 'bootstrap', 'interaction', 'dayGrid', 'timeGrid' ],
                defaultView: 'dayGridMonth',
                height: 'parent',
                header    : {
                    left  : 'title',
                    // center: 'dayGridMonth,timeGridWeek,timeGridDay',
                    right : 'prev,next today'
                },
                eventLimit: true, // allow "more" link when too many events
                views: {
                    timeGrid: {
                        eventLimit: 6 // adjust to 6 only for timeGridWeek/timeGridDay
                    },
                },
                selectable: true,
                dateClick: function(info) {
                    var d = new Date();
                    dateNow = d.getFullYear()+'/'+(d.getMonth()+1)+'/'+d.getDate();
                    if(new Date(info.dateStr) >= new Date(dateNow))
                    $.ajax({
                        type: 'GET',
                        url: '{{ route('client_bookings.create') }}',
                        data: {
                            book_date: info.dateStr
                        },
                        success: function(data){
                            $('.modal-backdrop').remove();
                            $('#modalAjax').html(data.modal_content);
                            $('#addBooking').modal('show');
                            // $('#loader').hide();
                            $('.select2').select2();
                        },
                        error: function(xhr, ajaxOptions, thrownError){
                            ajax_error(xhr, ajaxOptions, thrownError)
                            // removeLocationHash()
                            $('#loader').hide();
                        }
                    })
                    // change the day's background color just for fun
                    // info.dayEl.style.backgroundColor = 'red';
                },
                eventClick: function(info) {
                    var eventObj = info.event;
                    // $('#showbooking').modal('show');
                    // $('#bookingDetails').load(eventObj.extendedProps.dataHref);
                    // $('#formAction').attr('action', eventObj.extendedProps.formAction);
                    $('#loader').show();
                    var href = eventObj.extendedProps.dataHref;
                    var target = eventObj.extendedProps.dataTarget;
                    /* var data = {};
                    if($(this).data('form') != null){
                        var form = $(this).data('form').split(';');
                        for (var i = 0; i < form.length; i++) {
                            var form_data = form[i].split(':');
                            for(var j = 1; j < form_data.length; j++){
                                data[form_data[j-1]] = form_data[j];
                            }
                        }
                    } */
                    window.location.href = href
                    $.ajax({
                        type: 'GET',
                        url: href,
                        // data: data,
                        success: function(data){
                            $('.modal-backdrop').remove()
                            $('#modalAjax').html(data.modal_content)
                            $(target).modal('show')
                            // $('#loader').hide();
                        },
                        error: function(xhr, ajaxOptions, thrownError){
                            ajax_error(xhr, ajaxOptions, thrownError)
                            removeLocationHash()
                            // $('#loader').hide();
                        }
                    })
                    
                    // alert('Clicked ' + eventObj.extendedProps.toggle);
                },
                /*eventRender: function(info) {
                    var tooltip = new Tooltip(info.el, {
                      title: info.event.extendedProps.description,
                      placement: 'top',
                      trigger: 'hover',
                      container: 'body'
                    });
                },*/
                /*eventRender: function (event, element) {
                    var tooltip = event.Description;
                    $(element).attr("data-original-title", tooltip);
                    $(element).tooltip({
                         container: "body"
                     })
                },*/
                /* eventTimeFormat: {
                    hour           : 'numeric',
                    minute         : '2-digit',
                    meridiem       : 'short',
                }, */
                displayEventTime: false,
                events: [
                @foreach ($bookings as $booking)
                    {
                        @if($booking->user_id == Auth::user()->id)
                        title          : '{{ $booking->client->last_name }}, {{ $booking->client->first_name }}',
                        @else
                        title          : '{{ $booking->room->name }}',
                        @endif
                        description    : 'description for All Day Event',
                        start          : '{{ $booking->booking_date_from }}',
                        end            : '{{ date("Y-m-d", strtotime($booking->booking_date_to)) }} 24:00:00',
                        dataTarget     : '#showBooking',
                        dataHref       : "{{ route('admin.bookings.show', $booking->id) }}",
                        allDay         : true,
                        @if($booking->booking_status == 'pending')
                        backgroundColor: '#ffc107', //color: warning
                        borderColor    : '#ffc107', //color: warning
                        @elseif($booking->booking_status == 'confirmed')
                        backgroundColor: '#007bff', //color: primary
                        borderColor    : '#007bff', //color: primary
                        textColor      : '#fff',
                        @elseif($booking->booking_status == 'checked in')
                        backgroundColor: '#28a745', //color: success
                        borderColor    : '#28a745', //color: success
                        textColor      : '#fff',
                        @elseif($booking->booking_status == 'canceled' || $booking->booking_status == 'expired' || $booking->booking_status == 'decline')
                        backgroundColor: '#dc3545', //color: danger
                        borderColor    : '#dc3545', //color: danger
                        textColor      : '#fff',
                        @endif
                    },
                @endforeach
                ]
                // editable  : true,
            });
            calendar.render();
            // $('#calendar').fullCalendar()
        });
    </script> 
@endsection
