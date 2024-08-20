<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderSlipHeader as ResourcesOrderSlipHeader;
use App\Models\OrderSlipDetail;
use App\Models\OrderSlipHeader;
use App\Services\PrintItemPerLocationService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReprintOrderInKitchenController extends Controller
{
    protected $printItemPerLocationService;

    public function __construct()
    {
        $this->printItemPerLocationService = new PrintItemPerLocationService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        try{
            DB::beginTransaction();

            $osd = OrderSlipDetail::with(['product'])
                ->where('OSNUMBER', $request->orderslip_number)
                // ->where('CONFIRMED_AT', null)
                ->get();

            $os_resource = ResourcesOrderSlipHeader::make(
                OrderSlipHeader::where('OSNUMBER', $request->orderslip_number)->first()
            );

            $result =$this->printItemPerLocationService->handle(
                $request->orderslip_number,
                $osd,
                'REPRINT',
                json_decode( $os_resource->toJson() )->tables
            );

            if(!$result['success']){
                DB::rollBack();
                return response()->json([
                    'message' => $result['message']
                ], 400);
            }

            DB::commit();
            return response()->json([
                'message' => 'Ok',
            ]);
        }catch(Exception $e){
            DB::rollBack();
            return response()->json([
                'message' => 'SERVER ERROR',
                'systemMessage' => $e->getMessage()
            ], 500);
        }
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
