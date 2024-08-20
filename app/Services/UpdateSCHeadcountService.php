<?php

namespace App\Services;

use App\Models\OrderSlipHeader;
use App\Models\OrderslipSenior;
use Exception;
use Illuminate\Support\Facades\DB;

class UpdateSCHeadcountService {

    /**
     * @param String $os_number
     * @param Integer $branch_id
     * @return array
     */
    public function handle(
        $os_number,
        $branch_id
    ):array
    {
        try{
            DB::beginTransaction();

            $items = OrderslipSenior::where('OSNUMBER', $os_number)
                ->where('BRANCH_ID', $branch_id)
                ->get();

            OrderSlipHeader::where('OSNUMBER', $os_number)
                ->update([
                    'TOTALHEADCOUNT' => $items->count()
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
