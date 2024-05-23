<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Ramsey\Uuid\Uuid;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'uuid',
        'email',
        'password',
        'no_hp'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            try {
                $model->uuid = Uuid::uuid4()->toString();
            } catch (Exception $e) {
                abort(500, $e->getMessage());
            }
        });
    }

    public function class()
    {
        return $this->belongsTo(ClassTable::class);
    }
    public function pemasukan()
    {
        return $this->hasMany(Pemasukan::class);
    }
    public function pengeluaran()
    {
        return $this->hasMany(Pengeluaran::class);
    }
    public function mail_box()
    {
        return $this->hasMany(Mail_box::class);
    }
    public function payment()
    {
        return $this->hasMany(Payment::class);
    }
    public function payout()
    {
        return $this->hasMany(Payout::class);
    }
    public function history_activities()
    {
        return $this->hasOne(history_activities::class);
    }
    public function user_leave()
    {
        return $this->hasMany(UserLeave::class);
    }
    public function mailBox()
    {
        return $this->hasMany(Mail_box::class);
    }
}
