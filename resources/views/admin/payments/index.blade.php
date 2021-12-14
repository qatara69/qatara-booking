@extends('layouts.admin')
@section('styles')
    <link rel="stylesheet" href="{{ asset('website/plugins/daterangepicker/daterangepicker.css') }}">
    <style>
        .filter-data .form-group {
            margin-bottom: 0px
        }
    </style>
@endsection
@section('content')
<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#filterOptions">
            Filter
        </button>
        @if(Auth::user()->getIsAdminAttribute())
        <a class="btn btn-primary" href="{{ route("admin.payments.print_report", [
            'payment_date' => request()->get('payment_date'),
            'walk_in' => request()->get('walk_in'),
            'clients' => request()->get('clients'),
            'payment_status' => request()->get('payment_status')
        ]) }}" target="_blank">
            Print Report
        </a>
        @endif
    </div>
</div>
<div class="card">
    <div class="card-header">
        {{ trans('cruds.payment.title_singular') }} {{ trans('global.list') }}
    </div>
    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Payment">
            <thead>
                <tr>
                    <th width="10"></th>
                    <th>ID</th>
                    {{-- <th>Client Name</th> --}}
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Status</th>
                    <th>Amount</th>
                    <th>Payment Date</th>
                    <th></th>
                </tr>
            </thead>
            @if(request()->get('filter') == 1)
            <tbody>
                @forelse ($payments as $payment)
                <tr>
                    <td>&nbsp;</td>
                    <td>
                        {{ $payment->id }}
                    </td>
                    <td>
                        {{ $payment->booking->client->first_name }}
                    </td>
                    <td>
                        {{ $payment->booking->client->last_name }}
                    </td>
                    <td>
                        {!! $payment->getPaymentStatus() !!}
                    </td>
                    <td>
                        {{ $payment->amount }}
                    </td>
                    <td>
                        {{ date('Y-d-m H:i', strtotime($payment->created_at)) }}
                    </td>
                    <td>
                        {{ view('partials.datatablesActions', [
                            'viewGate' => 'payment_show',
                            'editGate' => 'payment_edit',
                            'deleteGate' => 'payment_delete',
                            'crudRoutePart' => 'payments',
                            'row' => $payment])}}
                    </td>
                </tr>
                @empty
                @endforelse
            </tbody>
            @endif
        </table>
    </div>
</div>
<form action="{{ route("admin.payments.index") }}" method="GET">
    {{-- @csrf --}}
    <input type="hidden" name="filter" value="1">
    <div class="modal fade" id="filterOptions" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Filter</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>Payment Date</label>
                                <input type="text" class="form-control" name="payment_date" id="paymentDate" value="{{ request()->get('payment_date') }}" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="#clients">Client</label>
                                <select name="clients[]" id="clients" class="form-control select2" multiple>
                                    <option></option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}" {{ !is_null(request()->get('clients')) ? (in_array($client->id ,request()->get('clients')) ? 'selected' : '') : '' }}>
                                            {{ $client->name() }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="walkIn" name="walk_in" value="1" {{ !is_null(request()->get('walk_in')) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="walkIn">Walk In</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Payment Status</label>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="confirmed" name="payment_status[]" value="confirmed" {{ !is_null(request()->get('payment_status')) ? (in_array('confirmed' ,request()->get('payment_status')) ? 'checked' : '') : '' }}>
                                    <label class="form-check-label" for="confirmed">Confirmed</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="denied" name="payment_status[]" value="denied" {{ !is_null(request()->get('payment_status')) ? (in_array('denied' ,request()->get('payment_status')) ? 'checked' : '') : '' }}>
                                    <label class="form-check-label" for="denied">Denied</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    @if(request()->get('filter') == 1)
                    <a class="btn btn-primary" href="{{ route('admin.payments.index') }}">Reset Filter</a>
                    @endif
                    <button class="btn btn-success" type="submit">Submit</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
@section('scripts')
{{-- @parent --}}
<script src="{{ asset('website/plugins/daterangepicker/moment.min.js') }}"></script>
<script src="{{ asset('website/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script>

    $(function(){

        $('#paymentDate').daterangepicker({
            @if(!is_null(request()->get('payment_date')))
            startDate: '{{ explode(' - ',request()->get('payment_date'))[0] }}',
            endDate: '{{ explode(' - ',request()->get('payment_date'))[1] }}',
            @endif
            autoUpdateInput: false,
            locale: {
                format: 'Y/M/DD',
                cancelLabel: 'Clear'
            },
        });

        $("#paymentDate").on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('Y/M/DD') + ' - ' + picker.endDate.format('Y/M/DD'));
        });

        $("#paymentDate").on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });
    })

    $(function () {
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
        @can('payment_delete')
        let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
        let deleteButton = {
            text: deleteButtonTrans,
            url: "{{ route('admin.payments.massDestroy') }}",
            className: 'btn-danger',
            action: function (e, dt, node, config) {
                var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
                    return entry.id
                });

                if (ids.length === 0) {
                    alert('{{ trans('global.datatables.zero_selected') }}')
                    return
                }

                if (confirm('{{ trans('global.areYouSure') }}')) {
                    $.ajax({
                    headers: {'x-csrf-token': _token},
                    method: 'POST',
                    url: config.url,
                    data: { ids: ids, _method: 'DELETE' }})
                    .done(function () { location.reload() })
                }
            }
        }
        dtButtons.push(deleteButton)
        @endcan

        @if(!request()->get('filter') == 1)
        let dtOverrideGlobals = {
            buttons: dtButtons,
            processing: true,
            serverSide: true,
            retrieve: true,
            aaSorting: [],
            ajax: "{{ route('admin.payments.index') }}",
            columns: [
                /* { data: 'placeholder', name: 'placeholder' },
                { data: 'id', name: 'id' },
                { data: 'payment_id', name: 'payment_status' },
                { data: 'payment_status', name: 'payment_status' },
                { data: 'client_name', name: 'client.clientname'},
                { data: 'room_name', name: 'room.name' },
                { data: 'amount_paid' },
                { data: 'balance' }, */
                /* { data: 'payment_date_from', name: 'payment_date_from' },
                { data: 'payment_date_to', name: 'payment_date_to' },
                { data: 'actions', name: '{{ trans('global.actions') }}' } */
                // { data: 'client_name', name: 'client.clientname'},
                // { data: 'payment_status', name: 'payment_status' },
                { data: 'placeholder', name: 'placeholder' },
                { data: 'id', name: 'id' },
                // { data: 'client_name', name: 'payment.client.clientname'},
                { data: 'client_first_name', name: 'payment.client.first_name'},
                { data: 'client_last_name', name: 'payment.client.last_name'},
                { data: 'payment_status', name: 'payment_status' },
                { data: 'amount', name: 'amount'},
                { data: 'payment_date', name: 'created_at' },
                { data: 'actions', name: '{{ trans('global.actions') }}' }

            ],
            order: [[ 1, 'desc' ]],
            pageLength: 100,
        };
        @elseif(request()->get('filter') == 1)
        let dtOverrideGlobals = {
            buttons: dtButtons
        };
        @endif
        $('.datatable-Payment').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
                $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
        });
    });

</script>
@endsection