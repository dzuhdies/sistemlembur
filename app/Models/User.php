<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'division_id',
    ];

    public function division()
    {
        return $this->belongsTo(Divisi::class);
    }

    // lembur ketika dia sebagai staff
    public function staffOvertimes()
    {
        return $this->hasMany(Overtime::class, 'staff_id');
    }

    // lembur yang dia ajukan sebagai leader
    public function leaderOvertimes()
    {
        return $this->hasMany(Overtime::class, 'leader_id');
    }
}
