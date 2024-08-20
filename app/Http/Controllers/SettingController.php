<?php

namespace App\Http\Controllers;

use App\Http\Resources\Branch;
use App\Http\Resources\Outlet;
use App\Http\Resources\Terminal as ResourcesTerminal;
use App\Models\Terminal;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function settings(Request $request)
    {

        $terminal = Terminal::where('SERIALNO', $request->device_serial)->first();

        if (!$terminal) {
            return response()->json([
                'message' => 'Device serial not found.'
            ], 400);
        }

        $payload = [
            'message' => 'Changes has been saved',
            'data' => [
                'terminal' => new ResourcesTerminal($terminal),
                'branch' => new Branch($terminal->branch),
                // 'outlet' => new Outlet($terminal->outlet)
            ]
        ];

        if( in_array( config('settings.app_type'), ['restaurant_ambulant', 'shell_ambulant'] ) ){
            $payload['data']['outlet'] = new Outlet($terminal->outlet);
        }

        return response()->json($payload);
    }
}
