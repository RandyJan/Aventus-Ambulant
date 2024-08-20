<?php

namespace App\Http\Controllers;

use App\Services\ShiftCreatorService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShiftController extends Controller
{
    protected $shiftSrvc;

    public function __construct()
    {
        $this->shiftSrvc = new ShiftCreatorService;
    }

    public function openShift(Request $request){
        try{
            DB::beginTransaction();

            // shift services
            $shift = $this->shiftSrvc->handle(
                $request->branch_id,
                $request->outlet_id,
                $request->terminal_id,
                Auth::user()->NUMBER,
            );


            DB::commit();
            return response()->json([
                'message' => 'Successfully Open the Shift',
                'data' => $shift['data'] ['current']
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
