<?php

namespace App\Services;

use App\Models\Shift;

class ShiftCreatorService
{
    /**
     * @param int $branch_id
     * @param int $outlet_id
     * @param int $terminal_id
     * @param string $employee_number
     * @return array
     */
    public function handle(
        $branch_id, $outlet_id, $terminal_id, $employee_number = null
    ):array
    {

        $latest_posted_shift =  Shift::where('branch_id', $branch_id)
            ->where('outlet_id', $outlet_id)
            ->where(function($q){
                $q->where('day_posted_at', '<=', now()->format('Y-m-d'))
                    ->orWhere('day_posted', 0);
            })
            ->where('shift_posted', 1)
            ->orderBy('shift_count', 'desc')
            ->first();

        $latest_non_posted_shift =  Shift::where('branch_id', $branch_id)
            ->where('outlet_id', $outlet_id)
            ->where(function($q){
                $q->where('day_posted_at', '<=', now()->format('Y-m-d'))
                    ->orWhere('day_posted', 0);
            })
            ->where('shift_posted', 0)
            ->orderBy('shift_count', 'desc')
            ->first();

        $my_non_posted_shift =  Shift::where('branch_id', $branch_id)
            ->where('outlet_id', $outlet_id)
            ->where('employee_number', $employee_number)
            ->where('terminal_id', $terminal_id)
            ->where('shift_posted', 0)
            ->first();

        $shift = null;

        if( !$latest_posted_shift && !$latest_non_posted_shift && !$my_non_posted_shift){
            $shift = Shift::create([
                'branch_id' => $branch_id,
                'outlet_id' => $outlet_id,
                'terminal_id' => $terminal_id,
                'employee_number' => $employee_number,
                'business_date' => now()->format('Y-m-d'),
                'shift_count' => 1,
            ]);
        }

        if($my_non_posted_shift){
            return [
                'success' => true,
                'message' => 'Ok',
                'data' => [
                    'todays_date' => now()->format('Y-m-d'),
                    'current' => $my_non_posted_shift->toArray(),
                ]
            ];
        }

        if($latest_posted_shift && $latest_non_posted_shift){

            if( $latest_posted_shift->shift_count >= $latest_non_posted_shift->shift_count){
                $shift = Shift::create([
                    'branch_id' => $branch_id,
                    'outlet_id' => $outlet_id,
                    'terminal_id' => $terminal_id,
                    'employee_number' => $employee_number,
                    'business_date' => $latest_posted_shift->business_date != now()->format('Y-m-d') ? $latest_posted_shift->business_date : now()->format('Y-m-d'),
                    'shift_count' => $latest_posted_shift->shift_count + 1,
                ]);
            }

            if( $latest_non_posted_shift->shift_count > $latest_posted_shift->shift_count){
                $shift = Shift::create([
                    'branch_id' => $branch_id,
                    'outlet_id' => $outlet_id,
                    'terminal_id' => $terminal_id,
                    'employee_number' => $employee_number,
                    'business_date' => $latest_non_posted_shift->business_date != now()->format('Y-m-d') ? $latest_non_posted_shift->business_date : now()->format('Y-m-d'),
                    'shift_count' => $latest_non_posted_shift->shift_count,
                ]);
            }


        }

        if($latest_non_posted_shift && !$latest_posted_shift){
            $shift = Shift::create([
                'branch_id' => $branch_id,
                'outlet_id' => $outlet_id,
                'terminal_id' => $terminal_id,
                'employee_number' => $employee_number,
                'business_date' => now()->format('Y-m-d'),
                'shift_count' => $latest_non_posted_shift->shift_count,
            ]);
        }

        return [
            'success' => true,
            'message' => 'Ok',
            'data' => [
                'todays_date' => now()->format('Y-m-d'),
                'current' => $shift->refresh()->toArray(),
            ]
        ];
    }
}
