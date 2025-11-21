<?php

namespace App\Http\Controllers;

use App\Models\Overtime;
use App\Models\Divisi;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    public function index()
    {
        $overtimes = Overtime::with(['staff', 'leader'])
            ->latest()
            ->get();

        return view('manager.index', compact('overtimes'));
    }

    public function updateStatus(Request $request, Overtime $overtime)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $overtime->update([
            'status'      => $request->status,
            'approved_by' => auth()->id(),
        ]);

        return back()->with('success', 'Status lembur berhasil diperbarui.');
    }

    public function report(Request $request)
    {
        $month = $request->input('month');

        $query = Overtime::with('staff')
            ->where('status', 'approved');

        if ($month) {
            $yearPart  = substr($month, 0, 4);
            $monthPart = substr($month, 5, 2);

            $query->whereYear('tanggal', $yearPart)
                  ->whereMonth('tanggal', $monthPart);
        }

        $report = $query
            ->selectRaw('staff_id, SUM(total_jam) as total_jam')
            ->groupBy('staff_id')
            ->get();

        return view('manager.report', compact('report', 'month'));
    }

    public function create()
    {
        $divisis = Divisi::all();

        return view('manager.newusers', compact('divisis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255|unique:users,name',
            'password'    => 'required|string|min:4|confirmed',
            'role'        => 'required|in:staff,leader,manager',
            'division_id' => 'nullable|exists:divisis,id',
        ]);

        User::create([
            'name'        => $request->name,
            'password'    => Hash::make($request->password),
            'role'        => $request->role,
            'division_id' => $request->division_id,
        ]);

        return redirect()
            ->route('manager.overtimes.index')
            ->with('success', 'Akun baru berhasil dibuat.');
    }
}