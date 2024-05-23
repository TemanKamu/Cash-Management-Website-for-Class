<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Pemasukan extends Model
{
    use HasFactory;
    protected $table = "pemasukan";
    protected $guarded = ["id"];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function class()
    {
        return $this->belongsTo(ClassTable::class);
    }
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
