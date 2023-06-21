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
        return $this->hasOne(Subject::class, 'id', 'subject_id');
    }
}
