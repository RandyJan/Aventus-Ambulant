<?php

namespace App\Http\Controllers;

use App\Models\OrderSlipHeader;
use App\Services\CartInformationService;
use App\Services\GetCurrentTransactionService;
use App\Services\RemoveCurrentTransactionService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CurrentTransactionController extends Controller
{
    protected $getCurrentTransactionSrvc;
    protected $removeCurrentTransactionSrvc;
    protected $cartSrvc;

    public function __construct()
    {
        $this->removeCurrentTransactionSrvc = new RemoveCurrentTransactionService;
        $this->getCurrentTransactionSrvc = new GetCurrentTransactionService;
        $this->cartSrvc = new CartInformationService;
    }

    public function currentTransaction(Request $request){
        try{
            DB::beginTransaction();

            $current_transaction = $this->getCurrentTransactionSrvc->handle(
                $request->branch_id,
                $request->user_id
            );

            if(!$current_transaction['success']){
                DB::rollback();
                return response()->json([
                    'message' => $current_transaction['message'],
                ], 400);
            }


            // cart information
            // Log::debug($current_transaction);
            // Log::debug($current_transaction['data']);
            $cart = $this->cartSrvc->handle($current_transaction['data']['OSNUMBER']);
            // Log::debug($cart);


            DB::commit();
            return response()->json([
                'message' => 'Ok',
                'data' => $cart['data']
            ]);
        }catch(Exception $e){
            DB::rollBack();
            return response()->json([
                'message' => 'SERVER ERROR',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function detachCurrentTransaction(Request $request){
        try{
            DB::beginTransaction();

            $this->removeCurrentTransactionSrvc->handle(
                $request->branch_id,
                $request->user_id,
            );

            DB::commit();
            return [
                'success' => true,
                'message' => 'Ok'
            ];
        }catch(Exception $e){
            DB::rollBack();
            return [
                'success' => false,
                'message' => 'SERVER ERROR',
                'system' => $e->getMessage()
            ];
        }
    }

    public function attachCurrentTransaction(Request $request){
        try{
            DB::beginTransaction();

            $this->removeCurrentTransactionSrvc->handle(
                $request->branch_id,
                $request->user_id,
            );

            OrderSlipHeader::where('OSNUMBER', $request->orderslip_number)
                ->update([
                    'USER_CURRENT_TRANSACTION' => $request->user_id
                ]);

            DB::commit();
            return [
                'success' => true,
                'message' => 'Ok'
            ];
        }catch(Exception $e){
            DB::rollBack();
            return [
                'success' => false,
                'message' => 'SERVER ERROR',
                'system' => $e->getMessage()
            ];
        }
    }

    public function markAsComplete(Request $request){
        try{
            DB::beginTransaction();

            OrderSlipHeader::where('OSNUMBER', $request->orderslip_number)
            ->update([
                'QDATE' => now()
            ]);

            $this->removeCurrentTransactionSrvc->handle(
                $request->branch_id,
                $request->user_id,
            );

            DB::commit();
            return [
                'success' => true,
                'message' => 'Ok'
            ];
        }catch(Exception $e){
            DB::rollBack();
            return [
                'success' => false,
                'message' => 'SERVER ERROR',
                'system' => $e->getMessage()
            ];
        }
    }
}
