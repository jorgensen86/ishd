<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $with = [
        'user'
    ];

    protected $fillable = [
        'author_id',
        'body'
    ];

    public function user() {
        return $this->hasOne(User::class, 'user_id', 'author_id');
    }
}
