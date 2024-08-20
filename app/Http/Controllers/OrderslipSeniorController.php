<?php

namespace App\Http\Controllers;

use App\Models\OrderslipSenior;
use App\Services\UpdateSCHeadcountService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderslipSeniorController extends Controller
{
    protected $updateSCHeadcountService;
    public function __construct()
    {
        $this->updateSCHeadcountService = new UpdateSCHeadcountService;
    }

    public function store(Request $request){
         // dd($request->all());
         try{
            DB::beginTransaction();

            $sequence = OrderslipSenior::getSequence(
                $request->os_number,
            );

            OrderslipSenior::create([
                'ID'  => $request->os_number . '-' . $sequence,
                'BRANCH_ID' => $request->branch_id,
                'OSNUMBER' => $request->os_number,
                'SEQUENCE' => $sequence,
                'SC_ID' => $request->sc_id,
                'SC_NAME' => $request->sc_name,
                'SC_ADDRESS' => $request->sc_address,
            ]);

            // $this->updateSCHeadcountService->handle(
            //     $request->os_number,
            //     $request->branch_id
            // );

            DB::commit();
            return response()->json([
                'message' => 'Ok',
            ]);
        }catch(Exception $e){
            DB::rollBack();
            return response()->json([
                'message' => 'SERVER ERROR',
                'system_message' => $e->getMessage()
            ], 500);
        }
    }

    public function update($id, Request $request){
         // dd($request->all());
         try{
            DB::beginTransaction();

            $sequence = OrderslipSenior::getSequence(
                $request->os_number,
            );

            OrderslipSenior::where('ID', $id)
            ->update([
                'SC_ID' => $request->sc_id,
                'SC_NAME' => $request->sc_name,
                'SC_ADDRESS' => $request->sc_address,
            ]);

            // $this->updateSCHeadcountService->handle(
            //     $request->os_number,
            //     $request->branch_id
            // );

            DB::commit();
            return response()->json([
                'message' => 'Successfully updated.',
            ]);
        }catch(Exception $e){
            DB::rollBack();
            return response()->json([
                'message' => 'SERVER ERROR',
                'system_message' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id, Request $request){
         // dd($request->all());
         try{
            DB::beginTransaction();

            $os_sc = OrderslipSenior::where('ID', $id)->first();

            OrderslipSenior::where('ID', $id)->delete();

            // $this->updateSCHeadcountService->handle(
            //     $os_sc->OSNUMBER,
            //     $os_sc->BRANCH_ID
            // );

            DB::commit();
            return response()->json([
                'message' => 'Ok',
            ]);
        }catch(Exception $e){
            DB::rollBack();
            return response()->json([
                'message' => 'SERVER ERROR',
                'system_message' => $e->getMessage()
            ], 500);
        }
    }
}
