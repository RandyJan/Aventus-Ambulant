<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

function getClarionDate(\Carbon\Carbon $date){
    $start_date = '1801-01-01';
    $start_from = \Carbon\Carbon::parse($start_date);
    $diff = $date->diffInDays($start_from) + 4;
    return $diff;
}

function osNumberGenerator($branch_id, $device_id, Carbon $date, $orderslip_id){

    $device = str_pad($device_id, 2, "0", STR_PAD_LEFT);
    $orderslip = str_pad($orderslip_id, 5, "0", STR_PAD_LEFT);

    $output = "{$branch_id}{$device}-{$date->format('ymd')}{$orderslip}";

    return $output;
}

function computeDuration(Carbon $start, $end){

    // Log::debug('dates', [
    //     $start,
    //     $end
    // ]);
    // return 'test';

    if($end == null){
        return '--:--:--';
    }

    $end = Carbon::parse($end);

    $hours = $start->diffInHours($end);
    $minutes = $start->diffInMinutes($end) % 60;
    $seconds = $start->diffInSeconds($end) % 60;

    $formatted =  "{$hours}:$minutes:{$seconds}";
    Log::debug($formatted);
    return $formatted;
}

function checkPing($ip = '127.0.0.1'){
    exec("ping -n 1 $ip", $outputs,  $status);

    $result = true;

    foreach($outputs as $output){
        if( Illuminate\Support\Str::contains($output, ['Destination host unreachable', 'Request timed out'] ) ){
            $result = false;
        }
    }

    return $result;
}
