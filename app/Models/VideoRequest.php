<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id', 'video_id', 'status', 'request_date',
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function video()
    {
        return $this->belongsTo(Video::class);
    }

    public function access()
    {
        return $this->hasOne(Access::class, 'request_id');
    }
}
