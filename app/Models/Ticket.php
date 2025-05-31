<?php

namespace App\Models;

use App\Enums\TicketSeverity;
use App\Enums\TicketStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'created_by',
        'assigned_to',
        'department_id',
        'severity',
        'status',
    ];

    protected $casts = [
        'status' => TicketStatus::class,
        'severity' => TicketSeverity::class,
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function remarks()
    {
        return $this->hasMany(Remark::class);
    }
}
