<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\Branch;
use App\Http\Resources\Outlet;
use App\Http\Resources\Terminal as ResourcesTerminal;
use App\Http\Resources\User as ResourcesUser;
use App\Models\Outlet as ModelsOutlet;
use App\Models\Shift;
use App\Models\Terminal;
use App\Models\User;
use App\Services\ShiftCreatorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    protected $shiftSrvc;

    public function __construct()
    {
        $this->shiftSrvc = new ShiftCreatorService;
    }

    public function login(LoginRequest $request)
    {
        $user = User::findByUsername($request->username)->first();

        if (is_null($user)) {
            return response()->json([
                'message' => 'User not found'
            ], 400);
        }

        if (trim($user->PW) != $request->password) {
            return response()->json([
                'message' => 'Invalid Password'
            ], 400);
        }

        $terminal = Terminal::where('SERIALNO', $request->device_serial)->first();

        if (!$terminal) {
            return response()->json([
                'message' => 'Device serial not found.'
            ], 400);
        }

        $device = $user->devices()
            ->where('DEVICENO', $terminal->ID)
            // ->where('BRANCHID', $terminal->STATIONCODE)
            ->first();

        if (!$device) {
            return response()->json([
                'message' => 'We cannot find this device that has been assigned to you.'
            ], 400);
        }

        Auth::login($user);

        return response()->json([
            'message' => 'Successfully Login',
            'data' => [
                'user' => new ResourcesUser($user),
                'branch' => new Branch($device->branch),
                'terminal' => new ResourcesTerminal($device->terminal),
                'outlet' => new Outlet($device->outlet),
                // 'shift' => [
                //     'todays_date' => now()->format('Y-m-d'),
                //     'current' => $shift,
                // ],
            ]
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        if(!$request->ajax()){
            return redirect()->route('login');
        }

        return response()->json([
            'message' => 'Successfully Logout'
        ]);
    }
}
