<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessLog extends Model
{
    use HasFactory;

    protected $fillable = ['accessor_id', 'accessed_id'];

    public function accessor()
    {
        return $this->belongsTo(User::class, 'accessor_id');
    }

    public function accessed()
    {
        return $this->belongsTo(User::class, 'accessed_id');
    }
}
