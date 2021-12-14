<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class Payment extends Model
{
    use Userstamps;
    
    protected $table = 'payments';

    protected $fillable = [
        'proof_of_payment',
        'booking_id',
        'payment_status',
        'mode_of_payment',
        'amount',
        'created_at',
        'updated_at',
    ];

    public function booking()
    {
        return $this->belongsTo('App\Models\Booking', 'booking_id');
    }

    public function getPaymentStatus()
    {
        $status = "";
        switch ($this->payment_status) {
            case 'pending':
                $status = '<span class="badge badge-warning">Pending</span>';
                break;
            case 'confirmed':
                $status = '<span class="badge badge-success">Confirmed</span>';
                break;
            case 'denied':
                $status = '<span class="badge badge-danger">Denied</span>';
                break;
        }
        return $status;
    }
}
