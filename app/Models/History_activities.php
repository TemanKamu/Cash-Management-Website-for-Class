<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History_activities extends Model
{
    protected $table = 'history_activities';
    protected $guarded = ['id'];
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function class()
    {
        return $this->belongsTo(ClassTable::class);
    }
}
