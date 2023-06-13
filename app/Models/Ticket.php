<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $appends = [
        'date_added'
    ];

    protected $fillable = [
        'is_opened',
    ];

    protected $with = [
        'user',
        'replies'
    ];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:m',
        'updated_at' => 'datetime:d-m-Y H:m',
    ];

    public function user() {
        return $this->hasOne(User::class, 'user_id', 'author_id');
    }

    public function replies() {
        return $this->hasMany(Reply::class, 'ticket_id', 'id');
    }

    protected function dateAdded(): Attribute
    {
        return new Attribute(
            get: fn () => $this->created_at->diffForHumans()
        );
    }
}
