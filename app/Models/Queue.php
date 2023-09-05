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

    public function subjects() {
        return $this->hasMany(Subject::class);
    }

    public function tickets() {
        return $this->hasMany(Ticket::class, 'queue_id', 'id');
    }
}
