<?php
// app/Models/Access.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Access extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_id', 'access_start_time', 'access_end_time',
    ];

    public function videoRequest()
    {
        return $this->belongsTo(VideoRequest::class, 'request_id');
    }
}
