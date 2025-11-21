<?php

namespace App\Http\Controllers;

use App\Models\Overtime;

class StaffController extends Controller
{
    public function index()
    {
        $overtimes = Overtime::with(['leader', 'manager'])
            ->where('staff_id', auth()->id())
            ->latest()
            ->get();

        return view('staff.index', compact('overtimes'));
    }
}
