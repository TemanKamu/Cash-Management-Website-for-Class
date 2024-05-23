<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\ClassTable;

class Pengeluaran extends Model
{
    use HasFactory;
    protected $table = "pengeluaran";
    protected $guarded = ['id'];
    
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function class(){
        return $this->belongsTo(ClassTable::class);
    }
    public function pengeluaran(){
        return $this->hasOne(Pengeluaran::class);
    }
}
