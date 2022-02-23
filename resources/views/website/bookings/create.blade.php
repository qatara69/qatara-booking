<form action="{{ route('client_bookings.store') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
    @csrf
    <div class="modal fade" id="addBooking" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Booking</h5>
                    <button type="button" class="close" data-dismiss="modal-ajax" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            {{-- <strong class="text-danger">Business hours is from 8:00AM to 5:00PM</strong> --}}
                            <div class="form-group">
                                <label>Booking Date (Check in/Check out date)</label>
                                <input type="text" class="form-control" name="book_date" id="bookDate" {{-- value="{{ $book_date }}" --}}>
                            </div>
                            <div class="form-group">
                                <label>Room Type</label>
                                <select name="room_type" id="roomType" class="form-control select2" required style="width: 100%">
                                    <option></option>
                                    @foreach ($room_types as $room_type)
                                        <option value="{{ $room_type->id }}">{{ $room_type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Room</label>
                                <select name="room" id="rooms" class="form-control select2" required style="width: 100%">
                                    <option></option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Proof of Identity</label>
                                <select name="type_of_identification" class="form-control select2" required style="width: 100%">
                                    <option></option>
                                    <option value="Valid Driver's License">Valid Driver's License</option>
                                    <option value="State-issued Identification Card">State-issued Identification Card</option>
                                    <option value="Student Identification Card">Student Identification Card</option>
                                    <option value="Social Security Card">Social Security Card</option>
                                    <option value="Military Identification Card">Military Identification Card</option>
                                    <option value="Passport">Passport</option>
                                </select>
                                <div class="row justify-content-center">
                                    <div class="form-group col-md-6">
                                        <img id="img" width="100%" class="img-thumbnail" style="border: none; background-color: transparent" src="{{ asset('images/image-icon.png') }}" />
                                        <label class="btn btn-primary btn-block">
                                            Browse&hellip;<input value="" type="file" name="proof_of_identity" style="display: none;" id="upload" accept="image/png, image/jpeg" required/>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <legend>Room Info:</legend>
                            <div id="roomInfo" style="display: none">
                                <div class="form-group">
                                    <img class="img-thumbnail" src="" alt="" id="roomImage">
                                </div>
                                <div class="form-group">
                                    <label for="">Name:</label>
                                    <span id="roomName"></span>
                                </div>
                                <div class="form-group">
                                    <label for="">Description:</label>
                                    <span id="roomDescription"></span>
                                </div>
                                <div class="form-group">
                                    <label for="">Amount:</label>
                                    <span id="roomAmount"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal-ajax">Cancel</button>
                    <button class="btn btn-default text-success" type="button" data-toggle="modal" data-target="#termsAndCondition"><i class="fas fa-save"></i> Save</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Terms and condition --}}
    <div class="modal fade" id="termsAndCondition" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Terms and Condition</h5>
                    <button type="button" class="close" data-dismiss="modal" data-target="#termsAndCondition" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <ol>
                                <li>
                                    The resort is only authorized to accommodate properly registered guests. For this purpose, guests are to present their valid national ID card or passport, and any other valid proof of identity to the front desk employee.
                                </li>
                                <li>
                                    Settlement of bills : Bills must be settled upon arrival by payment in cash, cheques are not accepted.
                                </li>
                                <li>
                                    Guests are to use their rooms for the agreed period. If the guest breaks their stay, no refund will be made. If the period of accommodation is not stipulated in advance, guests are to check out by agreed period and they are obliged to have the room vacated by this time.
                                </li>
                                <li>
                                    Please be advised to keep valuables in your personal rooms. Keep doors locked closed when not inside or when sleeping. The resort will not in any whatsoever, be responsible for the loss of guests belongings or any other property.
                                </li>
                                <li>
                                    On the basis of advanced booking the resort is to charge the guest a Reservation Fee : 30% of the total amount of bill to be deposited via gcash or personal appearance in the resort.
                                    <br>
                                    Cancellation Policy:
                                    <ul>
                                        <li>
                                            Full refund reservation fee : 15 working days prior to the scheduled date
                                        </li>
                                        <li>
                                            50% refund reservation fee : less than 7-15 working days
                                        </li>
                                        <li>
                                            Forfeiture of deposit : less than 7 working days prior to arrival date or any fortuitous events.
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    Rebooking Policy : Rebooking must be done 15 working days prior to the date of arrival otherwise rebooking may not be permitted. Guests can only rebooked once.
                                </li>
                                <li>
                                    Early check-in/Late check-out privileges are subject to availability. For Late arrival, the guest must inform the resort personnel at least 2 hours in advance through chat, text or call. Failure to do so, rooms will be released and reservation fee will be forfeited. For NO SHOW : there will be no refund.
                                </li>
                                <li>
                                    Keys must be deposited/returned at the reception desk whenever guests leave the premises and at the time of check out. We charge 1,000 for any lost keys.
                                </li>
                                <li>
                                    Management Rights: The management reserves for itself the absolute right of admission to any person in the resort premises and to request any guest to vacate his or her room at any moment without previous notice and without assigning any reasons whatsoever the guest shall be bound to vacate when requested to do so. This will only happen if the person(s) occupying the rooms are disturbing the place or/and the safety of the  resort, personnel or other guests.
                                </li>
                                <li>
                                    Guests may not move furnishings or interfere with the electrical network or any other installations in the rooms or on the premises of the resort without the  consent of the management. If any malfunction is discovered during your stay please report this to any personnel on duty.
                                </li>
                                <li>
                                    If the guest becomes ill or injured, the resort can help with the provision of medical assistance or, as the case may be, to arrange for the guest to be taken to hospital, all at the guest expense.
                                </li>
                                <li>
                                    Upon departing, guests are obliged to turn off all water faucets, lights in the rooms and its facilities as well as the air-con units and to shut the door as they leave. Keep the door and windows closed when the air-con is working.
                                    No Smoking allowed for the safety reasons.                                    
                                </li>
                                <li>
                                    No Littering Policy: All guests are required to Clean As They Go by disposing garbage properly, clean the dishes and maintain the cleanliness of the whole premises at all times.
                                </li>
                                <li>
                                    No Vandalism and Horse Play. Guests are obliged to pay for any loss or damage of the resort property caused by themselves, friends or any persons whom they are responsible.
                                </li>
                                <li>
                                    No Pets Allowed.
                                </li>
                                <li>
                                    Minors under 18 years old, male or female, are not allowed to stay at this Resort without being accompanied by their parents or guardians.
                                </li>
                                <li>
                                    Guests are obliged to observe the provisions of these terms and conditions. In the event that a Guest is in breach of these rules, the Resort has the right to repudiate the agreement on the provision of accommodation services before the agreed period has elapsed.
                                </li>
                            </ol>
                            <hr>
                            <div class="form-group">
                                <input type="checkbox" id="agree">
                                <label for="agree">Agree on Terms and Condition</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" data-target="#termsAndCondition">Cancel</button>
                    <button class="btn btn-default text-success" type="submit" id="submitBtn" disabled><i class="fas fa-save"></i> Submit</button>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    $(function(){
        $('#agree').change(function(){
            if($(this).is(':checked')){
                $('#submitBtn').prop('disabled', false)
            }else{
                $('#submitBtn').prop('disabled', true)
            }
        })
    })

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var base_url = '{{ URL::to('') }}';
    $('#roomType').on('change', function(){
        var id = $(this).val();
        $.ajax({
            type:'POST',
            url: base_url+'/filter_rooms',
            data: {
                book_date: $('#bookDate').val(),
                room_type: id,
            },
            success:function(data){
                $('#rooms').html(data.room_options);
            },
            error:function (data){
                console.log('error')
                /* Swal.fire({
                    // position: 'top-end',
                    type: 'error',
                    title: 'error',
                    showConfirmButton: false,
                    toast: true
                }); */
            }
        });
    });

    // Room Info
    $('#rooms').on('change', function(){
        var base_url = '{{ URL::to('') }}';
        var id = $(this).val();
        $.ajax({
            type:'GET',
            url: base_url+'/get_room_info/' + id,
            /* data: {
                room_id: id
            }, */
            success:function(data){
                $('#roomImage').attr('src', data.room_image);
                $('#roomName').html(data.room.name)
                $('#roomDescription').html(data.room.description)
                $('#roomAmount').html('₱ ' + data.room.amount + "/night")
                $('#roomInfo').fadeIn()
            },
            error:function (data){
                console.log('error')
                Swal.fire({
                    // position: 'top-end',
                    type: 'error',
                    title: 'error',
                    showConfirmButton: false,
                    toast: true
                });
            }
        });
    });

    $(function(){
        $('input[name="book_date"]').daterangepicker({
            // timePicker: true,
            startDate: '{{ $date_from }}',
            endDate: '{{ $date_to }}',
            minDate: "{{ date('Y/m/d h:i A') }}",
            // endDate: moment().startOf('hour').add(32, 'hour'),
            locale: {
                format: 'Y/M/DD'
            }
        });

        $('.drp-calendar .right').find('.calendar-time').fadeOut();

        // Clear room type, rooms, and room info when date is changed
        $('input[name="book_date"]').change(function(){
            $('#roomInfo').fadeOut();
            $("#roomType").val('').trigger('change')
            $('#rooms').html('<option></option>');
            $('#rooms').select2({
                placeholder: "Select",
            });
            $("#rooms").val('')
        })
    })

    // Image upload
    $(function(){
            $('#upload').change(function(){
                var input = this;
                var url = $(this).val();
                var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
                if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) 
                {
                    var reader = new FileReader();
                    
                    reader.onload = function (e) {
                        $('#img').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            });
        });
</script>