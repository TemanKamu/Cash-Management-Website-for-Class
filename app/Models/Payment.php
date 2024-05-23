<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Nonstandard\Uuid;

class Payment extends Model
{
    use HasFactory;
    protected $table = 'payment';
    protected $guarded = ['id'];
    // protected static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($model) {
    //         try {
    //             $model->uuid = Uuid::uuid4()->toString();
    //         } catch (Exception $e) {
    //             abort(500, $e->getMessage());
    //         }
    //     });
    // }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function pemasukan(){
        return $this->belongsTo(Pemasukan::class);
    }
}
