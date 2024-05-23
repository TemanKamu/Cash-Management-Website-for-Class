<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mail_box extends Model
{
    use HasFactory;
    protected $table = 'mail_box';
    protected $guarded = ['id'];

     public function user()
    {
        return $this->belongsTo(User::class);
    }
}
