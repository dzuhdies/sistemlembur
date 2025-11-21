<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Overtime extends Model
{
    use HasFactory;

    protected $fillable = [
        'staff_id',
        'leader_id',
        'approved_by',
        'tanggal',
        'mulai_jam',
        'selesai_jam',
        'total_jam',
        'alasan',
        'status',
    ];

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    public function leader()
    {
        return $this->belongsTo(User::class, 'leader_id');
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
