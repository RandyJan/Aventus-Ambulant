<?php

namespace App\Services;

use App\Models\OrderSlipHeader;
use Exception;
use Illuminate\Support\Facades\DB;

class RemoveCurrentTransactionService {

    /**
     * @param int $branch_id
     * @param string $user_id
     * @return array
     */
    public function handle(
        $branch_id, $user_id
    ):array
    {
        try{
            DB::beginTransaction();

            OrderSlipHeader::where('BRANCHID', $branch_id)
                ->where('USER_CURRENT_TRANSACTION', $user_id)
                ->update([
                    'USER_CURRENT_TRANSACTION' => null,
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
                'message' => $e->getMessage()
            ];
        }

    }
}
