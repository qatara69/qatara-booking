<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Qatara Family Resort | Admin</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" />

    <style>
        .filter-data .form-group {
            margin-bottom: 0px
        }
        .filter-data label {
            font-weight: bold
        }
    </style>
</head>
<body {{-- onload="window.print()" --}}>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h4>Payment Report</h4>
                <p>{{ date('F d, Y') }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 filter-data">
                <div class="form-group">
                    <label>Payment Date: </label>
                    {{ is_null($payment_date) ? "*" : date('F d, Y', strtotime(explode(' - ', $payment_date)[0])).' - '.date('F d, Y', strtotime(explode(' - ', $payment_date)[1])) }}
                </div>
                <div class="form-group">
                    <label>Clients: </label>
                    @if(!is_null($clients))
                        @forelse ($clients as $client)
                            {{ App\Models\User::find($client)->name() }}@if(!$loop->last), @endif
                        @empty
                        @endforelse
                    @else
                    *
                    @endif
                </div>
                <div class="form-group">
                    <label>Walk In: </label>
                    {!! is_null(request()->get('walk_in')) ? '✕' : '✓' !!}
                </div>
                <div class="form-group">
                    <label>Payment Status: </label>
                    @if(!is_null($payment_status))
                        @forelse ($payment_status as $payment_status)
                            {{ $payment_status }}@if(!$loop->last), @endif
                        @empty
                        *
                        @endforelse
                    @else
                    *
                    @endif
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-sm table-bordered">
                    <thead>
                        <tr>
                            <td></td>
                            <th>Client Name</th>
                            <th>Payment Status</th>
                            <th>Payment Date</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($payments as $index => $payment)
                        <tr>
                            <td>
                                {{ $index+1 }}
                            </td>
                            <td>
                                {{ $payment->booking->client->name() }}
                            </td>
                            <td>
                                {!! $payment->getPaymentStatus() !!}
                            </td>
                            <td>
                                {{ date('F d, Y h:i A', strtotime($payment->created_at)) }}
                            </td>
                            <td>
                                ₱ {{ number_format($payment->amount, 2) }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td class="text-center text-danger" colspan="5">*** EMPTY ***</td>
                        </tr>
                        @endforelse
                        <tr>
                            <td class="text-right" colspan="4">
                                Total
                            </td>
                            <th>
                                ₱ {{ number_format($payments->sum('amount'), 2) }}
                            </th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>