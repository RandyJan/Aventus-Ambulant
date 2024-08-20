<?php

namespace App\Http\Controllers\Api;
use App\Models\OrderSlipDetail as OSDetail;
use App\Models\OrderSlipHeader as OSHeader;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiOrderSlipController extends Controller
{
    //
    public function AddNewJobOrder(Request $request){
            $username = env('USER_NAME');
            $password = env("PASSWORD");
            $auth_key = 'Basic' + base64_encode($username.':'.$password);

            if($request->header('Authorization','default') == $auth_key){
                try{
                    OSHeader::insert([
                        "ORDERSLIPNO"=>$request['ORDERSLIPNO'],
                        "BRANCHID"=>$request['ORDERSLIPNO'],
                        "OUTLETID"=>$request['OUTLETID'],
                        "DEVICENO"=>$request['DEVICENO'],
                        "STATUS"=>'x',
                        "DISPLAYMONITOR"=>2,
                        "ENCODEDBY"=>$request['ENCODEDBY'],
                        "PREPAREDBY"=>$request['PREPAREDBY'],
                        "CCENAME"=>$request['CCENAME'],
                        "TRANSACTTYPEID"=>1,
                        "OSDATE"=>null,
                        "ORIGINALINVOICEDATE"=>null,
                        "ENCODEDDATE"=>null,
                        "PAID"=>0,
                        "USER_CURRENT_TRANSACTION"=>$request['USER_CURRENT_TRANSACTION'],
                        "BUSDATE"=>null,
                        "TOTALAMOUNT"=>$request['TOTALAMOUNT'],
                        "NETAMOUNT"=>$request['NETAMOUNT'],
                        "IS_SC"=>$request['IS_SC'],
                        "ACCOUNTTYPE"=>$request['ACCOUNTTYPE'],
                        "OSTYPE"=>$request['OSTYPE'],
                   


                    ]);
                }
                catch(\Illuminate\Database\QueryException $e){

                }
            }
    }
}
