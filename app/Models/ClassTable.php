<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassTable extends Model
{
    protected $table = 'class';
    protected $guarded = ['id'];
    use HasFactory;

    public function user()
    {
        return $this->hasOne(User::class);
    }
    public function pengeluaran()
    {
        return $this->hasMany(Pengeluaran::class);
    }
    public function pemasukan()
    {
        return $this->hasMany(Pemasukan::class);
    }
    public function history_activites()
    {
        return $this->hasMany(History_activities::class);
    }
    public function user_leave()
    {
        return $this->hasMany(UserLeave::class);
    }
}
