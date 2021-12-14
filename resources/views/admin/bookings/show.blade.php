@extends('layouts.admin')
@section('styles')
    <style>
        .form-group {
            margin-bottom: 0px
        }
    </style>
@endsection
@section('content')
<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.booking.title') }}
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <legend>Booking Info</legend>
                @if(Auth::user()->getIsAdminAttribute())
                    <div class="form-group">
                        <label>Added by:</label>
                        {{ $booking->creator->first_name.' '.$booking->creator->last_name }}
                        (@foreach($booking->creator->roles as $key => $roles){{ $roles->title.(!$loop->last ? ', ' : '') }}@endforeach)
                    </div>
                    @if($booking->booking_status != 'pending')
                    <div class="form-group">
                        <label>{{ ucfirst($booking->booking_status) }} by:</label>
                        {{ $booking->editor->first_name.' '.$booking->editor->last_name }}
                        (@foreach($booking->editor->roles as $key => $roles){{ $roles->title.(!$loop->last ? ', ' : '') }}@endforeach)
                    </div>
                    @endif
                @endif
                <div class="form-group">
                    <label>Booking Status:</label>
                    {!! $booking->getBookingStatus() !!}
                </div>
                @if($booking->booking_status == 'declined')
                <div class="form-group">
                    <label>Decline Reason:</label>
                    {{ $booking->decline_reason }}
                </div>
                @elseif($booking->booking_status == 'canceled')
                <div class="form-group">
                    <label>Reason of cancellation:</label>
                    {{ $booking->reason_of_cancellation }}
                </div>
                <div class="form-group">
                    <label>Other Reasons:</label>
                    {{ $booking->other_reasons }}
                </div>
                @endif
                <div class="form-group">
                    <label>Booking Date:</label>
                    {{ date('F d, Y  h:i A', strtotime($booking->booking_date_from)) }}
                    -
                    {{ date('F d, Y  h:i A', strtotime($booking->booking_date_to)) }}
                </div>
                <div class="form-group">
                    <label>Walk In: </label>
                    {!! $booking->is_walk_in ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>' !!}
                </div>
                <div class="form-group">
                    <label>Required Reservation Fee (30% of total amount):</label>
                    ₱ {{ number_format(($booking->amount * 0.3), 2) }}
                </div>
                <div class="form-group">
                    <label>Amount:</label>
                    ₱ {{ number_format($booking->amount, 2) }}
                </div>
                <div class="form-group">
                    <label>Room:</label>
                    <a href="{{ route('admin.rooms.show', $booking->room->id) }}">{{ $booking->room->name }}</a>
                </div>
                <div class="form-group">
                    <label>Name:</label>
                    {{ $booking->client->getFullName('fnf') ?? "" }}
                </div>
                <div class="form-group">
                    <label>Email:</label>
                    {{ $booking->client->email }}
                </div>
                <div class="form-group">
                    <label>Contact #:</label>
                    {{ $booking->client->contact_number }}
                </div>
                <div class="form-group">
                    <label>Type of Identification:</label>
                    {{ $booking->type_of_identification }}
                </div>
                <div class="form-group">
                    <label>Proof of identity:</label>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#viewProofOfIdentity">View Image</button>
                    <div class="modal fade" id="viewProofOfIdentity" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable modal-md" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Proof of Identity</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body text-center">
                                    <img src="{{ asset($booking->proofOfIdentity()) }}" class="img-thumbnail">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <legend>Payment Info</legend>
                <div class="form-group">
                    <label>Payment Status:</label>
                    {!! $booking->getPaymentStatus() !!}
                </div>
                <div class="form-group">
                    <label>Amount Paid:</label>
                    ₱ {{ number_format($booking->payments->sum('amount'), 2) }}
                </div>
                <div class="form-group">
                    <label>Balance:</label>
                    ₱ {{ number_format(($booking->amount-$booking->payments->sum('amount')), 2) }}
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <a class="btn btn-default" href="{{ route('admin.bookings.index') }}">
            {{ trans('global.back_to_list') }}
        </a>
        <a class="btn btn-primary" href="{{ route('admin.bookings.edit', $booking->id) }}">Edit</a>
        @if($booking->booking_status == 'pending')
        <a class="btn btn-success" href="{{ route('admin.bookings.confirm', $booking->id) }}">Confirm Booking</a>
        <a class="btn btn-danger" href="{{ route('admin.bookings.cancel', $booking->id) }}">Cancel Booking</a>
        {{-- <a class="btn btn-danger" href="{{ route('admin.bookings.decline', $booking->id) }}">Decline Booking</a> --}}
        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#declineBookingModal">Decline Booking</button>
        @elseif($booking->booking_status == 'confirmed')
        <a class="btn btn-success" href="{{ route('admin.bookings.check_in', $booking->id) }}">Client Checked In</a>
        <a class="btn btn-danger" href="{{ route('admin.bookings.cancel', $booking->id) }}">Cancel Booking</a>
        @endif
        @if($booking->booking_status == 'checked in')
        <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#extendModal">Extend</button>
        <a class="btn btn-primary" href="{{ route('admin.bookings.checkout', $booking->id) }}">Check Out</a>
        @endif
    </div>
</div>

@includeIf('admin.bookings.relationships.bookingPayments', ['payments' => $booking->payments])
{{-- <div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#booking_payments" role="tab" data-toggle="tab">
                Payments
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="booking_payments">
            @includeIf('admin.bookings.relationships.bookingPayments', ['payments' => $booking->payments])
        </div>
    </div>
</div> --}}

<div id="modalAjax"></div>
<div id="modalOpenData"></div>

@if($booking->booking_status == 'checked in')
<form action="{{ route('admin.bookings.extend', $booking->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="modal fade" id="extendModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Extend Booking</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="checkinDate" value="{{ date('Y-m-d', strtotime(Carbon\Carbon::parse($booking->booking_date_from)->subDays(1))) }}">
                    <input type="hidden" id="roomAmount" value="{{ $booking->room->amount }}">
                    <input type="hidden" id="amountPaid" value="{{ $booking->payments->sum('amount') }}">
                    <div class="form-group">
                        <label class="required" for="booking_date">Check out date</label>
                        <input type="date" class="form-control" name="checkout_date" id="checkoutDate" min="{{ date('Y-m-d', strtotime(Carbon\Carbon::parse($booking->booking_date_from)->addDays(1))) }}" required onchange="showAmount()">
                    </div>
                    <div class="form-group">
                        <label>Amount:</label>
                        <span id="totalAmount"></span>
                    </div>
                    <div class="form-group">
                        <label>Amount Paid:</label>
                        <span id="totalAmountPaid"></span>
                    </div>
                    <div class="form-group">
                        <label>Balance:</label>
                        <span id="totalAmountBalance"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    {{-- <a class="btn btn-danger" href="{{ route('admin.bookings.decline', $booking->id) }}">Decline Booking</a> --}}
                    <button class="btn btn-success" type="submit"> Save</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endif
@if($booking->booking_status == 'pending')
<form action="{{ route('admin.bookings.decline', $booking->id) }}" method="POST">
    @csrf
    <div class="modal fade" id="declineBookingModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Decline Booking</h5>
                    <button type="button" class="close" data-dismiss="modal-ajax" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="">Reason</label>
                                <select class="form-control" name="decline_reason" id="">
                                    <option value="">-- select --</option>
                                    <option value="Unclarify indentity">Unclarified indentity</option>
                                    <option value="Unclarify indentity">Fully booked</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal-ajax">Cancel</button>
                    {{-- <a class="btn btn-danger" href="{{ route('admin.bookings.decline', $booking->id) }}">Decline Booking</a> --}}
                    <button class="btn btn-success" type="submit"> Decline Booking</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endif
@endsection
@section('scripts')
    <script>
        function showAmount(){
            var amount = $('#roomAmount').val()
            var amountPaid = $('#amountPaid').val()
            
            var checkInDate = parseDate($('#checkinDate').val())
            var checkOutDate = parseDate($('#checkoutDate').val())
            var numDays = datediff(checkInDate, checkOutDate)
            var totalAmount = parseFloat(amount * numDays).toFixed(2);
            console.log('totalAmount: '+totalAmount)
            console.log('amountPaid: '+amountPaid)
            console.log(totalAmount - amountPaid)
            $('#totalAmount').text('₱ '+ totalAmount)
            $('#totalAmountPaid').text('₱ '+ parseFloat(amountPaid).toFixed(2))
            $('#totalAmountBalance').text('₱ '+ parseFloat(totalAmount - amountPaid).toFixed(2))
        }

        function parseDate(str) {
            var mdy = str.split('-');
            return new Date(mdy[0], mdy[1], mdy[2]);
        }

        function datediff(checkInDate, checkOutDate) {
            return Math.round((checkOutDate-checkInDate)/(1000*60*60*24));
        }
    </script>
@endsection