<?php

namespace App\Services;

use App\Models\OrderSlipHeader;
use App\Models\OrderslipTable;
use App\Models\TableFile;
use Illuminate\Support\Facades\Log;

class UpdateTheTableInOrderslip {

    /**
     * @param String $os_number
     * @return Array
     */
    public function handle(
        String $os_number
    ){


        $os = OrderSlipHeader::where('OSNUMBER', $os_number)->first();

        if(!$os){
            return [
                'success' => false,
                'message' => 'Orderslip No. not  found.'
            ];
        }

        // check orderslip table for existing tagged table
        $os_table = OrderslipTable::where('ORDERLIPNO', $os->ORDERSLIPNO)
            ->where('BRANCHID', $os->BRANCHID)
            ->where('OUTLETID', $os->OUTLETID)
            ->where('DEVICENO', $os->DEVICENO)
            ->first();

        // if has
        if($os_table){

            // get table info
            $table = TableFile::where('BRANCH_ID', $os_table->BRANCHID)
                ->where('TABLE_ID', $os_table->TABLENO)
                ->first();

            Log::debug('TABLE', [$table->toArray()]);

            // update the orderslip header TABLENO
            OrderSlipHeader::where('OSNUMBER', $os_number)
                ->update([
                    'TABLENO' => $table->TABLENO
                ]);
        }else{
            // make the TABLENO in orderslipheader null/empty
            OrderSlipHeader::where('OSNUMBER', $os_number)
                ->update([
                    'TABLENO' => null
                ]);
        }

        return [
            'success' => true,
            'message' => 'Ok'
        ];
    }
}
