<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Contract;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BillBulkController extends Controller
{
    public function createBulkBills(Request $request, Contract $contract)
    {
        $start = Carbon::parse($request->input('start_date'));
        $end = Carbon::parse($request->input('end_date'));
        $months = $start->diffInMonths($end) + 1;
        $day = (int) $request->input('due_day');
        
        for ($i = 0; $i < $months; $i++) {
            $dueDate = $start->copy()->addMonths($i)->day($day);
            $monthName = $dueDate->format('F');
            $billName = $request->input('name') . ' - ' . $monthName;
            
            Bill::create([
                'name' => $billName,
                'description' => $request->input('description'),
                'value' => $request->input('value'),
                'status' => 'pending',
                'contract_id' => $contract->id,
                'type' => 'monthly',
                'due_date' => $dueDate,
            ]);
        }

        return redirect()->back()->with('success', 'Cobranças criadas com sucesso!');
    }
}
