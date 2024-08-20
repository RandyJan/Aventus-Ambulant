<?php

namespace App\Http\Controllers;

use App\Http\Resources\CustomerCollection;
use App\Models\Customers;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $vendors = Customers::isVendor()
            ->active()
            ->stallCodeNotEmpty()
            ->where(function ($q) use ($request) {
                if (is_numeric($request->search)) {
                    $q->where('CUSTOMERID', $request->search)
                        ->orWhere('STALLCODE', 'LIKE', "%{$request->search}%")
                        ->orWhere('NAME', 'LIKE', "%{$request->search}%");
                }

                $q->Where('STALLCODE', 'LIKE', "%{$request->search}%")
                    ->orWhere('NAME', 'LIKE', "%{$request->search}%");
            })
            ->get();

        return response()->json([
            'data' => new CustomerCollection($vendors)
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
        if (!is_numeric($id)) {
            abort(404);
        }

        $vendor = Customers::isVendor()
            ->active()
            ->stallCodeNotEmpty()
            ->where('CUSTOMERID', $id)
            ->first();

        if (!$vendor) {
            abort(404);
        }

        return view('pages.vendor', compact('vendor'));
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
