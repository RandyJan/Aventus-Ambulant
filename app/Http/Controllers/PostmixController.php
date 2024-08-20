<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostmixCollection;
use App\Models\Postmix;
use Illuminate\Http\Request;

class PostmixController extends Controller
{
    public function index(Request $request){
        $items = Postmix::with(['childPart'])
            ->when($request->display_only, function($q){
                $q->where('DISPLAY', 1);
            })
            ->when($request->product_id, function($q) use($request){
                $q->where('PRODUCT_ID', $request->product_id);
            })
            ->paginate($request->limit);

        return new PostmixCollection($items);
    }
}
