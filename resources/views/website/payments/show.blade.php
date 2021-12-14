<div class="modal fade" id="showPayment" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog {{-- modal-dialog-centered  --}}modal-md modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Payment</h5>
                <button type="button" class="close" data-dismiss="modal-ajax" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if(Auth::user()->getIsAdminAttribute())
                    <div class="form-group">
                        <label>Added by:</label>
                        {{ $payment_show->creator->first_name.' '.$payment_show->creator->last_name }}
                        (@foreach($payment_show->creator->roles as $key => $roles){{ $roles->title.(!$loop->last ? ', ' : '') }}@endforeach)
                    </div>
                    <div class="form-group">
                        <label>{{ ucfirst($payment_show->payment_status) }} by:</label>
                        {{ $payment_show->editor->first_name.' '.$payment_show->editor->last_name }}
                        (@foreach($payment_show->editor->roles as $key => $roles){{ $roles->title.(!$loop->last ? ', ' : '') }}@endforeach)
                    </div>
                @endif
                @if($payment_show->payment_status == 'confirmed')
                <div class="form-group">
                    <label>Date Confirmed:</label>
                    {{ date('F d, Y h:i A', strtotime($payment_show->updated_at)) }}
                </div>
                <div class="form-group">
                    <label>Amount:</label>
                    ₱ {{ number_format($payment_show->amount, 2) }}
                </div>
                <div class="form-group">
                    <label>Mode of payment:</label>
                    {{ $payment_show->mode_of_payment }}
                </div>
                @endif
                @if($payment_show->mode_of_payment == 'gcash')
                <hr>
                <div class="form-group text-center">
                    <img src="{{ asset('images/proof-of-payments/'.$payment_show->proof_of_payment) }}" class="img-thumbnail">
                </div>
                @endif
            </div>
        </div>
    </div>
</div>