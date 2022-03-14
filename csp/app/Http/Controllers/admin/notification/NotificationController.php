<?php

namespace App\Http\Controllers\admin\notification;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $result = ["success" => false];

        $meetings = auth()->user()->my_meetings()->orderBy("date_time")->get()->filter(function ($meeting) {
            return $meeting->date_time > now();
        });

        $meeting = $meetings->first();

        if ($meeting) {
            $date = $meeting->date_time->toDateString();
            $time = $meeting->date_time->toTimeString();
            $diffMinute = $meeting->date_time->diffInMinutes(now());
            $customer = $meeting->customer;

            //$meeting->update(["date_time" =>now()->addMinutes(10)->toDateTimeString()]);

            if ($date == date("Y-m-d") && 0 <= $diffMinute && $diffMinute <= 5) {
                $result = [
                    "success" => true,
                    "title" => $customer->full_name,
                    "message" => "Bugün <b>$time</b> saatinde <b>$customer->full_name</b> ile randevunuz var"
                ];
            }
        }

        return response()->json($result);
    }
}
