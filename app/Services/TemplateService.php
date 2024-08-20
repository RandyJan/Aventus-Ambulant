<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\DB;

class TemplateService {

    /**
     * @return array
     */
    public function handle(
    ):array
    {
        try{
            DB::beginTransaction();


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
