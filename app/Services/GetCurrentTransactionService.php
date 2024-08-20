<?php

namespace App\Services;

use App\Http\Resources\OrderSlipHeader as ResourcesOrderSlipHeader;
use App\Models\OrderSlipHeader;

class GetCurrentTransactionService
{

    /**
     * @param int $branch_id
     * @param string $user_id
     * @return array
     */
    public function handle($branch_id, $user_id):array
    {

        $item = OrderSlipHeader::where('BRANCHID', $branch_id)
            ->where('USER_CURRENT_TRANSACTION', $user_id)
            ->first();

        if (!$item) {
            return [
                'success' => false,
                'message' => 'Resource not found'
            ];
        }

        return [
            'success' => true,
            'message' => 'Ok',
            'data' => $item->toArray()
        ];
    }
}
