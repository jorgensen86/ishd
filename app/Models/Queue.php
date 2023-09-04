<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'active'
    ];

    protected $with = [
        'subject',
    ];

    public function subject() {
        return $this->belongsTo(Subject::class, 'queue_id', 'id');
    }

    public function tickets() {
        return $this->hasMany(Ticket::class, 'queue_id', 'id');
    }
}
