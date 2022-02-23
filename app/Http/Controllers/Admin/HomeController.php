<?php

namespace App\Http\Controllers\Admin;

use App\Models\Room;
use App\Models\RoomType;
use App\Models\Booking;
use Carbon\CarbonPeriod;
use App\Charts\BookingsChart;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Auth;

class HomeController
{
    public function index()
    {
        if(isset(Auth::user()->id)){
            $bookingsChart = new BookingsChart;
            $bookingsChart->height(400);

            $month = date('Y-m'/*, strtotime('2020-02-28')*/);
            $date = Carbon::parse('2020-02-28');
            $days = [];
            $dates = [];
		    $pendingBookings = collect([]);
		    $confirmedBookings = collect([]);
		    $checkedInBookings = collect([]);
		    $checkedOutBookings = collect([]);
		    $declinedBookings = collect([]);
            $canceledBookings = collect([]);
            
            for ($days_backwards = 7; $days_backwards >= 0; $days_backwards--) {
                // Could also be an array_push if using an array rather than a collection.
                $dates[] = date('M d', strtotime(today()->subDays($days_backwards)));
                $pendingBookings->push(Booking::whereDate('updated_at', today()->subDays($days_backwards))->where('booking_status', 'pending')->count());
                $confirmedBookings->push(Booking::whereDate('updated_at', today()->subDays($days_backwards))->where('booking_status', 'confirmed')->count());
                $checkedInBookings->push(Booking::whereDate('updated_at', today()->subDays($days_backwards))->where('booking_status', 'checked in')->count());
                $checkedOutBookings->push(Booking::whereDate('updated_at', today()->subDays($days_backwards))->where('booking_status', 'checked out')->count());
                $declinedBookings->push(Booking::whereDate('updated_at', today()->subDays($days_backwards))->where('booking_status', 'canceled')->count());
                $canceledBookings->push(Booking::whereDate('updated_at', today()->subDays($days_backwards))->where('booking_status', 'declined')->count());
            }

            $bookingsChart->labels($dates);
            $bookingsChart->dataset('Pending', 'bar', $pendingBookings)->backgroundColor('#ffc107')->color('#ffc107');
            $bookingsChart->dataset('Confirmed', 'bar', $confirmedBookings)->backgroundColor('#007bff')->color('#007bff');
            $bookingsChart->dataset('Checked In', 'bar', $checkedInBookings)->backgroundColor('#28a745')->color('#28a745');
            $bookingsChart->dataset('Checked Out', 'bar', $checkedOutBookings)->backgroundColor('#6c757d')->color('#6c757d');
            $bookingsChart->dataset('Canceled', 'bar', $declinedBookings)->backgroundColor('#dc3545')->color('#dc3545');
            $bookingsChart->dataset('Declined', 'bar', $canceledBookings)->backgroundColor('#ff851b')->color('#ff851b');
            $bookingsChart->options([
                'scales' => [
                    'yAxes' => [[
                        'gridLines' => [
                            'display' => true
                        ],
                        'ticks' => [
                            'stepSize' => 1,
                            // 'precision' => 0,
                            'suggestedMax' => 3,
                            'suggestedMin' => 0,
                            // 'max' => 5,
                            // 'max' => 0
                        ]
                    ]],
                    'xAxes' => [[
                        'gridLines' => [
                            'display' => true
                        ]
                    ]]
                ]
            ]);
            
            if(Auth::user()->getIsAdminAttribute()){
                $data = [
                    'pending_bookings' => Booking::where('booking_status', 'pending')->count(),
                    'confirmed_bookings' => Booking::where('booking_status', 'confirmed')->count(),
                    'checked_in_bookings' => Booking::where('booking_status', 'checked in')->count(),
                    'unpaid_bookings' => Booking::where('payment_status', 'unpaid')->count(),
                    'bookings' => Booking::get(),
                    'bookingsChart' => $bookingsChart,
                ];
                return view('home', $data);
            }elseif(Auth::user()->roles()->where('id', 2)->exists()){
                $data = [
                    'pending_bookings' => Booking::where('booking_status', 'pending')->count(),
                    'confirmed_bookings' => Booking::where('booking_status', 'confirmed')->count(),
                    'checked_in_bookings' => Booking::where('booking_status', 'checked in')->count(),
                    'unpaid_bookings' => Booking::where('payment_status', 'unpaid')->count(),
                    'bookings' => Booking::get(),
                    'bookingsChart' => $bookingsChart,
                ];
                return view('home', $data);
            }else{
                return redirect()->route('resort.index');
            }
        }else{
            return redirect()->route('resort.index');
        }
        
    }
}
