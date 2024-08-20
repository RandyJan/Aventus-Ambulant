<?php

namespace App\Services;

use App\Http\Resources\OfficialReceipt as ResourcesOfficialReceipt;
use App\Models\OfficialReceipt;

class OfficialReceiptInformationService {

    public function handle($or_number) : array
    {

        $payload = [
            'form_of_payment' => [
                'cash' => '-',
                'check' => '-',
                'check_number' => '-',
                'check_date' => '-',
                'bank' => '-'
            ],
        ];
        $or = OfficialReceipt::where('GLHID', $or_number)->first();

        if(!$or){
            return [
                'success' => false,
                'message' => 'Official Receipt No. not found.'
            ];
        }

        $payload['header'] = json_decode( (new ResourcesOfficialReceipt($or))->toJson(), true );

        return [
            'success' => true,
            'data' => $payload
        ];
    }
}
