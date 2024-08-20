<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CloseDayController extends Controller
{
    public function closeDay(Request $request){
        try{
            DB::beginTransaction();

            $shift = Shift::find($request->shift_id);

            if($shift->day_posted == 1){
                return response()->json([
                    'message' => 'Close Day already posted',
                    'data' => $shift
                ]);
            }

            $shifts = Shift::where('branch_id', $shift->branch_id)
                ->where('outlet_id', $shift->outlet_id)
                ->where('business_date', $shift->business_date)
                ->get();

            foreach ($shifts as $key => $s) {
                # code...
                if($s->shift_posted == 0){
                    $s->update([
                        'shift_posted' => 1,
                        'shift_posted_at' => now(),
                        'day_posted' => 1,
                        'day_posted_at' => now(),
                        'day_posted_by' => $shift->employee_number
                    ]);
                }else{
                    $s->update([
                        'day_posted' => 1,
                        'day_posted_at' => now(),
                        'day_posted_by' => $shift->employee_number
                    ]);
                }
            }

            DB::commit();
            return response()->json([
                'message' => 'Successfully Closed the day!',
            'data' => $shift->fresh(),
            ]);
        }catch(Exception $e){
            DB::rollBack();
            return response()->json([
                'message' => 'SERVER ERROR',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
