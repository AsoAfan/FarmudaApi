<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


//    protected $with = ['questions'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'otp_secret',
        'otp_expires_at',
        'otp_secret_slug',
        'otp_attempt_count',
        'email_verified_at',
        'latest_otp_attempt',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'otp_secret',
        'otp_expires_at',
        'otp_secret_slug',
        'email_verified_at',
        'otp_attempt_count',
        'latest_otp_attempt',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];


    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function favourites()
    {
        return $this->hasMany(Favourite::class);
    }

    public function setPassworAttribute()
    {

        return $this->attributes['password'] = Hash::make($this->attributes['password']);

    }

    /*

    public function setLatestOtpAttemptAttribute($value){
        return $this->attributes['latest_otp_attempt'] = \Carbon\Carbon::createFromFormat('Y-m-d', $this->attributes['latest_otp_attempt']);
    }
    */

}
