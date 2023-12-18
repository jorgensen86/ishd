<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Email extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $guarded = [];

    public function queue() {
        return $this->hasOne(Queue::class, 'id', 'queue_id');
    }

    public function ticket_number() {
        return $this->morphOne(TicketNumber::class, 'ticketable', 'model_type', 'model_id');
    }

    public function getSentAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d/m/Y H:i');
    }
}
