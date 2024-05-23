<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Channel_payout extends Model
{
    protected $table = 'channel_payout';
    use HasFactory;

    public function payout()
    {
        return $this->hasMany(Payout::class);
    }
}
