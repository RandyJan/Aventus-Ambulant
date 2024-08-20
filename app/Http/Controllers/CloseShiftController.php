<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use Illuminate\Http\Request;

class CloseShiftController extends Controller
{
    public function closeShift(Request $request){

        $shift = Shift::find($request->shift_id);

        if($shift->shift_posted == 1){
            return response()->json([
                'message' => 'Close Shift already posted',
                'data' => $shift
            ]);
        }

        Shift::where('employee_number', $shift->employee_number)
            ->where('branch_id', $shift->branch_id)
            ->where('outlet_id', $shift->outlet_id)
            ->where('business_date', $shift->business_date)
            ->where('shift_count', $shift->shift_count)
            ->update([
                'shift_posted' => 1,
                'shift_posted_at' => now()
            ]);

        // $shift = Shift::find($request->shift_id);

        return response()->json([
            'message' => 'Successfully Closed the Shift',
            'data' => $shift->fresh(),
        ]);
    }
}
