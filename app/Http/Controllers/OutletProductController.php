<?php

namespace App\Http\Controllers;

use App\Http\Resources\PartLocation as ResourcesPartLocation;
use App\Http\Resources\PartLocationCollection;
use App\Models\PartLocation;
use Illuminate\Http\Request;

class OutletProductController extends Controller
{
    public function index(Request $request){
        $items = PartLocation::with('part')
            ->where('GROUP', '!=', '')
            ->when($request->branch_id, function($q) use($request){
                $q->where('BRANCHID',  $request->branch_id );
            })
            ->when($request->outlet_id, function($q) use($request){
                $q->where('OUTLETID', $request->outlet_id );
            })
            ->when($request->category, function($q) use($request){
                $q->where('CATEGORY', $request->category);
            })
            ->when($request->group, function($q) use($request){
                $q->where('GROUP', $request->group);
            })
            ->when($request->exclude_zero_price, function($q){
                $q->where('retail', '>', 0);
            })
            ->when($request->include_zero_price, function($q){
                $q->where('retail', '>=', 0);
            })
            ->when($request->search, function($q) use($request){
                $q->where('DESCRIPTION', 'LIKE', "%$request->search%");
            })
            ->where('STATUS','A')
            ->orderby('SHORTCODE', 'asc')
            ->paginate($request->limit);

        return new PartLocationCollection($items);
    }

    public function show($product_id, Request $request){
        $item = PartLocation::with('part')
            ->where('PRODUCT_ID', $product_id)
            ->when($request->branch_id, function($q) use($request){
                $q->where('BRANCHID',  $request->branch_id );
            })
            ->when($request->outlet_id, function($q) use($request){
                $q->where('OUTLETID', $request->outlet_id );
            })
            ->when($request->category, function($q) use($request){
                $q->where('CATEGORY', $request->category);
            })
            ->when($request->group, function($q) use($request){
                $q->where('GROUP', $request->group);
            })
            ->when($request->exclude_zero_price, function($q){
                $q->where('retail', '>', 0);
            })
            ->when($request->include_zero_price, function($q){
                $q->where('retail', '>=', 0);
            })
            ->first();

        return new ResourcesPartLocation($item);
    }
}
