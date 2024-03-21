<?php

namespace App\Http\Controllers;

use App\Models\ScheduledClass;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function create() {
        //Write complex queries and create query scopes
       // $scheduledClasses = ScheduledClass::where('date_time', '>', now())
       $scheduledClasses = ScheduledClass::upcoming()
            ->with('classType', 'instructor')
            // ->whereDoesntHave('members', function($query){
            //     $query->where('user_id', auth()->user()->id);
            // })
            ->notBooked()
            ->oldest('date_time')->get();
        return view('member.book')->with('scheduledClasses', $scheduledClasses);
    }


    // many to many relationship --> attach and detach
    public function store(Request $request) {
        auth()->user()->bookings()->attach($request->scheduled_class_id);

        return redirect()->route('booking.index');
    }

    public function index() {
        // $bookings = auth()->user()->bookings()->where('date_time', '>', now())->get();
        $bookings = auth()->user()->bookings()->upcoming()->get();

        return view('member.upcoming')->with('bookings',$bookings);
    }

    public function destroy(int $id) {
        auth()->user()->bookings()->detach($id);

        return redirect()->route('booking.index');
    }
}
