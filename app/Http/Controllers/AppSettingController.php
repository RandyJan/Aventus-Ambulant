<?php

namespace App\Http\Controllers;

use App\Models\Terminal;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class AppSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        // Log::debug('device', [
        //     $request->all(),
        //     $request->device_id
        // ]);

        $show_header_logo_in_print_preview = false;
        $show_qr_code_in_print_preview = false;
        $service_charge_percentage = 0;

        if( isset($request->device_id) && $request->device_id != null ){
            $terminal = Terminal::where('ID', $request->device_id)->first();

            if($terminal){
                // Log::debug($terminal->CUTE);
                if($terminal->CUTE == 1 || $terminal->CUTE == '1'){
                    $show_header_logo_in_print_preview = true;
                    $show_qr_code_in_print_preview = true;
                }


                if(isset($terminal->SERVICE_CHARGE)){
                    $service_charge_percentage = (float)$terminal->SERVICE_CHARGE;
                }
            }
        }


        return response()->json([
            'data' => [
                'app_name'  => config('app.name'),
                'app_type'  => config('settings.app_type'),
                'work_shifting' => config('settings.work_shifting'),
                'customer_display' => config('settings.customer_display'),
                'plate_number_entry' => config('settings.plate_number_entry'),
                'show_header_logo_in_print_preview' => $show_header_logo_in_print_preview,
                'show_qr_code_in_print_preview' => $show_qr_code_in_print_preview,
                'table_assignment'=>config('settings.table_assingment'),
                'service_charge' => config('settings.service_charge'),
                'service_charge_percentage' => $service_charge_percentage,
            ],
            'message' => 'Ok'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
