<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Nonstandard\Uuid;

class Payout extends Model
{
    use HasFactory;
    protected $table = "payout";
    protected $guarded = ["id"];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function channel()
    {
        return $this->belongsTo(Channel_payout::class);
    }
    public function pengeluaran()
    {
        return $this->belongsTo(Pengeluaran::class);
    }
}
