<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Overtime;
use Carbon\Carbon;

class LeaderController extends Controller
{
    public function index()
    {
        $overtimes = Overtime::with(['staff', 'manager'])
            ->where('leader_id', auth()->id())
            ->latest()
            ->get();

        return view('leader.index', compact('overtimes'));
    }

    public function create()
    {
        $staffs = User::where('role', 'staff')
            ->where('division_id', auth()->user()->division_id)
            ->get();

        return view('leader.create', compact('staffs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'staff_id'   => 'required|exists:users,id',
            'date'       => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time'   => 'required|date_format:H:i|after:start_time',
            'reason'     => 'required|string',
        ], [
            'end_time.after' => 'Jam selesai lembur harus lebih besar dari jam mulai.',
        ]);

        $start = strtotime($request->start_time);
        $end = strtotime($request->end_time);

        $totalMinutes = ($end - $start) / 60;

        if ($totalMinutes <= 0) {
            return back()
                ->withErrors(['end_time' => 'Jam selesai harus lebih besar dari jam mulai.'])
                ->withInput();
        }

        Overtime::create([
            'staff_id'     => $request->staff_id,
            'leader_id'    => auth()->id(),
            'tanggal'      => $request->date,
            'mulai_jam'    => $request->start_time,
            'selesai_jam'  => $request->end_time,
            'total_jam'    => $totalMinutes,
            'alasan'       => $request->reason,
            'status'       => 'pending',
            'approved_by'  => null,
        ]);


        return redirect()->route('leader.overtimes.index')
            ->with('success', 'Pengajuan lembur berhasil dibuat!');
    }
}
