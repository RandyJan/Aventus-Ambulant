<?php

namespace App\Http\Controllers;

use App\Http\Resources\GroupCollection;
use App\Http\Resources\PartLocationCollection;
use App\Models\Group;
use App\Models\PartLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StoreController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $items = Group::where('BSUNITCODE', config('settings.stores'))
                ->paginate(50);

            return new GroupCollection($items);
        }

        return view('pages.stores');
    }

    public function showStoreProductsPage($store_slug, Request $request)
    {
        $store_slug = ucwords(str_replace('-', ' ', $store_slug));
        return view('pages.store-products', compact('store_slug'));
    }

    public function showStoreProductPage($store_slug, Request $request)
    {
        $store_slug = ucwords(str_replace('-', ' ', $store_slug));
        return view('pages.store-product', compact('store_slug'));
    }

    public function showStoreProducts($store_code, Request $request)
    {
        $items = PartLocation::with('part')
            ->where('BRANCHID',  $request->branch_id)
            ->where('OUTLETID', $request->outlet_id)
            ->where('GROUP', $store_code)
            ->where('retail', '>', 0)
            ->where('DESCRIPTION', 'LIKE', "%$request->search%")
            ->where('STATUS', 'A')
            ->orderby('SHORTCODE', 'asc')
            ->paginate($request->limit);

        return new PartLocationCollection($items);
    }
    
}
